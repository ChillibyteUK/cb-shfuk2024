<?php
$id = random_str(4);
?>
<section class="form_hero">
    <div class="container-xl py-md-6 text-center">
        <?php
        if (get_field('pre_title') ?? null) {
            ?>
        <div class="h3 mb-0 font-weight-medium"><?=get_field('pre_title')?></div>
            <?php
        }
        ?>
        <h1><?=get_field('title')?></h1>
        <div class="form_hero__form">
            <input type="text" name="postcode_<?=$id?>" id="postcode_<?=$id?>" placeholder="Enter postcode" autocomplete="off"><button class="button button-sm formbutton">Get Free Cash Offer</button>
        </div>
    </div>
</section>