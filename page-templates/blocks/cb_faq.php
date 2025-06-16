<?php
/**
 * FAQ Block Template
 *
 * Displays a list of FAQs in an accordion format.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

$accordion = random_str( 5 );
$counter   = 0;
$show      = '';
$collapsed = 'collapsed';
$expanded  = 'false';
$collapse  = '';
$button    = 'collapsed';
?>
<section class="faqs py-5">
    <div class="container-xl">
        <div itemscope="" itemtype="https://schema.org/FAQPage" id="accordion<?= esc_attr( $accordion ); ?>" class="accordion">
        <?php
        while ( have_rows( 'faqs' ) ) {
            the_row();
            $ac = $accordion . '_' . $counter;
            ?>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion-item">
                <div class="accordion-header">
                    <h3 role="button" class="fw-normal accordion-button <?= esc_attr( $button ); ?>"
                        itemprop="name" type="button" data-bs-toggle="collapse"
                        data-bs-target="#c<?= esc_attr( $ac ); ?>"
                        aria-expanded="<?= esc_attr( $expanded ); ?>"
                        aria-controls="c<?= esc_attr( $ac ); ?>">
                        <?= esc_html( get_sub_field( 'question' ) ); ?>
                    </h3>
                </div>
                <div id="c<?= esc_attr( $ac ); ?>"
                    class="answer collapse <?= esc_attr( $show ); ?>" itemscope=""
                    itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                    data-bs-parent="#accordion<?= esc_attr( $accordion ); ?>">
                    <div class="accordion-body" itemprop="text">
                        <?= wp_kses_post( get_sub_field( 'answer' ) ); ?>
                    </div>
                </div>
            </div>
            <?php
            ++$counter;
            $show      = '';
            $collapsed = 'collapsed';
        }
        ?>
        </div>
    </div>
</section>