<section class="featured_in py-4">
    <div class="container-xl featured_in__grid">
        <div class="featuredSwiper swiper">
            <div class="swiper-wrapper">
        	<?php
        	foreach ( get_field( 'featured_logos','options' ) as $l ) {
            	?>
            	<div class="swiper-slide"><?= wp_get_attachment_image( $l, 'full', false, array( 'width' => '305', 'height' => '90' ) ); ?></div>
            	<?php
        	}
        	?>
        </div>
    </div>
</section>
<?php
add_action(
	'wp_footer',
	function () {
    	?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js" nitro-exclude></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script defer nitro-exclude>
window.addEventListener('load', function () {
    console.log('[Featured Swiper] Window loaded');

    const container = document.querySelector('.featuredSwiper');
    if (!container) {
        console.warn('[Featured Swiper] No .featuredSwiper found in DOM');
        return;
    }

    const images = container.querySelectorAll('img');
    console.log(`[Featured Swiper] Found ${images.length} images`);

    if (images.length === 0) {
        console.warn('[Featured Swiper] No images found — initialising anyway');
        initSwiper();
        return;
    }

    Promise.all(
        Array.from(images).map((img, i) => {
            if (img.complete && img.naturalHeight !== 0) {
                console.log(`[Featured Swiper] Image ${i} already loaded`);
                return Promise.resolve();
            }

            return new Promise((resolve) => {
                img.addEventListener('load', () => {
                    console.log(`[Featured Swiper] Image ${i} loaded`);
                    resolve();
                }, { once: true });

                img.addEventListener('error', () => {
                    console.warn(`[Featured Swiper] Image ${i} failed to load`);
                    resolve(); // still resolve to avoid stalling
                }, { once: true });
            });
        })
    ).then(() => {
        console.log('[Featured Swiper] All images loaded — initialising Swiper');
        initSwiper();
    });

    function initSwiper() {
        console.log('[Featured Swiper] Calling new Swiper()');

        const featuredSwiper = new Swiper('.featuredSwiper', {
            autoplay: true,
            slidesPerView: 2,
            spaceBetween: 10,
            loop: false,
            lazyPreloadPrevNext: 2,
            breakpoints: {
                576: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                992: {
                    slidesPerView: 5,
                    spaceBetween: 20
                }
            }
        });

        console.log('[Featured Swiper] Swiper instance:', featuredSwiper);
    }
});
</script>
    	<?php
	},
	9999
);