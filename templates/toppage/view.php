<?php
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="gm-custom-wrap">
    <div class="map-filter">
        <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#demo">特徴で絞り込む +</button>
        <div id="demo" class="gm-checkbox-group-wrap collapse">
            <?php
            foreach ($this->facility_records as $i => $record) {
                $checked = '';
                if (isset($this->filterDataArray[0])) {
                    foreach ($this->filterDataArray[0] as $item) {
                        if ($item == $record->ID)
                            $checked = 'checked';
                    };
                }

                echo '<label><input type="checkbox" name="facility_id" value="' . $record->ID . '"' . $checked . '  >' . $record->nm . '</label>';
            }
            ?>
            <div>
                <button class="btn btn-success" onclick="filterMap()">地図に表示</button>
                <button class="btn btn-warning" onclick="uncheckAll()">条件をクリアにする</button>
            </div>

        </div>
    </div>

    <script>
        function uncheckAll() {
            let allCheckbox = document.getElementsByName("facility_id");
            for (let i = 0; i < allCheckbox.length; i++) {
                if (allCheckbox[i].checked) {
                    allCheckbox[i].checked = false;
                }
            }
            let link = "<?= home_url('/') ?>";
            window.location.assign(link);
        }

        function filterMap() {
            let filterList = [];
            let allCheckbox = document.getElementsByName("facility_id");
            for (let i = 0; i < allCheckbox.length; i++) {
                if (allCheckbox[i].checked) {
                    filterList.push(i + 1);
                }
            }
            let link = "<?= home_url('/') ?>";
            console.log(filterList);
            if (filterList.length == 0) {
                window.location.assign(link);
            } else {
                window.location.assign(link + "/?filterList=" + filterList.toString());
            }

        }
    </script>

    <div id="map"></div>

    <!-- prettier-ignore -->
    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })({
            key: "<?= $this->apikey ?>",
            v: "weekly"
        });
    </script>
    <div class="post-garage-header">
        新着ガレージ
    </div>
    <div class="post-garage">
        <?php
        $active = "active";
        foreach ($this->recentList as $i => $record) {
            $img = explode(',', $record->imgs);
        ?>

            <div class="gm-card-1 ">
                <img class="img-fluid w-100" src="<?= wp_get_upload_dir()['baseurl'] ?>/gm-property/<?= $record->property_id ?>/<?= $img[0] ?>">
                <div class="gm-card-info__div">車庫名: <?php echo $record->nm ?></div>
                <div class="gm-card-info__div">価格: <?php echo $record->fee_monthly_rent ?></div>
                <?php
                $param = array('id' => $record->property_id);
                $link = add_query_arg($param, home_url('propertys'));
                ?>
                <div class="gm-mypage-add-button ml-20"><a href="<?= esc_url($link) ?>" class="gm-mypage-add-button ml-20">詳細を見る</a></div>
            </div>

        <?php
        }
        ?>
    </div>

    <div class="post-garage-header">
        PickUp!
    </div>
    <div class="post-garage">
        <?php
        $active = "active";
        foreach ($this->pickupList as $i => $record) {
            $img = explode(',', $record->imgs);
        ?>

            <div class="gm-card-1 ">
                <img class="img-fluid w-100" src="<?= wp_get_upload_dir()['baseurl'] ?>/gm-property/<?= $record->property_id ?>/<?= $img[0] ?>">
                <div class="gm-card-info__div">車庫名: <?php echo $record->nm ?></div>
                <div class="gm-card-info__div">価格: <?php echo $record->fee_monthly_rent ?></div>
                <?php
                $param = array('id' => $record->property_id);
                $link = add_query_arg($param, home_url('propertys'));
                ?>
                <div class="gm-mypage-add-button ml-20"><a href="<?= esc_url($link) ?>" class="gm-mypage-add-button ml-20">詳細を見る</a></div>
            </div>


        <?php
            if ($i == 3) {
                break;
            }
        }
        ?>
    </div>

    <div class="gm-help">
        <div class="gm-help1">
            <div class="gm-help1-desc">
                <div class="gm-help1-desc-img">
                    <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage1.png" alt="">
                </div>
                <div class="gm-help1-desc-text">
                    貸主模や管理会社の方自貪が決められた璽に物件情第!を入力し、<br>表示したい写真を指定するだけでこのようにmapで表示されます。<br> さらに、各物件詳細ページ,も自動で作成されます。<br>
                    •入力が•しい方幽けに、入力代行オプション网窟しております。
                </div>
            </div>
            <div class="gm-help1-property">
                <div class="gm-help1-property-header">各物件詳細ページサンプル</div>
                <div class="gm-help1-property-content">
                    <!-- 物件詳細 -->


                    <!-- 物件詳細 -->
                </div>
            </div>
            <div class="gm-help1-flow">
                <div class="gm-help1-flow-tap">
                    流れ
                </div>
                <div class="gm-help-flow-content">
                    1. 商品情報の入力 <br>
                    2. 物件掲戲 <br>
                    3. 契約希望者が 問い合わせ <br>
                    4. 契約お望者の 連絡先通師 <br>
                    5. 自分で契約または伸介を依頼
                </div>
            </div>
            <div class="gm-help1-steps">
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        1. 商品情報の入力
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage2.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        2. 物件掲戲<br><br>
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage5.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        3. 契約希望者が 問い合わせ
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage3.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        4. 契約お望者の 連絡先通師
                    </div>
                    <div class="gm-help1-steps-img">

                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        5. 自分で契約または伸介を依頼
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage4.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="gm-help2">

        </div>
        <div class="gm-help3">

        </div>
    </div>
