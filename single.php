<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
// $img = get_the_post_thumbnail_url(get_the_ID(),'full');
$img = get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'blog__image'));

?>
<main id="main" class="blog">
    <?php
    $content = get_the_content();
    $blocks = parse_blocks($content);
    $sidebar = array();
    $after;
    ?>
    <div class="blog__image">
        <?= get_the_post_thumbnail(get_the_id(), 'full') ?>
        <div class="overlay"></div>
    </div>
    <div class="blog__hero">
        <section class="breadcrumbs container-xl pt-4">
            <?php
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
            }
            ?>
        </section>
        <div class="container-xl blog__title">
            <h1><?= get_the_title() ?></h1>
        </div>
    </div>
    <div class="container-xl blog__main">
        <div class="row g-4 pb-4">
            <div class="col-lg-9 px-3 py-5 px-md-5">
                <?php
                $count = estimate_reading_time_in_minutes(get_the_content(), 200, true, true);
                echo $count;

                foreach ($blocks as $block) {
                    if ($block['blockName'] == 'core/heading') {
                        if (!array_key_exists('level', $block['attrs'])) {
                            $heading = strip_tags($block['innerHTML']);
                            $id = acf_slugify($heading);
                            echo '<a id="' . $id . '" class="anchor"></a>';
                            $sidebar[$heading] = $id;
                        }
                    }
                    // echo render_block($block);
                    echo apply_filters('the_content', render_block($block));
                }
                ?>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-container">
                    <?php
                    if ($sidebar) {
                    ?>
                        <div class="sidebar">
                            <div class="h5 d-none d-lg-block">Quick Links</div>
                            <div class="h5 d-lg-none" data-bs-toggle="collapse" href="#links" role="button">Quick Links</div>
                            <div class="collapse d-lg-block" id="links">
                                <?php
                                foreach ($sidebar as $heading => $id) {
                                ?>
                                    <li><a href="#<?= $id ?>"><?= $heading ?></a></li>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="single_cta">
                        <input type="text" name="postcode" id="postcode" autocomplete="off" placeholder="Enter postcode"><button class="button button-sm">Get Free Cash Offer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="related py-5">
        <div class="container-xl">
            <h3><span>Related</span> Guides</h3>
            <div class="row g-2">
                <?php
                $cats = get_the_category();
                $ids = wp_list_pluck($cats, 'term_id');
                $r = new WP_Query(array(
                    'category__in' => $ids,
                    'posts_per_page' => 3,
                    'post__not_in' => get_the_ID()
                ));
                while ($r->have_posts()) {
                    $r->the_post();
                ?>
                    <div class="col-md-4">
                        <a class="news_card" href="<?= get_the_permalink() ?>">
                            <?= get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'news_card__image')) ?>
                            <div class="news_card__inner">
                                <h3><?= get_the_title() ?></h3>
                                <div class="news_card__excerpt"><?= wp_trim_words(get_the_content(), 30) ?></div>
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
</main>
<?php
get_footer();
