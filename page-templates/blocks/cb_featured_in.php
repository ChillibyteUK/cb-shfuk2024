<section class="featured_in py-4">
    <div class="container-xl featured_in__grid">
		<div class="row justify-content-center align-items-center text-center">
		<?php
		foreach ( get_field( 'featured_logos', 'options' ) as $l ) {
			?>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 my-2">
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
