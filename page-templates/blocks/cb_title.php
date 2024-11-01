<section class="title py-6">
    <div class="container-xl text-center">
        <?php
        if (get_field('pre_title') ?? null) {
            ?>
        <div class="h2 mb-0 font-weight-medium"><?=get_field('pre_title')?></div>
            <?php
        }
        ?>
        <h2 class="h1"><?=get_field('title')?></h2>
    </div>
</section>