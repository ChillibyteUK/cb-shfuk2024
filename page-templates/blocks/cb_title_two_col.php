<?php
$class = $block['className'] ?? 'pb-5';

$layout = get_field('layout');

if ($layout == 'Title and Text') {
    ?>
<section class="title_two_col <?=$class?>">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-6">
                <h2><?=get_field('title')?></h2>
            </div>
            <div class="col-md-6">
                <?=get_field('content')?>
            </div>
        </div>
    </div>
</section>
    <?php
}
elseif ($layout == 'Title and Two-Col Text') {
    ?>
<section class="title_two_col <?=$class?>">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-4">
                <h2><?=get_field('title')?></h2>
            </div>
            <div class="col-md-8 cols-lg-2">
                <?=get_field('content')?>
            </div>
        </div>
    </div>
</section>
    <?php
}
else {
    ?>
<section class="title_two_col <?=$class?>">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-12 cols-lg-2">
                <h2><?=get_field('title')?></h2>
                <?=get_field('content')?>
            </div>
        </div>
    </div>
</section>
    <?php
}