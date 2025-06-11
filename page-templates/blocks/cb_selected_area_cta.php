<?php
/**
 * Selected Area CTA Block Template
 *
 * Displays a call-to-action section with selected area locations.
 *
 * @package WordPress
 * @subpackage cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="area_cta py-5">
    <div class="container-xl">
        <div class="area_cta__grid">
            <div class="area_cta__words">
                <h2><?= wp_kses_post( get_field( 'title' ) ); ?></h2>
                <?= wp_kses_post( get_field( 'content' ) ); ?>
            </div>
            <div class="area_cta__arrow"></div>
            <div class="area_cta__areas">
                <?php
				$terms = get_field( 'locations' );

                // Check if any terms were returned.
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    echo '<ul class="locations-list">';

                    // Loop through each term and display its name or link if the page exists.
                    foreach ( $terms as $loca ) {
                        $term_slug = $loca->slug;
                        $loca_page = get_page_by_path( 'locations/' . $term_slug, OBJECT, 'page' );

                        if ( $loca_page && 'publish' === get_post_status( $loca_page->ID ) ) {
                            $term_link = get_permalink( $loca_page->ID );
                            echo '<li><a href="' . esc_url( $term_link ) . '">Sell in ' . esc_html( $loca->name ) . '</a></li>';
                        } else {
                            echo '<li>Sell in ' . esc_html( $loca->name ) . '</li>';
                        }
                    }

                    echo '</ul>';
                } else {
                    echo 'NO';
                }
                ?>
            </div>
        </div>
    </div>
</section>