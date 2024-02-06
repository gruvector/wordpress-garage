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
                    foreach ($this->favorite_list as $i => $record) { 
                        $img = explode(',', $record[0]->imgs);
                ?>
                    <div class="carousel-item">
                        <div class="col-lg-5 col-md-4 gm-card">
                            <img class="img-fluid w-100" src="<?= wp_get_upload_dir()['baseurl'] ?>/image/<?php echo $img[1     ] ?>" data-target="#lightbox-gallery" data-slide-to=<?= $i?>>
                            <div class="gm-card-info__div">車庫名: <?php echo $record[0]->nm ?></div>
                            <div class="gm-card-info__div">価格: <?php echo $record[0]->fee_monthly_rent ?></div>
                            <?php
                                $param = array('id'=>$record[0]->ID);
                                $link = add_query_arg($param, home_url('propertys'));
                            ?>
                            <div class="gm-mypage-add-button ml-20"><a href="<?= esc_url($link) ?>" class="gm-mypage-add-button ml-20">詳細を見る</a></div>
                        </div>
                    </div>
                <?php      
                    }
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
            var minPerSlide = 4;
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
</script>

    
</div>