</div>

<script>
    let data = [];
    <?php foreach ($this->filteredArray as $i => $records_map) { ?>
        data.push(<?= json_encode($records_map); ?>);
    <?php } ?>
    const properties = [];
    data.forEach(element => {
        let a = {
            ID: "",
            imgs: "",
            nm: "",
            fee_monthly_rent: 0,
            position: {
                lat: 1.01,
                lng: 1.01
            }
        };
        a.ID = element.ID;
        a.imgs = element.imgs;
        a.nm = element.nm;
        a.fee_monthly_rent = element.fee_monthly_rent;
        a.property_id = element.property_id;
        a.position.lat = parseFloat(element.lat);
        a.position.lng = parseFloat(element.lng);
        properties.push(a);
    });
    console.log(properties);

    async function initMap() {
        // Request needed libraries.
        document.cookie = "favorite=0;";
        console.log(document.cookie);
        const {
            Map
        } = await google.maps.importLibrary("maps");
        const {
            AdvancedMarkerElement
        } = await google.maps.importLibrary("marker");
        const center = {
            lat: 35.447227,
            lng: 136.756165
        };

        const map = new Map(document.getElementById("map"), {
            zoom: 11,
            center,
            mapId: "4504f8b37365c3d0",
        });

        for (const property of properties) {
            const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                map,
                content: buildContent(property),
                position: property.position,
                title: property.description,
            });

            AdvancedMarkerElement.addListener("click", () => {
                toggleHighlight(AdvancedMarkerElement, property);
            });

            google.maps.event.addListener(map, "click", function(event) {
                turnoffHighlight(AdvancedMarkerElement, property);
            });

        }
    }

    function toggleHighlight(markerView, property) {
        if (markerView.content.classList.contains("highlight")) {
            // markerView.content.classList.remove("highlight");
            // markerView.zIndex = null;
        } else {
            markerView.content.classList.add("highlight");
            markerView.zIndex = 1;
        }
    }

    function turnoffHighlight(markerView, property) {
        if (markerView.content.classList.contains("highlight")) {
            markerView.content.classList.remove("highlight");
            markerView.zIndex = null;
        } else {
            // markerView.content.classList.add("highlight");
            // markerView.zIndex = 1;
        }
    }

    function buildContent(property) {
        const content = document.createElement("div");
        const img_path = property.imgs.split(',');
        let desiredElement = [];
        img_path.forEach(item => {
            if (item !== "") {
                desiredElement.push(item);
            }
        });
        content.classList.add("property");
        content.innerHTML = `
            <div class="icon">
                <p class="icon-text">¥ ${property.fee_monthly_rent}</p>
            </div>
            <div class="details">
                
                <div class="gm-map-item">
                    <div class="gm-card-img">
                        <img src="<?= wp_get_upload_dir()['baseurl'] ?>/gm-property/${property.property_id}/${desiredElement[0]}" alt="img" onclick="handleDblClick(${property.property_id})">
                    </div>
                    <div class="gm-map-info" onclick="handleDblClick(${property.property_id})">
                        <div class="gm-card-info__div">車庫名: ${property.nm}</div>
                        <div class="gm-card-info__div">価格: ${property.fee_monthly_rent} 円</div>
                    </div>
                    <button class="heart" onclick="handleFavorite(${property.ID})"><i class="heart fa-solid fa-heart border-heart" id="heart${property.ID}"></i></button>
                </div>
            </div> `;

        return content;
    }


    initMap();

    function handleFavorite(id) {
        let a = getCookie("favorite");
        const element = document.getElementById("heart" + id);
        console.log(element);
        if (a.indexOf(id) == -1) {
            setCookie('favorite', id, 1, a);
            console.log(id);
            element.classList.remove("border-heart");
            element.classList.add("selected-heart");
            console.log(element[id]);

        } else {
            let ind = a.indexOf(id);
            deleteCookie('favorite', 365, a, ind);
            element.classList.remove("selected-heart");
            element.classList.add("border-heart");
        }

    }



    function handleDblClick(id) {
        var href = window.location.href;
        let link = "<?= home_url('/') ?>";
        window.location.assign(link + '/propertys/?id=' + id);
    }

    function setCookie(cname, cvalue, exdays, value) {
        value.push(cvalue);
        let b = value.toString();
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + b + ";" + expires + ";path=/";
        console.log(document.cookie);
    }

    function deleteCookie(cname, expires, value, indi) {
        const spliced = value.toSpliced(indi, 1);
        let b = spliced.toString();
        document.cookie = cname + "=" + b + ";" + expires + ";path=/";
        console.log(document.cookie);
    }

    function getCookie(cname) {
        let name = cname + "=";

        let decodedCookie = decodeURIComponent(document.cookie);

        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                let d = c.substring(name.length, c.length);
                let e = d.split(",");
                let numberArray = [];
                length = e.length;

                for (let i = 0; i < length; i++)
                    numberArray.push(parseInt(e[i]));

                return numberArray;
            }
        }
        return "";
    }
</script>