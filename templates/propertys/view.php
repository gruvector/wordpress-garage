<?php
if (! defined('ABSPATH')) {
    exit;
}
?>


<div class="gm-custom-wrap">
    <div class="">
        <?php foreach ($this->property_details as $i => $record) { 
            // function cube($n)
            // {
            //     echo('<div class="property-slide">
            //             <img src="'.wp_get_upload_dir()["baseurl"].'/gm-property/'.$record->property_id.'/'.$n.'">
            //         </div>');
            // }
            $img = explode(',',$record->imgs);

            
        ?>
            <div class="gm-img-property-slide">

                <div class="property-slider">
                    <?php foreach($img as $j=>$img_display){
                        // var_dump($img_display);
                        if ($img_display != "") {
                            echo ( ' <div class="property-slide">
                                <img src="'.wp_get_upload_dir()["baseurl"].'/gm-property/'.$record->property_id.'/'. $img_display.'">
                            </div>');
                        }
                    } ?>

                    <button class="btn-property-slide prev"><i class="fas fa-3x fa-chevron-circle-left"></i></button>
                    <button class="btn-property-slide next"><i class="fas fa-3x fa-chevron-circle-right"></i></button>
                
                </div>
                <div class="dots-container">
                    <span class="dot active" data-slide="0"></span>
                    <?php
                        for ($i=0; $i < count($img)-1; $i++) { 
                            echo('<span class="dot" data-slide="'.($i+1).'"></span>');
                        }
                    ?>
                </div>
            </div>


            <div class="gm-grid">
                <div class="gm-map" id="map">
                    <script>
                        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
                        ({key: "<?= $this->apikey ?>", v: "weekly"});
                    </script>
                </div>
                <div class="gm-basic-table">
                    <div class="gm-basic-table-section1">ガレージ名</div>
                    <div class="gm-basic-table-section2"><?= $record->nm ?></div>
                    <div class="gm-basic-table-section1">区画</div>
                    <div class="gm-basic-table-section2"><?= $record->section_nm ?></div>
                    <div class="gm-basic-table-section1">現況</div>
                    <div class="gm-basic-table-section2"><?php if ($record->availability_id) {echo "空き予定";} else {echo "使用中";}; ?></div>
                    <div class="gm-basic-table-section1">使用開始可能日</div>
                    <div class="gm-basic-table-section2"><?= $this->property_publish[0]->publish_from?></div>
                    <div class="gm-basic-table-section1">最低契約期間</div>
                    <div class="gm-basic-table-section2"><?= $record->min_period ?></div>
                    <div class="gm-basic-table-section1">サイズ</div>
                    <div class="gm-basic-table-section2"><?= "横幅".$record->size_w."m x 高さ".$record->size_h."m x 奥行".$record->size_d."m" ?></div>
                    <div class="gm-basic-table-section1">住所</div>
                    <div class="gm-basic-table-section2"><?= $record->address_1." ".$record->address_2." ".$record->address_3 ?></div>
                </div>
            </div>
            <div class="gm-character-table">
                <div class="gm-basic-table-section1">特徴</div>
                <div class="gm-basic-table-section2">
                    <?php
                        $facility_ids = explode(',', $record->facility_ids);
                        foreach ($this->property_special as $i => $record2) {
                            if (in_array($record2->ID, $facility_ids)){
                                echo $record2->nm.', ';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="gm-fee-month">
                <div class="gm-basic-table-section1 gm-border-right">毎月支払うもの</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section2">賃料</div>
                <div class="gm-basic-table-section2"><?= $record->fee_monthly_rent ?> 円</div>
                <div class="gm-basic-table-section2">共益費</div>
                <div class="gm-basic-table-section2"><?= $record->fee_monthly_common_service ?> 円</div>
                <div class="gm-basic-table-section2">その他<br>毎月支払う料金</div>
                <div class="gm-basic-table-section2">-電気代 <?= $record->fee_monthly_others ?>円<br>-振替手数料 <?= $record->fee_monthly_others ?>円</div>
            </div>
            <div class="gm-fee-month">
                <div class="gm-basic-table-section1 gm-border-right">特徴</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section2">敷金<br>※基本的に解約時に返金される</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_security ?> 円</div>
                <div class="gm-basic-table-section2">敷金償却<br>※支払う敷金のうち解約時に返金されない金額</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_security_amortization ?> 円</div>
                <div class="gm-basic-table-section2">保証金<br>※基本的に解約時に返金される</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_deposit ?> 円</div>
                <div class="gm-basic-table-section2">保証金償却<br>※解約時に返金されない保証金の金額</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_deposit_amortization ?> 円</div>
                <div class="gm-basic-table-section2">礼金<br>※返金されない金額</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_key_money ?> 円</div>
                <div class="gm-basic-table-section2">保証料<br>[保証会社加入料]</div>
                <div class="gm-basic-table-section3"><?= $record->fee_contract_guarantee_charge ?> 円</div>
                <div class="gm-basic-table-section2">その他<br>契約時のみ支払うもの</div>
                <div class="gm-basic-table-section3">契約手数料 <?= $record->fee_contract_other ?>円</div>
            </div>

            <div class="gm-special-term">
                <div class="gm-basic-table-section1 gm-border-right">特約事項</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section4"><?= $record->special_term ?></div>
            </div>
            <div class="gm-special-term2">
                <div class="gm-basic-table-section1 gm-border-right">アピールポイント、他の空き区画の紹介</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section4"><?= $record->other_description ?><br/><?= $record->appeal_description ?></div>
            </div>
            <div class="gm-input-button-wrap">
                <a class="gm-input-button" href="<?= home_url('contact-property').'?id='.$record->ID?>">お問い合わせ</a>
            </div>
        
    </div>
</div>


<script>
    let map 

    async function initMap() {
    // The location of Uluru

    const position = { lat: <?= $record->lat ?>, lng: <?= $record->lng ?> };
    // Request needed libraries.
    //@ts-ignore
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 13,
        center: position,
        mapId: "DEMO_MAP_ID",
    });

    // The marker, positioned at Uluru
    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        title: "Uluru",
    });
    }

    initMap();
</script>

<?php        
    }
?>

<script>
   
   function Slider() {
        const carouselSlides = document.querySelectorAll('.property-slide');
        const btnPrev = document.querySelector('.prev');
        const btnNext = document.querySelector('.next');
        const dotsSlide = document.querySelector('.dots-container');
        let currentSlide = 0;
    
        const activeDot = function (slide) {
            document.querySelectorAll('.dot').forEach(dot => dot.classList.remove('active'));
            document.querySelector(`.dot[data-slide="${slide}"]`).classList.add('active');
        };
        activeDot(currentSlide);

        const changeSlide = function (slides) {
            carouselSlides.forEach((slide, index) => (slide.style.transform = `translateX(${100 * (index - slides)}%)`));
        };
        changeSlide(currentSlide);

        btnNext.addEventListener('click', function () {
            currentSlide++; 
            if (carouselSlides.length - 1 < currentSlide) {
                currentSlide = 0;
            };
            changeSlide(currentSlide);
            activeDot(currentSlide);
    });
        btnPrev.addEventListener('click', function () {
            currentSlide--;
            if (0 >= currentSlide) {
                currentSlide = 0;
            }; 
            changeSlide(currentSlide);
            activeDot(currentSlide);
        });

        dotsSlide.addEventListener('click', function (e) {
            if (e.target.classList.contains('dot')) {
                const slide = e.target.dataset.slide;
                changeSlide(slide);
                activeDot(slide);
            }
        });
    };
    Slider();
    
</script>