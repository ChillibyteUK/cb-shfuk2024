<section class="featured_in py-4">
    <div class="container-xl featured_in__grid">
		<div class="row justify-content-center align-items-center text-center">
		<?php
		foreach ( get_field( 'featured_logos', 'options' ) as $l ) {
			?>
		<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
			<?php
			echo wp_get_attachment_image(
				$l,
				'full',
				false,
				array(
					'width'   => '190',
					'height'  => '56',
					'loading' => 'eager',
					'style'   => 'max-width: 190px; max-height: 56px; width: 100%; height: auto;',
				)
			);
			?>
		</div>
			<?php
		}
		?>
    </div>
</section>
