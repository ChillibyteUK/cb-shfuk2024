<?php
/**
 * Latest Property News Block Template
 *
 * Displays the latest property news posts.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

$block_title   = get_field( 'title' ) ? get_field( 'title' ) : 'Latest Property News';
$posts_page_id = get_option( 'page_for_posts' );
$blog_url      = get_permalink( $posts_page_id );

$cats = get_field( 'category' );
?>
<section class="latest_news py-5">
    <div class="container-xl">
        <div class="mb-5 d-flex justify-content-between flex-wrap align-items-center">
            <h2><?= esc_html( $block_title ); ?></h2>
            <a href="<?= esc_url( $blog_url ); ?>" class="button">See all articles</a>
        </div>
        <div class="row g-2">
        <?php
        $args = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'location',
					'field'    => 'term_id',
					'operator' => 'NOT EXISTS',
				),
			),
		);

		if ( ! empty( $cats ) && is_array( $cats ) ) {
			$args['category__in'] = $cats;
		}

		$q = new WP_Query( $args );

        while ( $q->have_posts() ) {
            $q->the_post();
            ?>
            <div class="col-lg-4">
                <a class="news_card" href="<?= esc_url( get_the_permalink() ); ?>">
                    <?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'news_card__image' ) ); ?>
                    <div class="news_card__inner">
                        <h3 class="mb-2"><?= esc_html( get_the_title() ); ?></h3>
						<div class="news_card__meta"><i class="fa-solid fa-user"></i> Jack Malnick | <i class="fa-solid fa-calendar-days"></i> <?= get_the_date( 'j F, Y' ); ?> | <i class="fa-solid fa-hourglass"></i> <?= wp_kses_post( estimate_reading_time_in_minutes( get_the_content(), 200, true, true ) ); ?></div>
                        <div class="news_card__excerpt"><?= wp_kses_post( wp_trim_words( get_the_content(), 30 ) ); ?></div>
                        <div class="news_card__link">Read more</div>
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
        </div>
    </div>
</section>