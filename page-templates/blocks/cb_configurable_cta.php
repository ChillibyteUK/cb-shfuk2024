<section class="cta py-5">
    <div class="container-xl text-center bg-grey-400 p-5">
        <h2 class="cta__title"><?=get_field('title')?></h2>
        <p class="cta__content"><?=get_field('content')?></p>
        <?php
        $l = get_field('link');
        if($l){
            $link_url = $l['url'];
            $link_title = $l['title'];
            $link_target = $l['target'] ? $l['target'] : '_self';
            ?>
            <a href="<?=$link_url?>" class="button" target="<?=$link_target?>"><?=$link_title?></a>
            <?php
        }
        ?>
    </div>
</section>