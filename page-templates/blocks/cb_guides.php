<?php
$cols = get_field('columns') == '3' ? '' : 'two_cols';
$bg = get_field('background') == 'Grey' ? 'py-5 bg-grey-400' : 'pb-5';
$class = $block['className'] ?? 'pb-5';
?>
<section class="guides_nav <?=$bg?> <?=$class?>">
    <div class="container-xl">
        <?php
        if (get_field('title') ?? null) {
            ?>
        <h2 class="mb-4"><?=get_field('title')?></h2>
            <?php
        }
        if (get_field('intro') ?? null) {
            ?>
        <div class="text-center has-blue-400-color fw-bold mb-4"><?=get_field('intro')?></div>
            <?php
        }
        ?>
        <div class="guides_nav__grid">
            <?php
            $parent_page = get_page_by_path('guides');
            $children = get_children(array(
                'post_parent' => $parent_page->ID,
                'post_type'   => 'page',
                'orderby'     => 'title',
                'order'       => 'ASC',
            ));
            
            if (!empty($children)) {
                foreach ($children as $child) {
                    $title = get_the_title($child->ID);
                    ?>
                    <div class="guides_nav__card guides_nav__card--button">
                        <?=get_the_post_thumbnail($child->ID,'large',array('class' => 'guides_nav__image'))?>
                        <div class="guides_nav__overlay"></div>
                        <div class="guides_nav__inner">
                            <a href="<?=get_permalink($child->ID)?>" class="button button-sm"><?=$title?></a>
                        </div>
                    </div>
                        <?php
                }
            } else {
                echo 'No child pages found.';
            }
            ?>
        </div>
    </div>
</section>