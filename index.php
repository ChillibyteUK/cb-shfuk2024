<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package cb-shfuk2024
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<main id="main" role="main">
    <section class="form_hero">
        <div class="container-xl py-6 text-center">
            <div class="h2 mb-0 font-weight-medium">SellHouseFast.uk</div>
            <h1>Property <span>Blog</span></h1>
            <div class="form_hero__form">
                <input type="text" name="postcode_<?= esc_attr( $id ); ?>" id="postcode_<?= esc_attr( $id ); ?>" placeholder="Enter postcode" autocomplete="off"><button class="button button-sm formbutton">Get Your Free Offer</button>
            </div>
        </div>
    </section>
    <?php get_template_part( 'page-templates/blocks/cb_featured_in' ); ?>
    <section class="py-5 bg-grey-400">
        <div class="container-xl">
            <div class="row g-2">
            <?php
            $terms = get_terms(
                array(
                    'taxonomy'   => 'category',
                    'hide_empty' => true,
                )
            );
            ?>
            <div class="col-12 mb-4">
                <div class="filter">
                    <label for="filter" class="mb-2">Filter by category:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary active" data-filter="all">All</button>
                        <?php
                        foreach ( $terms as $category_term ) {
                            if ( 'uncategorized' === $category_term->slug ) {
                                continue;
                            }
                            ?>
                        <button class="btn btn-outline-primary" data-filter="<?= esc_attr( $category_term->slug ); ?>"><?= esc_html( $category_term->name ); ?></button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script>
                document.querySelectorAll('[data-filter]').forEach(button => {
                    button.addEventListener('click', function() {
                        const selected = this.getAttribute('data-filter');
                        
                        if (selected === 'all') {
                            window.location.href = '/blog/';
                        } else {
                            window.location.href = '/category/' + selected;
                        }
                    });
                });
            </script>
            <?php

            // WordPress' WP_Query doesn't provide native support for complex sorting and grouping across taxonomy relationships, so an SQL query is the only option.

            global $wpdb;
            $current_paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $posts_per_page = get_option( 'posts_per_page' );
            $offset         = ( $current_paged - 1 ) * $posts_per_page;

            $query = "
                SELECT DISTINCT p.ID
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'location'
                WHERE p.post_type = 'post'
                AND p.post_status = 'publish'
                GROUP BY p.ID
                ORDER BY COUNT(tt.term_id) = 0 DESC, p.post_date DESC
                LIMIT %d OFFSET %d
            ";

            $results = $wpdb->get_results( $wpdb->prepare( $query, $posts_per_page, $offset ) );


            // Display the posts.
            if ( ! empty( $results ) ) {
                $count = 0; // Counter to track the number of posts.

                foreach ( $results as $result ) {
                    ++$count; // Increment the post counter.
                    $current_post = get_post( $result->ID );
                    setup_postdata( $current_post );
                    // Output post content.
                    ?>
                    <div class="col-md-4">
                        <a class="news_card" href="<?= esc_url( get_the_permalink() ); ?>">
                            <?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'news_card__image' ) ); ?>
                            <div class="news_card__inner">
                                <h3><?= esc_html( get_the_title() ); ?></h3>
                                <!-- <div class="news_card__meta">Posted by Jack Malnick | <?= get_the_date( 'j F, Y' ); ?></div> -->
                                <div class="news_card__read"><?= wp_kses_post( estimate_reading_time_in_minutes( get_the_content(), 200, true, true ) ); ?></div>
                                <div class="news_card__excerpt"><?= wp_kses_post( wp_trim_words( get_the_content(), 30 ) ); ?></div>
                                <div class="news_card__link">Read more</div>
                            </div>
                        </a>
                    </div>
                    <?php
                    if ( 0 === $count % 6 ) {
                        echo '<div class="col-12">';
                        set_query_var( 'invert', 'short_cta--invert' );
                        get_template_part( 'page-templates/blocks/cb_short_cta' );
                        echo '</div>';
                    }
                }
                wp_reset_postdata();
            }

            // Pagination.
            $total_posts_query = "
                SELECT COUNT(DISTINCT p.ID)
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'location'
                WHERE p.post_type = 'post'
                AND p.post_status = 'publish'
            ";

            $total_posts = $wpdb->get_var( $total_posts_query );
            $total_pages = ceil( $total_posts / $posts_per_page );
            ?>
            </div>
            <div class="pt-4">
                <?= wp_kses_post( understrap_pagination() ); ?>
            </div>
        </div>
    </section>
</main>
<?php

get_footer();
?>