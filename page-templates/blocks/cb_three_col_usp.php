<?php
$width = get_field('width') == 'Narrow' ? 'w-lg-75' : '';

$hp = is_front_page() ? 'three_col_usp__content--hide' : '';

$usp1 = get_field('usp_1') ?: get_field('usp_1','option');
$usp2 = get_field('usp_2') ?: get_field('usp_2','option');
$usp3 = get_field('usp_3') ?: get_field('usp_3','option');

if (is_front_page()) {
    $usp1 = wrap_non_strong_content($usp1);
    $usp2 = wrap_non_strong_content($usp2);
    $usp3 = wrap_non_strong_content($usp3);
}

?>
<section class="three_col_usp pb-5">
    <div class="container-xl">
        <div class="row g-4 <?=$width?> mx-auto">
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?=$hp?>">
                    <?=$usp1?>
                </div>
            </div>
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?=$hp?>">
                    <?=$usp2?>
                </div>
            </div>
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?=$hp?>">
                    <?=$usp3?>
                </div>
            </div>
        </div>
    </div>
</section>