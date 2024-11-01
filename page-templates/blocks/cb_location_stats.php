<?php
$terms = wp_get_post_terms(get_the_ID(), 'location') ?? null;
$first_term = null;

if (!empty($terms) && !is_wp_error($terms)) {
    $first_term = $terms[0];
    $location_name = $first_term->name;
} else {
    echo 'NO LOCATION';
    return;
}

$ld = null;
$latest_year = 0;
?>
<section class="stats">
    <div class="container-xl px-5 py-4">
        <?php
        while (have_rows('locations', 'option')) {
            the_row();
            $this_location = get_sub_field('location');
            if ($this_location->name != $location_name) {
                continue;
            }

            while (have_rows('annual_data', 'option')) {
                the_row();
                $current_year = get_sub_field('year');
                if ($current_year > $latest_year) {
                    $latest_year = $current_year;
                    $ld = get_row(true);
                }
            }

            break;
        }

        if ($ld) {
            ?>
        <ul>
            <li>The average sold price for a property in <?=$location_name?> in the last 12 months is £<?=number_format($ld['avg_price'])?>.</li>
            <li>The majority of sales around <?=$location_name?> during the last year were <?=$ld['type1']?> properties, selling for an average price of £<?=number_format($ld['type1_avg'])?>.</li>
            <li><?=ucfirst($ld['type2'])?> properties sold for an average of £<?=number_format($ld['type2_avg'])?>, with <?=$ld['type3']?> fetching £<?=number_format($ld['type3_avg'])?>.</li>
            <li>Overall, sold prices around <?=$location_name?> over the last year were <?=$ld['variation']?> the previous year and <?=$ld['pct_change']?>% <?=$ld['pct_updown']?> on the <?=$ld['peak_year']?> peak of £<?=number_format($ld['peak_avg'])?>.</li>
        </ul>
            <?php
        }
        ?>
    </div>
</section>
