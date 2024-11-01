<?php
$class = $block['className'] ?? 'py-5';
?>
<section class="process_steps <?=$class?>">
    <div class="container-xl">
        <ul class="process_steps__list">
            <?php
            $c = 1;
            while (have_rows('process_steps')) {
                the_row();
                ?>
            <li>
                <span class="number">
                    <div><?=$c?></div>
                </span>
                <span class="item">
                    <?=get_sub_field('step')?>
                </span>
            </li>
                <?php
                $c++;
            }
            ?>
        </ul>
    </div>
</section>