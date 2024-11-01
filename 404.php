<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<main id="main" class="padding-top">
<!-- hero -->
<section id="hero" class="hero d-flex align-items-center hero--default mb-0">
    <div class="hero__inner container-xl">
        <div class="row h-100">
            <div class="col-lg-6 hero__content d-flex flex-column justify-content-center order-2 order-lg-1 py-5" data-aos="fade">
                <h1 class="mb-4">404 - Page Not Found</h1>
                <div class="hero__content fs-5 mb-4">We can't seem to find the page you're looking for</div>
                <div class="hero__cta">
                    <a class="button mb-4" href="/">Return to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
<?php
get_footer();