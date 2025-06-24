<?php
/* template name: Location Page */
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();

$terms = wp_get_post_terms(get_the_ID(), 'location');
$first_term = null;
// Check if terms exist and get the first term
if (!empty($terms) && !is_wp_error($terms)) {
    $first_term = $terms[0];
}

?>
<main id="main" class="location_page">
    <?php
    the_post();
    the_content();
    ?>
    <div class="bg-grey-400 py-5">
        <div class="container-xl">
            <div class="mb-5 d-flex justify-content-between flex-wrap align-items-center">
                <h2 class="mb-4 h3"><?=$first_term->name?> Property News</h2>
                <a href="/locations/<?=$first_term->slug?>/<?=$first_term->slug?>-insights/" class="button">See all articles</a>
            </div>
            <div class="row g-2">
            <?php
            
            $c = 0;

            $q = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'location',
                        'field'    => 'slug',
                        'terms'    => $first_term->slug,
                    ),
                ),
            ));

            while ($q->have_posts()) {
                $q->the_post();
                ?>
                <div class="col-md-4">
                    <a class="news_card" href="<?=get_the_permalink()?>">
                        <?=get_the_post_thumbnail(get_the_ID(),'large',array('class' => 'news_card__image'))?>
                        <div class="news_card__inner">
                            <h3><?=get_the_title()?></h3>
                            <div class="news_card__read"><?=estimate_reading_time_in_minutes( get_the_content(), 200, true, true )?></div>
                            <div class="news_card__excerpt"><?=wp_trim_words(get_the_content(), 30)?></div>
                            <div class="news_card__link">Read more</div>
                        </div>
                    </a>
                </div>
                <?php
                $c++;
            }

            if ($c < 3) {
                $x = 3 - $c;
            
                $q = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => $x,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'location',
                            'field'    => 'slug',
                            'operator' => 'NOT EXISTS',  // Exclude posts with this term
                        ),
                    ),
                ));

                while ($q->have_posts()) {
                    $q->the_post();
                    ?>
                <div class="col-md-4">
                    <a class="news_card" href="<?=get_the_permalink()?>">
                        <?=get_the_post_thumbnail(get_the_ID(),'large',array('class' => 'news_card__image'))?>
                        <div class="news_card__inner">
                            <h3><?=get_the_title()?></h3>
							<div class="news_card__meta"><i class="fa-solid fa-user"></i> Jack Malnick | <i class="fa-solid fa-calendar-days"></i> <?= get_the_date( 'j F, Y' ); ?> | <i class="fa-solid fa-hourglass"></i> <?= wp_kses_post( estimate_reading_time_in_minutes( get_the_content(), 200, true, true ) ); ?></div>
                            <div class="news_card__excerpt"><?=wp_trim_words(get_the_content(), 30)?></div>
                            <div class="news_card__link">Read more</div>
                        </div>
                    </a>
                </div>
                    <?php
                }
            }

            ?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
?>