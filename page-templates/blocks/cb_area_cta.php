<section class="area_cta py-5">
    <div class="container-xl">
        <div class="area_cta__grid">
            <div class="area_cta__words">
                <h2><?= get_field('title') ?></h2>
                <?= get_field('content') ?>
            </div>
            <div class="area_cta__arrow"></div>
            <div class="area_cta__areas">
                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'location',
                    'hide_empty' => false, // Change to true if you want to hide terms without posts
                ));

                // Check if any terms were returned
                if (! empty($terms) && ! is_wp_error($terms)) {
                    echo '<ul class="locations-list">';

                    // Loop through each term and display its name
                    foreach ($terms as $term) {
                        // Query posts associated with the term
                        $posts_query = new WP_Query(array(
                            'post_type' => 'your_post_type', // Replace with your custom post type if necessary
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'location',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                            'post_status' => 'publish',
                            'posts_per_page' => 1, // We only need to check if there's at least one published post
                        ));

                        if ($posts_query->have_posts()) {
                            // If there's at least one published post, show the term link
                            echo '<li>' . get_custom_term_link($term, 'Sell in') . '</li>';
                        } else {
                            // If no published post, show text
                            echo '<li>Sell in ' . esc_html($term->name) . '</li>';
                        }

                        // Reset post data after custom query
                        wp_reset_postdata();
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