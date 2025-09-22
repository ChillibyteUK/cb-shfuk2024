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
    if ( ! is_page() ) return;

    $HUB_ID = 4942; // Locations hub page ID

    $post = get_queried_object();
    if ( ! $post instanceof WP_Post ) return;

    // Is this page a descendant of the hub?
    $ancestors = get_post_ancestors( $post );
    $is_descendant = ($post->post_parent == $HUB_ID) || in_array( $HUB_ID, $ancestors, true );
    if ( ! $is_descendant ) return;

    // Find the "location" page in the ancestor chain:
    // - If this page is a direct child of HUB_ID, the location is this page
    // - Otherwise, pick the ancestor whose parent is HUB_ID (the first-level child under the hub)
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
        // Fallback: if not found for some reason, use current post
        if ( ! $location_post_id ) {
            $location_post_id = $post->ID;
        }
    }

    $location_name = get_the_title( $location_post_id );
    $url           = get_permalink( $post );
    $title_name    = $location_name ? "Sell House in {$location_name}" : 'Sell House';

    // Yoast meta description (fallback to excerpt)
    $description = '';
    if ( class_exists( 'WPSEO_Meta' ) ) {
        $description = WPSEO_Meta::get_value( 'metadesc', $post->ID );
    }
    if ( ! $description ) {
        $description = wp_strip_all_tags( get_the_excerpt( $post ) );
    }

    $schema = [
        "@context" => "https://schema.org",
        "@type"    => "Product",
        "@id"      => trailingslashit( $url ) . "#product",
        "name"     => $title_name,
        "url"      => $url,
        "description" => $description,
        "image"    => [
            "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg"
        ],
        "brand" => [
            "@type" => "Brand",
            "@id"   => "https://sellhousefast.uk/#brand",
            "name"  => "Sell House Fast",
            "logo"  => "https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg",
            "sameAs" => [
                "https://sellhousefast.uk/"
            ]
        ],
        "aggregateRating" => [
            "@type"       => "AggregateRating",
            "@id"         => trailingslashit( $url ) . "#aggregateRating",
            "ratingValue" => 4.8,
            "bestRating"  => 5,
            "worstRating" => 1,
            "ratingCount" => 42
        ]
    ];

    echo '<script type="application/ld+json">' .
         wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) .
         '</script>';
}, 20 );