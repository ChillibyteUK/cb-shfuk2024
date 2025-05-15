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
<script defer nitro-exclude>
window.addEventListener('load', function () {
    const container = document.querySelector('.featuredSwiper');
    if (!container) return;

    const images = container.querySelectorAll('img');
    if (images.length === 0) {
        initSwiper(); // fallback if no images
        return;
    }

    let loadedCount = 0;
    const total = images.length;

    const checkAllLoaded = () => {
        loadedCount++;
        if (loadedCount === total) {
            initSwiper();
        }
    };

    const initSwiper = () => {
        const featuredSwiper = new Swiper('.featuredSwiper', {
            autoplay: true,
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
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
    };

    images.forEach(function (img) {
        if (img.complete && img.naturalHeight !== 0) {
            checkAllLoaded();
        } else {
            img.addEventListener('load', checkAllLoaded, { once: true });
            img.addEventListener('error', checkAllLoaded, { once: true }); // in case it fails
        }
    });
});
</script>
    	<?php
	},
	9999
);