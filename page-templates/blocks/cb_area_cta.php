<section class="area_cta py-5">
    <div class="container-xl">
        <div class="area_cta__grid">
            <div class="area_cta__words">
                <h2><?=get_field('title')?></h2>
                <?=get_field('content')?>
            </div>
            <div class="area_cta__arrow"></div>
            <div class="area_cta__areas">
                <?php
                    $terms = get_terms( array(
                        'taxonomy' => 'location',
                        'hide_empty' => false, // Change to true if you want to hide terms without posts
                    ) );
                
                    // Check if any terms were returned
                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        echo '<ul class="locations-list">';
                        
                        // Loop through each term and display its name
                        foreach ( $terms as $term ) {
                            $term_link = get_term_link( $term );
                            echo '<li>' . get_custom_term_link($term, 'Sell in') . '</li>';
                        }
                
                        echo '</ul>';
                    }
                    else {
                        echo 'NO';
                    }
                ?>
            </div>
        </div>
    </div>
</section>