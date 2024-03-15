<?php
if (! defined('ABSPATH')) {
    exit;
}
?>


<div class="container h-100">
    <div class="row mx-auto h-100">
        <div id="gallery" class="carousel slide w-100 align-self-center h-100" data-ride="carousel">
            <div class="carousel-inner mx-auto w-90 h-90" role="listbox" >
                <?php   
                    $active = "active";
                    if ($this->favorite_list) {
                        foreach ($this->favorite_list as $i => $record) { 
                        $img = explode(',', $record[0]->imgs);
                        $desiredElement = '';
                        foreach ($img as $item) {
                            if ($item !== "") {
                                $desiredElement = $item;
                                break; // Exit the loop as soon as "a" is found
                            }
                        }
                        if (count($this->favorite_list) > 2) {
                        
                ?>
                    <div class="carousel-item">
                <?php } else { ?>
                    <!-- <div class="no-carousel"> -->
                <?php } ?>
                        <div class="col-lg-5 col-md-4 gm-card">
                            <img class="img-fluid w-100" src="<?= wp_get_upload_dir()['baseurl'] ?>/gm-property/<?= $record[0]->property_id ?>/<?= $desiredElement ?>" data-target="#lightbox-gallery" data-slide-to=<?= $i?>>
                            <div class="gm-card-info__div">ガレージ名: <?php echo $record[0]->nm ?></div>
                            <div class="gm-card-info__div">賃料: <?php echo $record[0]->fee_monthly_rent ?></div>
                            <?php
                                $param = array('id'=>$record[0]->property_id);
                                $link = add_query_arg($param, home_url('propertys'));
                            ?>
                            <div class="gm-mypage-add-button ml-20"><a href="<?= esc_url($link) ?>" class="gm-mypage-add-button ml-20">詳細を見る</a></div>
                            <i class="heart123 fa-solid fa-heart selected-heart" id="heart${property.ID}" onclick="handleFavorite('<?= $record[0]->ID ?>')"></i>
                        </div>
                        <?php if (count($this->favorite_list) > 2) { ?>
                    </div>
                    <?php } ?>
                <?php      
                    }
                } else { ?>
                    <div class="no-favourite-div">
                        現在お気に入り登録済みのガレージはありません。
                    </div>

                <?php }
                ?>
            </div>
            <div class="w-100">
                <a class="carousel-control-prev w-auto" href="#gallery" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next w-auto" href="#gallery" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#gallery').carousel({
            interval: 500000
        })

        // Modify each slide to contain five columns of images
        $('#gallery.carousel .carousel-item').each(function(){
            var minPerSlide = 2;
            var next = $(this).next();
            if (!next.length) {
            next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
            
            for (var i=0;i<minPerSlide;i++) {
                next=next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                
                next.children(':first-child').clone().appendTo($(this));
            }
        });

        // Initialize carousel
        $( ".carousel-item:first-of-type" ).addClass( "active" );
        $( ".carousel-indicators:first-child" ).addClass( "active" );
    });


    function handleFavorite(id) {
        let a = getCookie("favorite");
        const element = document.getElementById("heart"+id);
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

    function handleFavorite(id) {
        console.log("efe");
        let a = getCookie("favorite");
        let ind = a.indexOf(id);
        deleteCookie('favorite', 365, a, ind);
        let link = "<?= home_url('/')?>";
        window.location.assign(link+'/favorite/?id='+id);
    }

    function setCookie(cname, cvalue, exdays, value) {
        value.push(cvalue);
        let b = value.toString();
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
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
        for(let i = 0; i <ca.length; i++) {
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

    
</div>
