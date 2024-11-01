<?php
$accordion = random_str(5);
$counter = 0;
$show = '';
$collapsed = 'collapsed';
$expanded = 'false';
$collapse = '';
$button = 'collapsed';
?>
<section class="faqs py-5">
    <div class="container-xl">
        <div itemscope="" itemtype="https://schema.org/FAQPage" id="accordion<?=$accordion?>" class="accordion">
        <?php
            while (have_rows('faqs')) {
                the_row();
                $ac = $accordion . '_' . $counter;
                ?>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion-item">
                <div class="accordion-header">
                    <button class="accordion-button <?=$button?>"
                        itemprop="name" type="button" data-bs-toggle="collapse"
                        data-bs-target="#c<?=$ac?>"
                        aria-expanded="<?=$expanded?>"
                        aria-controls="c<?=$ac?>">
                        <?=get_sub_field('question')?>
                    </button>
                </div>
                <div id="c<?=$ac?>"
                    class="answer collapse <?=$show?>" itemscope=""
                    itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                    data-bs-parent="#accordion<?=$accordion?>">
                    <div class="accordion-body" itemprop="text">
                        <?=get_sub_field('answer')?>
                    </div>
                </div>
            </div>
                <?php
                $counter++;
                $show = '';
                $collapsed = 'collapsed';
            }
            ?>
        </div>
    </div>
</section>