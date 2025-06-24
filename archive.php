<?php
// Exit if accessed
defined( 'ABSPATH' ) || exit;

get_header();

?>
<main id="main" role="main">
    <section class="form_hero">
        <div class="container-xl py-6 text-center">
            <div class="h2 mb-0 font-weight-medium">SellHouseFast.uk</div>
            <h1>Property <span>Blog</span></h1>
            <div class="form_hero__form">
                <input type="text" name="postcode_<?=$id?>" id="postcode_<?=$id?>" placeholder="Enter postcode" autocomplete="off"><button class="button button-sm formbutton">Get Your Free Offer</button>
            </div>
        </div>
    </section>
    <?php get_template_part('page-templates/blocks/cb_featured_in'); ?>
    <section class="py-5 bg-grey-400">
        <div class="container-xl">
            <div class="row g-2">
            <?php
            $current_category = get_queried_object();
$current_category_slug = ($current_category && isset($current_category->slug)) ? $current_category->slug : '';

$terms = get_terms(array(
    'taxonomy' => 'category',
    'hide_empty' => true,
));

$category_filter = '';
if ($current_category && isset($current_category->term_id)) {
    $category_filter = $wpdb->prepare("AND tt.term_id = %d", $current_category->term_id);
}

// Display current category name
if ($current_category && isset($current_category->name)) {
    echo '<h2>Category: ' . esc_html($current_category->name) . '</h2>';
}

?>
            <div class="col-12 mb-4">
                <div class="filter">
                    <label for="filter" class="mb-2">Filter by category:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary" data-filter="all">All</button>
                        <?php
                        foreach ($terms as $term) {
                            if ($term->slug === 'uncategorized') {
                                continue;
                            }
                            if ($term->slug === $current_category_slug) {
                                ?>
                        <button class="btn btn-outline-primary active" data-filter="<?=$term->slug?>"><?=$term->name?></button>
                            <?php
                            } else {
                            ?>
                        <button class="btn btn-outline-primary" data-filter="<?=$term->slug?>"><?=$term->name?></button>
                            <?php
                            }
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

global $wpdb;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = get_option('posts_per_page');
$offset = ($paged - 1) * $posts_per_page;

$query = "
                SELECT DISTINCT p.ID
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'category'
                WHERE p.post_type = 'post'
                AND p.post_status = 'publish'
                $category_filter
                GROUP BY p.ID
                ORDER BY COUNT(tt.term_id) = 0 DESC, p.post_date DESC
                LIMIT %d OFFSET %d
            ";

$results = $wpdb->get_results($wpdb->prepare($query, $posts_per_page, $offset));


// Display the posts
if (! empty($results)) {
    $count = 0; // Counter to track the number of posts

    foreach ($results as $result) {
        $count++; // Increment the post counter
        $post = get_post($result->ID);
        setup_postdata($post);
        // Output your post content here
        ?>
                    <div class="col-md-4">
                        <a class="news_card" href="<?=get_the_permalink()?>">
                            <?=get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'news_card__image'))?>
                            <div class="news_card__inner">
                                <h3><?=get_the_title()?></h3>
                                <div class="news_card__read"><?=estimate_reading_time_in_minutes(get_the_content(), 200, true, true)?></div>
                                <div class="news_card__excerpt"><?=wp_trim_words(get_the_content(), 30)?></div>
                                <div class="news_card__link">Read more</div>
                            </div>
                        </a>
                    </div>
                        <?php
        if ($count % 6 == 0) {
            echo '<div class="col-12">';
            set_query_var('invert', 'short_cta--invert');
            get_template_part('page-templates/blocks/cb_short_cta');
            echo '</div>';
        }
    }
    wp_reset_postdata();
}

// Pagination
$total_posts_query = "
                SELECT COUNT(DISTINCT p.ID)
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'location'
                WHERE p.post_type = 'post'
                AND p.post_status = 'publish'
                $category_filter
            ";
$total_posts = $wpdb->get_var($total_posts_query);

$total_pages = ceil($total_posts / $posts_per_page);
?>
            </div>
            <div class="pt-4">
                <?=understrap_pagination()?>
            </div>
        </div>
    </section>
</main>
<?php

get_footer();
?>