<?php

function parse_phone($phone)
{
    $phone = preg_replace('/\s+/', '', $phone);
    $phone = preg_replace('/\(0\)/', '', $phone);
    $phone = preg_replace('/[\(\)\.]/', '', $phone);
    $phone = preg_replace('/-/', '', $phone);
    $phone = preg_replace('/^0/', '+44', $phone);
    return $phone;
}

function split_lines($content)
{
    $content = preg_replace('/<br \/>/', '<br/>&nbsp;<br/>', $content);
    return $content;
}

function textarea_array($content) {
    // Replace <br> tags with newline characters
    $string_with_newlines = str_replace('<br />', "\n", $content);
    
    // Split the string by newline characters into an array
    $array_of_values = explode("\n", $string_with_newlines);
    
    // Trim whitespace from each value and remove empty values
    $array_of_values = array_map('trim', $array_of_values);
    $array_of_values = array_filter($array_of_values, function($value) {
        return !empty($value);
    });
    
    return $array_of_values;
}

add_shortcode('contact_address', 'contact_address');

function contact_address()
{
    $output = get_field('contact_address', 'options');
    return $output;
}

add_shortcode('contact_phone', 'contact_phone');
function contact_phone()
{
    if (get_field('contact_phone', 'options')) {
        return '<a href="tel:' . parse_phone(get_field('contact_phone', 'options')) . '">' . get_field('contact_phone', 'options') . '</a>';
    }
    return;
}

add_shortcode('contact_email', 'contact_email');

function contact_email()
{
    if (get_field('contact_email', 'options')) {
        return '<a href="mailto:' . get_field('contact_email', 'options') . '">' . get_field('contact_email', 'options') . '</a>';
    }
    return;
}


add_shortcode('social_in_icon', function () {
    $s = get_field('social', 'options') ?? null;
    if ($s['linkedin_url'] ?? null) {
        return '<a href="' . get_field('linkedin_url', 'options') . '" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>';
    }
    return;
});
add_shortcode('social_tw_icon', function () {
    $s = get_field('social', 'options') ?? null;
    if ($s['twitter_url'] ?? null) {
        return '<a href="' . get_field('twitter_url', 'options') . '" target="_blank" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>';
    }
    return;
});

add_shortcode('social_icons', 'social_icons');

function social_icons($size = null)
{
    
    $s = get_field('socials', 'options') ?? null;

    $size = $size ?? null;

    $output = '<div class="social_icons">';
    if ($s['linkedin_url'] ?? null) {
        $output .= '<a href="' . $s['linkedin_url'] . '" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in ' . $size . '"></i></a>';
    }
    if ($s['youtube_url'] ?? null) {
        $output .= '<a href="' . $s['youtube_url'] . '" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-youtube ' . $size . '"></i></a>';
    }
    if ($s['instagram_url'] ?? null) {
        $output .= '<a href="' . $s['instagram_url'] . '" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram ' . $size . '"></i></a>';
    }
    if ($s['facebook_url'] ?? null) {
        $output .= '<a href="' . $s['facebook_url'] . '" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook-f ' . $size . '"></i></a>';
    }
    if ($s['twitter_url'] ?? null) {
        $output .= '<a href="' . $s['twitter_url'] . '" target="_blank" aria-label="Twitter"><i class="fa-brands fa-x-twitter ' . $size . '"></i></a>';
    }
    $output .= '</div>';

    return $output;

}

/**
 * Grab the specified data like Thumbnail URL of a publicly embeddable video hosted on Vimeo.
 *
 * @param  str $video_id The ID of a Vimeo video.
 * @param  str $data 	  Video data to be fetched
 * @return str            The specified data
 */
function get_vimeo_data_from_id($video_id, $data)
{
    // width can be 100, 200, 295, 640, 960 or 1280
    $request = wp_remote_get('https://vimeo.com/api/oembed.json?url=https://vimeo.com/' . $video_id . '&width=960');
    
    $response = wp_remote_retrieve_body($request);
    
    $video_array = json_decode($response, true);
    
    return $video_array[$data] ?? null;
}


