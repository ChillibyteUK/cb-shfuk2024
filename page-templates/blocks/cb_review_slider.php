<section class="review_slider py-5">
    <div class="container-xl">
        <h2>What our clients say:</h2>
        <div class="review_swiper swiper">
            <div class="swiper-wrapper">
            <?php
            $q = new WP_Query(array(
                'post_type' => 'review',
                'posts_per_page' => -1,
            ));
            while ($q->have_posts()) {
                $q->the_post();
                ?>
                <div class="swiper-slide">
                    <div class="review_slide">
                        <div class="review_title"><?=get_field('review_title',get_the_ID())?></div>
                        <div class="review"><?=get_field('review',get_the_ID())?></div>
                        <div class="review_attr"><strong><?=get_the_title(get_the_ID())?></strong> - <?=get_field('reviewer_location',get_the_ID())?></div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<?php
add_action('wp_footer', function() {
    ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer nitro-exclude></script>
<script defer nitro-exclude>
    const reviewSwiper = new Swiper('.review_swiper', {
        autoplay: true,
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
    });
</script>
    <?php
},9999);