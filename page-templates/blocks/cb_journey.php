<section class="journey py-5">
    <div class="container-xl">
        <h2 class="pb-4"><?=get_field('title')?></h2>
        <p class="has-blue-400-color font-weight-medium"><?=get_field('intro')?></p>
        <div class="bg-grey-400 px-4 py-5">
            <ol>
                <?php
                $steps = textarea_array(get_field('steps'));
                foreach ($steps as $s) {
                    ?>
                <li><?=$s?></li>
                    <?php
                }
                ?>
            </ol>
        </div>
    </div>
</section>