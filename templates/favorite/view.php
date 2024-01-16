<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<div class="">
    <div class="testimonials-slider">
        <?php   
            foreach ($this->favorite_list as $i => $record) { ?>
            <div class="gm-card testimonial">
                <div class="gm-card-img">
                    <img src="<?php echo get_template_directory_uri() ?>/library/images/<?php echo $record[0]->imgs ?>.jpg" alt="img" >
                </div>
                <div class="gm-card-info">
                    <div class="gm-card-info__div">車庫名: <?php echo $record[0]->nm ?></div>
                    <div class="gm-card-info__div">価格: <?php echo $record[0]->fee_monthly_rent ?></div>
                </div>
                    <?php
                        $param = array('id'=>$record[0]->ID);
                        $link = add_query_arg($param, home_url('propertys'));
                    ?>
                <div class="gm-card-button">
                    <a href="<?= esc_url($link) ?>" class="gm-mypage-add-button">詳細を見る</a>
                </div>
            </div>
                    
        <?php        
            }
        ?>
    </div>

<script>
    $(document).ready(function(){
        $('.testimonials-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            dots: false,
            arrows: false,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                slidesToShow: 1
                }
            }
            ]
        });
    });
</script>

    
</div>