function gb_gutenberg_admin_styles()
{
    echo '
        <style>
            /* Main column width */
            .wp-block {
                max-width: 1040px;
            }
 
            /* Width of "wide" blocks */
            .wp-block[data-align="wide"] {
                max-width: 1080px;
            }
 
            /* Width of "full-wide" blocks */
            .wp-block[data-align="full"] {
                max-width: none;
            }

            /* fix Yoast metabox */
            #editor .edit-post-layout__metaboxes {
               margin-top: 3rem;
            }
        </style>
    ';
}
add_action('admin_head', 'gb_gutenberg_admin_styles');



// God I hate Gravity Forms
// Change textarea rows to 4 instead of 10
// add_filter('gform_field_content', function ($field_content, $field) {
//     if ($field->type == 'textarea') {
//         return str_replace("rows='10'", "rows='4'", $field_content);
//     }
//     return $field_content;
// }, 10, 2);


function get_the_top_ancestor_id()
{
    global $post;
    if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    } else {
        return $post->ID;
    }
}

function cb_json_encode($string)
{
    // $value = json_encode($string);
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $string);
    $result = json_encode($result);
    return $result;
}

function cb_time_to_8601($string)
{
    $time = explode(':', $string);
    $output = 'PT' . $time[0] . 'H' . $time[1] . 'M' . $time[2] . 'S';
    return $output;
}

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function cb_social_share($id)
{
    ob_start();
    $url = get_the_permalink($id);

    ?>
<div class="text-larger text--yellow mb-5">
    <div class="h4 text-dark">Share</div>
    <a target='_blank' href='https://twitter.com/share?url=<?=$url?>'
        class="mr-2"><i class='fab fa-twitter'></i></a>
    <a target='_blank'
        href='http://www.linkedin.com/shareArticle?url=<?=$url?>'
        class="mr-2"><i class='fab fa-linkedin-in'></i></a>
    <a target='_blank'
        href='http://www.facebook.com/sharer.php?u=<?=$url?>'><i
            class='fab fa-facebook-f'></i></a>
</div>
<?php
    
    $out = ob_get_clean();
    return $out;
}

function cbdump($var)
{
    // ob_start();
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    return; // ob_get_clean();
}

function cb_list($field)
{
    ob_start();
    $field = strip_tags($field, '<br />');
    $bullets = preg_split("/\r\n|\n|\r/", $field);
    foreach ($bullets as $b) {
        if ($b == '') {
            continue;
        }
        ?>
<li><?=$b?></li>
<?php
    }
    return ob_get_clean();
}

function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// function enable_strict_transport_security_hsts_header()
// {
//     header('Strict-Transport-Security: max-age=31536000');
// }
// add_action('send_headers', 'enable_strict_transport_security_hsts_header');

// REMOVE TAG AND COMMENT SUPPORT

// Disable Tags Dashboard WP
// add_action('admin_menu', 'my_remove_sub_menus');

function my_remove_sub_menus()
{
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
// Remove tags support from posts
function myprefix_unregister_tags()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
// add_action('init', 'myprefix_unregister_tags');

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

function remove_comments()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'remove_comments');


function estimate_reading_time_in_minutes($content = '', $words_per_minute = 300, $with_gutenberg = false, $formatted = false)
{
    // In case if content is build with gutenberg parse blocks
    if ($with_gutenberg) {
        $blocks = parse_blocks($content);
        $contentHtml = '';

        foreach ($blocks as $block) {
            $contentHtml .= render_block($block);
        }

        $content = $contentHtml;
    }
            
    // Remove HTML tags from string
    $content = wp_strip_all_tags($content);
            
    // When content is empty return 0
    if (!$content) {
        return 0;
    }
            
    // Count words containing string
    $words_count = str_word_count($content);
            
    // Calculate time for read all words and round
    $minutes = ceil($words_count / $words_per_minute);
    
    if ($formatted) {
        $minutes = '<p class="reading">Estimated reading time ' . $minutes . ' ' . pluralise($minutes, 'minute') . '</p>';
    }

    return $minutes;
}

function pluralise($quantity, $singular, $plural=null)
{
    if($quantity==1 || !strlen($singular)) {
        return $singular;
    }
    if($plural!==null) {
        return $plural;
    }

    $last_letter = strtolower($singular[strlen($singular)-1]);
    switch($last_letter) {
        case 'y':
            return substr($singular, 0, -1).'ies';
        case 's':
            return $singular.'es';
        default:
            return $singular.'s';
    }
}

