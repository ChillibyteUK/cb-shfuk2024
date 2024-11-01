<section class="three_col_cards mb-5">
    <div class="container-xl">
        <h2 class="mb-4"><?=get_field('title')?></h2>
    </div>
    <div class="container pb-4 has-blue-400-color font-weight-medium">
        <?=get_field('intro')?>
    </div>
    <div class="three_col_cards__bg">
        <div class="container-xl three_col_cards__grid mb-4">
            <?php
            $c = 1;
            while (have_rows('cards')) {
                the_row();
                ?>
<div class="three_col_cards__card">
    <div class="three_col_cards__marker"><?=$c?></div>
    <div class="three_col_cards__title"><h3><?=get_sub_field('title')?></h3></div>
    <div class="three_col_cards__content"><?=get_sub_field('content')?></div>
</div>
                <?php
                $c++;
            }
            ?>
        </div>
        <div class="container has-blue-400-color font-weight-medium">
            <?=get_field('outro')?>
        </div>
    </div>
</section>