<section class="featured_in py-4">
    <div class="container-xl featured_in__grid">
        <div class="splide featuredSplide">
            <div class="splide__track">
				<ul class="splide__list">
					<?php
					foreach ( get_field( 'featured_logos', 'options' ) as $l ) {
						?>
					<li class="splide__slide">
						<?php
						echo wp_get_attachment_image(
							$l,
							'full',
							false,
							array(
								'width'   => '305',
								'height'  => '90',
								'loading' => 'eager',
							)
						);
						?>
					</li>
						<?php
					}
					?>
				</ul>
			</div>
        </div>
    </div>
</section>
<?php
add_action(
	'wp_footer',
	function () {
    	?>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js" nitro-exclude></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('.featuredSplide', {
            type: 'loop',
            autoplay: true,
            perPage: 5,
            gap: '20px',
			arrows: false,
			pagination: false,
            breakpoints: {
				992: {
					perPage: 4,
				},
				768: {
					perPage: 3,
				},
                576: {
                    perPage: 2,
                },
            },
        }).mount();
    });
</script>
        <?php
    },
    9999
);