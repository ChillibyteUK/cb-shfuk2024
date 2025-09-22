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
 * JSON-LD Product schema for Locations pages and their subpages.
 * Works for children AND grandchildren of the Locations hub.
 */
add_action('wp_head', function () {
    if (!is_page()) return;

    global $post;
    if (!$post) return;

    // ← robust under-Locations check
    if (!cb_is_under_locations($post->ID)) return;

    // --- Get location name from taxonomy (preferred) ---
    $locName = cb_get_location_name($post->ID);
    if (!$locName) {
        // Fallback: try last word(s) of title
        $locName = preg_replace('/^.*\b([A-Za-z\p{L}\-\' ]+)\s*$/u', '$1', get_the_title($post));
        $locName = trim($locName);
    }

    $url  = get_permalink($post);
    if (!$url) return;

    $slug = $post->post_name;

    // Template chooser
    $templates = [
        'cash-house-buyers' => [
            'name_tmpl'     => 'Cash House Buyers %s',
            'desc_fallback' => 'Looking for cash house buyers in %1$s? We buy houses fast for cash regardless of condition. Get a cash offer now and sell in your timeframe.',
        ],
        'sell-house-fast' => [
            'name_tmpl'     => 'Sell House Fast %s',
            'desc_fallback' => 'Thinking of selling your %1$s house fast? Sell House Fast offers quick cash sales. Get a free offer and sell your house quickly!',
        ],
        'sell-flat-fast' => [
            'name_tmpl'     => 'Sell Flat Fast %s',
            'desc_fallback' => 'Sell your %1$s flat fast for cash directly to Sell House Fast. Skip the listing hassle and get a quick offer!',
        ],
        'sell-tenanted-property' => [
            'name_tmpl'     => 'Sell Tenanted Property %s',
            'desc_fallback' => 'Thinking of selling your %1$s property with tenants? Sell House Fast makes it easy. Get a free offer and sell fast!',
        ],
        '_default' => [
            'name_tmpl'     => 'Sell House in %s',
            'desc_fallback' => 'Need to sell your home in %1$s? We buy houses in any condition and close quickly. Get your free cash offer today to start your sale.',
        ],
    ];

    $key = '_default';
    foreach (['cash-house-buyers','sell-house-fast','sell-flat-fast','sell-tenanted-property'] as $needle) {
        if (stripos($slug, $needle) !== false) { $key = $needle; break; }
    }

    $name = sprintf($templates[$key]['name_tmpl'], $locName);

    // Yoast description if available; otherwise template fallback
    $desc = '';
    if (function_exists('wpseo_replace_vars')) {
        $yoast = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
        if ($yoast) $desc = wpseo_replace_vars($yoast, $post);
    }
    if ($desc === '' || $desc === null) {
        $desc = sprintf($templates[$key]['desc_fallback'], $locName);
    }

    $json = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        '@id'      => rtrim($url, '/') . '#product',
        'name'     => $name,
        'url'      => $url,
        'description' => $desc,
        'image'    => [
            'https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg',
        ],
        'brand' => [
            '@type' => 'Brand',
            '@id'   => 'https://sellhousefast.uk/#brand',
            'name'  => 'Sell House Fast',
            'logo'  => 'https://sellhousefast.uk/wp-content/themes/cb-shfuk2024/img/sellhousefast-logo--dark.svg',
            'sameAs'=> ['https://sellhousefast.uk/'],
        ],
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            '@id'   => rtrim($url, '/') . '#aggregateRating',
            'ratingValue' => 4.8,
            'bestRating'  => 5,
            'worstRating' => 1,
            'ratingCount' => 42,
        ],
    ];

    echo "\n<script type=\"application/ld+json\">"
       . wp_json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
       . "</script>\n";
}, 20);

/** Robust “under Locations” check (children & grandchildren) */
function cb_is_under_locations(int $postId): bool {
    $LOC_ID  = 4942;                 // your Locations hub page ID
    $LOC_URL = home_url('/locations/');

    // direct parent
    if ((int) get_post_field('post_parent', $postId) === $LOC_ID) return true;

    // any ancestor id is the hub
    $anc = array_map('intval', (array) get_post_ancestors($postId));
    if (in_array($LOC_ID, $anc, true)) return true;

    // top ancestor slug is 'locations'
    if ($anc) {
        $topId = (int) end($anc);
        $top   = get_post($topId);
        if ($top && $top->post_name === 'locations') return true;
    }

    // URL safety net (works even if parentage is odd)
    $perma = get_permalink($postId);
    if ($perma && stripos($perma, trailingslashit($LOC_URL)) === 0) return true;

    return false;
}

/** Get the Location taxonomy term name for a page (first term if multiple). */
function cb_get_location_name(int $postId): string {
    $terms = get_the_terms($postId, 'location');
    if (is_wp_error($terms) || empty($terms)) return '';
    $term = array_shift($terms);
    return is_object($term) ? trim($term->name) : '';
}