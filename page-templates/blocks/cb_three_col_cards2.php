<?php
$class = null;
$cclass = $block['className'] ?? 'pt-4';
?>
<div class="three_col_cards2 <?=$cclass?>">
    <div class="container-xl">
        <?php
        if (get_field('title') ?? null) {
            ?>
        <h2 class="mb-4"><?=get_field('title')?></h2>
            <?php
            $class = 'py-5';
        }
        if (get_field('intro') ?? null) {
            ?>
        <div class="container pb-4 has-blue-400-color font-weight-medium">
            <?=get_field('intro')?>
        </div>
            <?php
            $class = 'py-5';
        }
        ?>
        <div class="three_col_cards2__grid <?=$class?>">
            <?php
            while (have_rows('cards')) {
                the_row();
                ?>
<div class="three_col_cards2__card">
    <div class="three_col_cards2__marker"></div>
    <div class="three_col_cards2__title"><h3><?=get_sub_field('title')?></h3></div>
    <div class="three_col_cards2__content"><?=get_sub_field('content')?></div>
</div>
                <?php
            }
            ?>
        </div>
        <?php
        if (get_field('outro') ?? null) {
            ?>
        <div class="container mt-4 pb-4 has-blue-400-color font-weight-medium">
            <?=get_field('outro')?>
        </div>
            <?php
        }
        ?>
    </div>
</div>