function get_wp_menus()
{
    $menus = wp_get_nav_menus();
    $menu_options = array();
    
    foreach ($menus as $menu) {
        $menu_options[ $menu->term_id ] = $menu->name;
    }
    
    return $menu_options;
}

function acf_load_menu_field_choices($field)
{
    // Reset choices
    $field['choices'] = array();
    
    // Get menus
    $menus = get_wp_menus();
    
    // Populate choices
    if (!empty($menus)) {
        foreach ($menus as $key => $value) {
            $field['choices'][$key] = $value;
        }
    }
    
    return $field;
}
add_filter('acf/load_field/name=sidebar_menu', 'acf_load_menu_field_choices');


// Function to display pages in a hierarchical list
function display_page_hierarchy($parent_id = 0) {

    $posts_page_id = get_option('page_for_posts');

    // Get the pages with the specified parent, sorted by title
    $args = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'parent' => $parent_id,
        'sort_column' => 'post_title',  // Sort by post title for alphabetical order
        'sort_order' => 'ASC',          // Sort ascending (A-Z)
        'exclude' => $posts_page_id     // Exclude the posts page (blog index)
    );

    $pages = get_pages($args);

    $output = '';
    
    if (!empty($pages)) {
        $output .= '<ul>';
        foreach ($pages as $page) {
            // check index status
            $noindex = get_post_meta($page->ID, '_yoast_wpseo_meta-robots-noindex', true);

            if ($noindex != '1') {
                $output .= '<li><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a>';

                // Recursively display child pages, also sorted by title
                $output .= display_page_hierarchy($page->ID); // Get nested child pages

                $output .= '</li>';
            }
        }
        $output .= '</ul>';
    }

    return $output;
}

// Register the shortcode to display the hierarchical page list
function register_page_list_shortcode() {
    // Start output buffering
    ob_start();

    // Display the hierarchical list
    echo display_page_hierarchy();

    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('page_list', 'register_page_list_shortcode');

// Function to display posts in a flat list
function display_post_list() {
    // Get all published posts, sorted by title
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => 'title', // Sort posts by title
        'order' => 'ASC',      // Sort in ascending order (A-Z)
        'posts_per_page' => -1  // Retrieve all posts
    );

    $posts = get_posts($args);

    $output = '';

    if (!empty($posts)) {
        $output = '<ul><li><a href="' . get_site_url() . '"/insights/">Property Blog</a><ul>';
        foreach ($posts as $post) {
            $output .= '<li><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></li>';
        }
        $output .= '</ul></li></ul>';
    }

    return $output;
}

