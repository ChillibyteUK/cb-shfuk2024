<section class="three_steps py-5">
    <div class="container-xl d-flex w-100">
        <h2><?=get_field('title')?></h2>
    </div>
    <div class="container pb-4 has-blue-400-color font-weight-medium">
        <?=get_field('intro')?>
    </div>
    <div class="three_steps__bg">
        <div class="container-xl">
            <div class="three_steps__step">
                <div class="three_steps__marker">1</div>
                <h3 class="three_steps__title"><?=get_field('title_1')?></h3>
                <div class="three_steps__content"><?=get_field('content_1')?></div>
            </div>
            <div class="three_steps__step">
                <div class="three_steps__marker">2</div>
                <h3 class="three_steps__title"><?=get_field('title_2')?></h3>
                <div class="three_steps__content"><?=get_field('content_2')?></div>
            </div>
            <div class="three_steps__step">
                <div class="three_steps__marker">3</div>
                <h3 class="three_steps__title"><?=get_field('title_3')?></h3>
                <div class="three_steps__content"><?=get_field('content_3')?></div>
            </div>
        </div>
    </div>
</section>