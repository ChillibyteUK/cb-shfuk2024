<?php
/**
 * The header for Landing Page template(s)
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package cb-shfuk2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta
        charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/poppins-v21-latin-700.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/poppins-v21-latin-600.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/poppins-v21-latin-regular.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">

    <?php
if (!is_user_logged_in()) {
    if (get_field('gtm_property', 'options')) {
        ?>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer',
            '<?=get_field('gtm_property', 'options')?>'
        );
    </script>
    <!-- End Google Tag Manager -->
        <?php
    }

}


if (is_front_page() || is_page('contact-us')) {
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "SellHouseFast",
            "legalName": "Jolack Limited",
            "url": "https://www.sellhousefast.co.uk/",
            "logo": "https://www.sellhousefast.co.uk/wp-content/themes/cb-shfuk2024/img/shf-logo-large.png",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Office 1.01, 411 - 413 Oxford Street",
                "addressLocality": "London",
                "postalCode": "W1C 2PE",
                "addressCountry": "United Kingdom"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer support",
                "telephone": "[+44 (0) 800 098 3789]",
                "email": "info@sellhousefast.co.uk"
            },
            "sameAs": [
                "https://twitter.com/",
                "https://www.linkedin.com/company/"
            ]
        }
    </script>
    <?php
}
?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
do_action('wp_body_open');

if (get_field('gtm_property', 'options')) {
    if (!is_user_logged_in()) {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe
            src="https://www.googletagmanager.com/ns.html?id=<?=get_field('ga_property', 'options')?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
    }
}
?>
    <header>
        <nav id="navbar" class="navbar navbar-expand-lg" aria-labelledby="main-nav-label">
            <div class="container-xl py-2">
                <a href="/" class="header_logo"><img
                        src="<?=get_stylesheet_directory_uri()?>/img/sellhousefast-logo--dark.svg"
                        width=187 height=58 alt="Sell House Fast" title="SellHouseFast.co.uk"></a>
                <button class="header_toggle navbar-toggler input-button" id="navToggle" data-bs-toggle="collapse"
                    data-bs-target=".navbars" type="button" aria-label="Navigation"><i
                        class="fa fa-navicon"></i></button>
                <div class="header_ctas d-none d-md-block">
                    <a href="/free-cash-offer/" class="button button-sm">FREE CASH OFFER</a>
                    <div>Call us: <?=contact_phone()?></div>
                </div>
            </div>
        </nav>
    </header>