// Register the shortcode to display the post list
function register_post_list_shortcode() {
    // Start output buffering
    ob_start();

    // Display the post list
    echo display_post_list();

    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('post_list', 'register_post_list_shortcode');


// SESSIONS STUFF

// add_action('init', 'start_custom_session', 1);
// function start_custom_session() {
//     if (!session_id()) {
//         session_start();
//     }
// }

// add_action('wp_ajax_store_session_data', 'store_session_data');
// add_action('wp_ajax_nopriv_store_session_data', 'store_session_data');

// function store_session_data() {
//     if (!session_id()) {
//         session_start();
//     }

//     if (isset($_POST['referring_url'])) {
//         $_SESSION['referring_url'] = sanitize_text_field($_POST['referring_url']);
//     }

//     if (isset($_POST['first_page'])) {
//         $_SESSION['first_page'] = sanitize_text_field($_POST['first_page']);
//     }

//     if (isset($_POST['url_parameters'])) {
//         $_SESSION['url_parameters'] = sanitize_text_field($_POST['url_parameters']);
//     }

//     echo json_encode(['status' => 'success', 'message' => 'Session data stored successfully']);

//     wp_die(); // Ends AJAX request properly
// }

// // Function to get session data
// function getSessionData() {
//     $sessionData = [
//         'referring_url' => isset($_SESSION['referring_url']) ? $_SESSION['referring_url'] : '',
//         'first_page' => isset($_SESSION['first_page']) ? $_SESSION['first_page'] : '',
//         'url_parameters' => isset($_SESSION['url_parameters']) ? $_SESSION['url_parameters'] : '',
//     ];
        
//     return $sessionData;
// }

// // Gravity Forms hook to populate fields dynamically
// add_filter('gform_field_value_first_page', 'populate_first_page');
// function populate_first_page() {
//     $sessionData = getSessionData();
//     return $sessionData['first_page'];
// }

// add_filter('gform_field_value_referring_url', 'populate_referring_url');
// function populate_referring_url() {
//     $sessionData = getSessionData();
//     return $sessionData['referring_url'];
// }

// add_filter('gform_field_value_url_parameters', 'populate_url_parameters');
// function populate_url_parameters() {
//     $sessionData = getSessionData();
//     return $sessionData['url_parameters'];
// }

/*
function storeSessionData() {
    if (!isset($_SESSION['data_captured'])) {
        // Store referring URL if available
        if (!isset($_SESSION['referring_url']) && isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['referring_url'] = $_SERVER['HTTP_REFERER'];
        }

        // Store current page URL
        // $currentPageUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        // $_SESSION['first_page'] = $currentPageUrl;

        if (!isset($_SESSION['first_page'])) {
            $firstPageUrl = "https://" . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
            $_SESSION['first_page'] = $firstPageUrl;
            // echo "First Page URL stored: " . $_SESSION['first_page'] . "<br>";
        }

            // Store all URL parameters as a string
        if (!isset($_SESSION['url_parameters']) && !empty($_SERVER['QUERY_STRING'])) {
            $_SESSION['url_parameters'] = $_SERVER['QUERY_STRING'];
            // echo "URL Parameters stored: " . $_SESSION['url_parameters'] . "<br>";
        }
    
        // this splits the url parameters into name/value pairs
        // $parametersToCapture = [
        //     'utm_term', 'utm_campaign', 'utm_source', 'utm_medium',
        //     'hsa_acc', 'hsa_cam', 'hsa_grp', 'hsa_ad',
        //     'hsa_src', 'hsa_tgt', 'hsa_kw', 'hsa_mt',
        //     'hsa_net', 'hsa_ver', 'gad_source'
        // ];
        
        // parse_str($_SERVER['QUERY_STRING'], $queryParams);
        // foreach ($parametersToCapture as $param) {
        //     if (isset($queryParams[$param])) {
        //         $_SESSION[$param] = $queryParams[$param];
        //         // echo "URL Parameter {$param} stored: " . $queryParams[$param] . "<br>";
        //     }
        // }

        // Mark data as captured
        $_SESSION['data_captured'] = true;
    }
}


// Function to get session data
function getSessionData() {
    $sessionData = [
        'referring_url' => isset($_SESSION['referring_url']) ? $_SESSION['referring_url'] : '',
        'first_page' => isset($_SESSION['first_page']) ? $_SESSION['first_page'] : '',
        'url_parameters' => isset($_SESSION['url_parameters']) ? $_SESSION['url_parameters'] : '',
    ];
    
    // this is if the parameters are split
    // Add specific URL parameters to session data
    // $parametersToCapture = [
    //     'utm_term', 'utm_campaign', 'utm_source', 'utm_medium',
    //     'hsa_acc', 'hsa_cam', 'hsa_grp', 'hsa_ad',
    //     'hsa_src', 'hsa_tgt', 'hsa_kw', 'hsa_mt',
    //     'hsa_net', 'hsa_ver', 'gad_source'
    // ];
    
    // foreach ($parametersToCapture as $param) {
    //     $sessionData[$param] = isset($_SESSION[$param]) ? $_SESSION[$param] : '';
    // }
    
    return $sessionData;
}
// Gravity Forms hook to populate fields dynamically
add_filter('gform_field_value_first_page', 'populate_first_page');
function populate_first_page() {
    $sessionData = getSessionData();
    return $sessionData['first_page'];
}

add_filter('gform_field_value_referring_url', 'populate_referring_url');
function populate_referring_url() {
    $sessionData = getSessionData();
    return $sessionData['referring_url'];
}

add_filter('gform_field_value_url_parameters', 'populate_url_parameters');
function populate_url_parameters() {
    $sessionData = getSessionData();
    return $sessionData['url_parameters'];
}

*/
?>