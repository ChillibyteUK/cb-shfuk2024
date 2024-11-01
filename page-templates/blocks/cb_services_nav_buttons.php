<?php
$cols = get_field('columns') == '3' ? '' : 'two_cols';
$bg = get_field('background') == 'Grey' ? 'py-5 bg-grey-400' : 'pt-5';
?>
<section class="services_nav <?=$bg?>">
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
        <div class="services_nav__grid <?=$cols?>">
            <?php
            while (have_rows('services')) {
                the_row();
                $l = get_sub_field('link') ?? null;
                $link_title = is_array($l) && isset($l['title']) ? $l['title'] : get_sub_field('title');
                ?>
            <div class="services_nav__card services_nav__card--button">
                <div class="services_nav__inner">
                    <h3><?=get_sub_field('title')?></h3>
                    <div><?=get_sub_field('content')?></div>
                    <?php
                    if (is_array($l) && isset($l['url'])) {
                        ?>
                    <a href="<?=$l['url']?>" class="button button-sm"><?=$link_title?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>