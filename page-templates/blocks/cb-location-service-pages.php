<?php
/**
 * Block template for CB Location Service Pages.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="area_cta py-5">
    <div class="container-xl">
        <div class="area_cta__grid">
            <div class="area_cta__words">
                <h2><?= get_field('title') ?></h2>
                <?= get_field('content') ?>
            </div>
            <div class="area_cta__arrow"></div>
            <div class="area_cta__areas">
				<ul class="locations-list--max-2">
					<?php
					while ( have_rows( 'pages' ) ) {
						the_row();
						$page_id = get_sub_field( 'page' );
						$page_link = get_permalink( $page_id );

						$page_title = get_sub_field( 'title' ) ? get_sub_field( 'title' ) : get_the_title( $page_id );

						echo '<li><a href="' . esc_url( $page_link ) . '">' . esc_html( $page_title ) . '</a></li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</section>