<?php
/**
 * Review Slider Block Template
 *
 * Displays a slider of client reviews.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="review_slider py-5">
    <div class="container-xl">
        <h2>What our clients say:</h2>
        <div class="review_swiper swiper">
            <div class="swiper-wrapper">
            <?php
            $q = new WP_Query(
				array(
					'post_type'      => 'review',
					'posts_per_page' => -1,
				)
			);
            while ( $q->have_posts() ) {
                $q->the_post();
                ?>
                <div class="swiper-slide">
                    <div class="review_slide">
                        <div class="review_title"><?= esc_html( get_field( 'review_title', get_the_ID() ) ); ?></div>
                        <div class="review"><?= esc_html( get_field( 'review', get_the_ID() ) ); ?></div>
                        <div class="review_attr"><strong><?= esc_html( get_the_title( get_the_ID() ) ); ?></strong> - <?= esc_html( get_field( 'reviewer_location', get_the_ID() ) ); ?></div>
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
add_action(
	'wp_footer',
	function () {
    	?>
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
	},
	9999
);