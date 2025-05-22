<?php
$unique_id = random_str( 4 );
?>
<section class="form_hero">
    <div class="container-xl py-md-6 text-center">
        <?php
        if ( get_field( 'pre_title' ) ?? null ) {
            ?>
        <h1 class="h3 mb-2 font-weight-medium"><?= wp_kses_post( get_field( 'pre_title' ) ); ?></h1>
        <h2 class="h1"><?= wp_kses_post( get_field( 'title' ) ); ?></h2>
			<?php
        } else {
			?>
        <h1><?= wp_kses_post( get_field( 'title' ) ); ?></h1>
			<?php
		}
        ?>
        <div class="form_hero__form">
            <input type="text" name="postcode_<?= esc_attr( $unique_id ); ?>" id="postcode_<?= esc_attr( $unique_id );?>" placeholder="Enter postcode" autocomplete="off"><button class="button button-sm formbutton">Get Your Free Offer</button>
        </div>
    </div>
</section>