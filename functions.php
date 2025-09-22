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

/**
 * JSON-LD Product schema for Locations pages and descendants.
 * Chooses template by matching keywords in the page slug/title.
 */
add_action('wp_head', function () {
    if ( ! is_page() ) {
        return;
    }

    $HUB_ID = 4942; // Locations page ID

    $post = get_queried_object();
    if ( ! $post instanceof WP_Post ) {
        return;
    }

    // Ensure this page is the hub, a child of it, or any descendant of it.
    $ancestors    = get_post_ancestors( $post );
    $is_descendant = ($post->post_parent == $HUB_ID) || in_array( $HUB_ID, $ancestors, true ) || ($post->ID == $HUB_ID);
    if ( ! $is_descendant ) {
        return;
    }

    /**
     * Resolve the LOCATION name:
     *  - If this page is a direct child of HUB_ID, location = this page title.
     *  - Else find the ancestor whose parent is HUB_ID (the first-level child).
     *  - Fallback to current page title.
     */
    $location_post_id = 0;
    if ( (int) $post->post_parent === $HUB_ID ) {
        $location_post_id = $post->ID;
    } else {
        foreach ( $ancestors as $ancestor_id ) {
            $parent_id = (int) get_post_field( 'post_parent', $ancestor_id );
            if ( $parent_id === $HUB_ID ) {
                $location_post_id = (int) $ancestor_id;
                break;
            }
        }
        if ( ! $location_post_id ) {
            $location_post_id = $post->ID;
        }
    }
    $LOCATION = trim( get_the_title( $location_post_id ) );

    // Choose template by keyword in slug or title (case-insensitive).
    $slug  = sanitize_title( $post->post_name ?: $post->post_title );
    $title = strtolower( (string) $post->post_title );

    $key = 'core';
    $checks = [
        'cash-house-buyers'      => ['cash-house-buyers'],
        'sell-house-fast'        => ['sell-house-fast'],
        'sell-flat-fast'         => ['sell-flat-fast'],
        'sell-tenanted-property' => ['sell-tenanted-property'],
    ];
    foreach ( $checks as $tpl => $needles ) {
        foreach ( $needles as $needle ) {
            if ( strpos( $slug, $needle ) !== false || strpos( $title, $needle ) !== false ) {
                $key = $tpl;
                break 2;
            }
        }
    }

    // Template definitions: name & default description strings.
    $templates = [
        'core' => [
            'name_fmt' => 'Sell House in LOCATION',
            'desc'     => 'Need to sell your home in LOCATION? We buy houses in any condition and close quickly. Get your free cash offer today to start your sale.',
        ],
        'cash-house-buyers' => [
            'name_fmt' => 'Cash House Buyers LOCATION',
            'desc'     => 'Looking for cash house buyers in LOCATION? We buy houses fast for cash regardless of condition. Get a cash offer now and sell in your timeframe.',
        ],
        'sell-house-fast' => [
            'name_fmt' => 'Sell House Fast LOCATION',
            'desc'     => 'Thinking of selling your LOCATION house fast? Sell House Fast offers quick cash sales. Get a free offer and sell your house quickly!',
        ],
        'sell-flat-fast' => [
            'name_fmt' => 'Sell Flat Fast LOCATION',
            'desc'     => 'Sell your LOCATION flat fast for cash directly to Sell House Fast. Skip the listing hassle and get a quick offer!',
        ],
        'sell-tenanted-property' => [
            'name_fmt' => 'Sell Tenanted Property LOCATION',
            'desc'     => 'Thinking of selling your LOCATION property with tenants? Sell House Fast makes it easy. Get a free offer and sell fast!',
        ],
    ];

    $tpl = $templates[ $key ];

    // Build name with LOCATION token replaced.
    $product_name = str_replace( 'LOCATION', $LOCATION, $tpl['name_fmt'] );

    // Prefer Yoast meta description; else template default (with LOCATION substituted).
    $description = '';
    if ( class_exists( 'WPSEO_Meta' ) ) {
        $description = (string) WPSEO_Meta::get_value( 'metadesc', $post->ID );
    }
    if ( '' === trim( $description ) ) {
        $description = str_replace( 'LOCATION', $LOCATION, $tpl['desc'] );
    }

    $url = get_permalink( $post );
    if ( ! $url ) {
        return;
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        '@id'      => trailingslashit( $url ) . '#product',
        'name'     => $product_name,
        'url'      => $url,
        'description' => $description,
        'image'    => [
            'https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg',
        ],
        'brand' => [
            '@type' => 'Brand',
            '@id'   => 'https://sellhousefast.uk/#brand',
            'name'  => 'Sell House Fast',
            'logo'  => 'https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg',
            'sameAs' => ['https://sellhousefast.uk/'],
        ],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            '@id'         => trailingslashit( $url ) . '#aggregateRating',
            'ratingValue' => 4.8,
            'bestRating'  => 5,
            'worstRating' => 1,
            'ratingCount' => 42,
        ],
    ];

    echo '<script type="application/ld+json">' .
         wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) .
         '</script>';
}, 20);