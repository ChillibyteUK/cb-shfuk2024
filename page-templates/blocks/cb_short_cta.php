<?php
$class = $block['className'] ?? 'py-5';
$invert = get_query_var( 'invert', null );

// If no $invert was passed via set_query_var(), use the original logic
if ( ! $invert ) {
    $invert = isset(get_field('invert')[0]) && get_field('invert')[0] == 'Yes' ? 'short_cta--invert' : null;
}

$id = random_str(4);
?>
<section class="short_cta <?=$invert?> <?=$class?>">
    <div class="container-xl short_cta__inner px-3 py-5">
        <div class="short_cta__title text-center text-md-start">Get your FREE CASH OFFER <span>- Fast!</span></div>
        <div class="text-center text-md-start short_cta__form">
            <input type="text" name="postcode_<?=$id?>" id="postcode_<?=$id?>" placeholder="Enter postcode" autocomplete="off"><button class="button button-sm formbutton">Get Your Free Offer</button>
        </div>
    </div>
</section>
