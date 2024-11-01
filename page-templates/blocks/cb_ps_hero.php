<section class="ps_hero">
    <div class="container-xl py-md-6">
        <div class="row">
            <div class="col-md-8">
                <h1><?=get_field('title')?></h1>
                <ul>
                    <?php
                    foreach (textarea_array(get_field('bullets')) as $b) {
                        echo '<li>' . $b . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="ps_hero__form">
                    <h2 class="h3">Invest in properties today</h2>
                    <div class="ps_hero__form_intro">Enter your details below</div>
                    <div><?=do_shortcode('[gravityform id="' . get_field('form_id') . '" title="false"]')?></div>
                </div>
            </div>
        </div>
    </div>
</section>