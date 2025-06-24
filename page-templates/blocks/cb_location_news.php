<?php
/**
 * Location News Block Template
 *
 * Displays news posts filtered by location taxonomy.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

$terms      = wp_get_post_terms( get_the_ID(), 'location' ) ?? null;
$first_term = null;

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $first_term    = $terms[0];
    $location_name = $first_term->name;
} else {
    echo 'NO LOCATION';
    return;
}

?>
<section class="py-5 bg-grey-400">
    <div class="container-xl">
        <div class="row g-2">
            <?php
            // location posts.

            $q = new WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'location',
							'field'    => 'term_id',
							'terms'    => $first_term->term_id,
						),
					),
				)
			);

            while ( $q->have_posts() ) {
                $q->the_post();
                ?>
            <div class="col-md-4">
                <a class="news_card" href="<?= esc_url( get_the_permalink( get_the_ID() ) ); ?>">
                    <?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'news_card__image' ) ); ?>
                    <div class="news_card__inner">
                        <h3><?= esc_html( get_the_title( get_the_ID() ) ); ?></h3>
						<div class="news_card__meta"><i class="fa-solid fa-user"></i> Jack Malnick | <i class="fa-solid fa-calendar-days"></i> <?= get_the_date( 'j F, Y' ); ?> | <i class="fa-solid fa-hourglass"></i> <?= wp_kses_post( estimate_reading_time_in_minutes( get_the_content(), 200, true, true ) ); ?></div>
                        <div class="news_card__excerpt"><?= esc_html( wp_trim_words( get_the_content(), 30 ) ); ?></div>
                        <div class="news_card__link">Read more</div>
                    </div>
                </a>
            </div>
                    <?php
            }

            // non location posts.
            $q = new WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'location',
							'field'    => 'term_id',
							'operator' => 'NOT EXISTS',
						),
					),
				)
			);

            while ( $q->have_posts() ) {
                $q->the_post();
                ?>
            <div class="col-md-4">
                <a class="news_card" href="<?= esc_html( get_the_permalink() ); ?>">
                    <?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'news_card__image' ) ); ?>
                    <div class="news_card__inner">
                        <h3><?= esc_html( get_the_title() ); ?></h3>
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
