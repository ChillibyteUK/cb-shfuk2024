<section class="all_reviews py-5">
    <div class="container-xl">
        <?php
        $q = new WP_Query(array(
            'post_type' => 'review',
            'posts_per_page' => -1,
        ));
        $count = 0; // Counter to track the number of posts
        while ($q->have_posts()) {
            $count++; // Increment the post counter
            $q->the_post();
            ?>
        <div class="review_slide">
            <div class="review_title"><?=get_field('review_title',get_the_ID())?></div>
            <div class="review"><?=get_field('review',get_the_ID())?></div>
            <div class="review_attr"><strong><?=get_the_title(get_the_ID())?></strong> - <?=get_field('reviewer_location',get_the_ID())?></div>
        </div>
            <?php
            if ( $count % 3 == 0 ) {
                echo '<div class="col-12">';
                get_template_part( 'page-templates/blocks/cb_short_cta' );
                echo '</div>';
            }
        }
        wp_reset_postdata();
        ?>
    </div>
</section>