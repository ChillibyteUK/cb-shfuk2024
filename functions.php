<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('CB_THEME_DIR', WP_CONTENT_DIR . '/themes/cb-shfuk2024');

require_once CB_THEME_DIR . '/inc/cb-theme.php';


function understrap_remove_scripts()
{
    wp_dequeue_style('understrap-styles');
    wp_deregister_style('understrap-styles');

    wp_dequeue_script('understrap-scripts');
    wp_deregister_script('understrap-scripts');

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles()
{

    // Get the theme data.
    $the_theme     = wp_get_theme();
    $theme_version = $the_theme->get('Version');

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    // Grab asset urls.
    $theme_styles  = "/css/child-theme{$suffix}.css";
    $theme_scripts = "/js/child-theme{$suffix}.js";
    
    $css_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_styles);

    wp_enqueue_style('child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), time()); //$css_version );
    wp_enqueue_script('jquery');
    
    $js_version = $theme_version . '.' . filemtime(get_stylesheet_directory() . $theme_scripts);
    
    wp_enqueue_script('child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true);

}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


function add_child_theme_textdomain()
{
    load_child_theme_textdomain('cb-shfuk2024', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'add_child_theme_textdomain');

function kill_theme($themes)
{
    unset($themes['understrap']);
    return $themes;
}
add_filter('wp_prepare_themes_for_js', 'kill_theme');


add_action('wp_dashboard_setup', 'remove_draft_widget', 999);
function remove_draft_widget()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

add_action( 'wp_head', function() {
    if ( is_single( 4943 ) ) { ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Product",
          "@id": "https://sellhousefast.uk/locations/birmingham/#product",
          "name": "Sell House in Birmingham",
          "url": "https://sellhousefast.uk/locations/birmingham/",
          "description": "Need to sell your home in Birmingham? We buy houses in any condition and close quickly. Get your free cash offer today to start your sale.",
          "image": [
            "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg"
          ],
          "brand": {
            "@type": "Brand",
            "@id": "https://sellhousefast.uk/#brand",
            "name": "Sell House Fast",
            "logo": "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg",
            "sameAs": [
              "https://sellhousefast.uk/"
            ]
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "@id": "https://sellhousefast.uk/locations/birmingham/#aggregateRating",
            "ratingValue": 4.8,
            "bestRating": 5,
            "worstRating": 1,
            "ratingCount": 42
          }
        }
        </script>
    <?php } elseif ( is_single(5179) ) { ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Product",
          "@id": "https://sellhousefast.uk/locations/london/cash-house-buyers-london/#product",
          "name": "Cash House Buyers London",
          "url": "https://sellhousefast.uk/locations/london/cash-house-buyers-london/",
          "description": "Looking for cash house buyers in London? We buy houses fast for cash regardless of condition. Get a cash offer now and sell in your timeframe.",
          "image": [
            "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg"
          ],
          "brand": {
            "@type": "Brand",
            "@id": "https://sellhousefast.uk/#brand",
            "name": "Sell House Fast",
            "logo": "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg",
            "sameAs": [
              "https://sellhousefast.uk/"
            ]
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "@id": "https://sellhousefast.uk/locations/london/cash-house-buyers-london/#aggregateRating",
            "ratingValue": 4.8,
            "bestRating": 5,
            "worstRating": 1,
            "ratingCount": 42
          }
        }
        </script>
    <?php
    }
});