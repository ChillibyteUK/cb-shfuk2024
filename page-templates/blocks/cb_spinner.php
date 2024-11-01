<section class="spinner py-5">
    <div class="container-xl">
        <h2 class="text-center mb-4"><?=get_field('title')?></h2>
        <div class="row gy-4 justify-content-center">
            <?php
            while (have_rows('stats')) {
                the_row();
                $endval = get_sub_field('stat');
                $endval = preg_replace('/,/', '.', $endval);
                $decimals = strlen(substr(strrchr($endval, "."), 1));
                $prefix = get_sub_field('prefix') ?? null;
                $suffix = get_sub_field('suffix') ?? null;

                ?>
            <div class="col-sm-6 col-md-4 col-lg-3 text-center">
                <div class="spinner__stat">
                    <?=$prefix?><?=do_shortcode("[countup start='0' end='{$endval}' decimals='{$decimals}' duration='3' scroll='true']")?><?=$suffix?>
                </div>
                <div class="spinner__title">
                    <?=get_sub_field('description')?>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>