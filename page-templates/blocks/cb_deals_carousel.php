<section class="deals_carousel bg-grey-400">
    <div class="container-xl py-5">
        <h2>Recent Deals</h2>
        
        <div class="swiper deals-swiper">
            <div class="swiper-wrapper">
                <?php
                $deals = new WP_Query(array(
                    'post_type' => 'deals',
                    'posts_per_page' => 8
                ));
                while ($deals->have_posts()) {
                    $deals->the_post();
                    $title = get_the_title();
                    $slug = sanitize_title($title);
                    $link = esc_url('/deals/#' . $slug);
                    ?>
                    <div class="swiper-slide">
                        <div class="deals_carousel__card">
                            <a href="<?= $link ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    ?>
                                    <?= get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'deals_carousel__image']); ?>
                                    <?php
                                }
                                ?>
                                <div class="deals_carousel__inner">
                                    <h3 class="deals_carousel__title"><?= esc_html($title) ?></h3>
                                    <div class="deals_carousel__link">Read more</div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>
<?php
add_action('wp_footer', function() {
    ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".deals-swiper", {
            slidesPerView: 1,
            spaceBetween: 16,
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                }
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }
        });
    });
</script>
    <?php
});
