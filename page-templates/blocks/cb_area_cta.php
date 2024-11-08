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

                    // Loop through each term and display its name or link if the page exists
                    foreach ($terms as $term) {
                        $term_slug = $term->slug;
                        $page = get_page_by_path('location/' . $term_slug, OBJECT, 'page');

                        if ($page && get_post_status($page->ID) == 'publish') {
                            $term_link = get_permalink($page->ID);
                            echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                        } else {
                            echo '<li>' . esc_html($term->name) . '</li>';
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