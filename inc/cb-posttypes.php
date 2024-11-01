<?php
function create_location_taxonomy() {
    $labels = [
        'name'                       => 'Locations',
        'singular_name'              => 'Location',
        'menu_name'                  => 'Locations',
        'all_items'                  => 'All Locations',
        'edit_item'                  => 'Edit Location',
        'view_item'                  => 'View Location',
        'update_item'                => 'Update Location',
        'add_new_item'               => 'Add New Location',
        'new_item_name'              => 'New Location Name',
        'search_items'               => 'Search Locations',
        'not_found'                  => 'No locations found',
        'no_terms'                   => 'No locations',
        'items_list_navigation'      => 'Locations list navigation',
        'items_list'                 => 'Locations list',
        'back_to_items'              => '← Go to locations',
        'item_link'                  => 'Location Link',
        'item_link_description'      => 'A link to a location'
    ];

    $args = [
        'labels'                     => $labels,
        'public'                     => true,
        'publicly_queryable'         => false,
        'hierarchical'               => true,
        'show_ui'                    => true,
        'show_in_menu'               => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'locations',
        'rest_namespace'             => 'wp/v2',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'show_tagcloud'              => true,
        'show_in_quick_edit'         => true,
        'show_admin_column'          => true,
        'rewrite'                    => false, // Disable rewrite to avoid archive pages
        'query_var'                  => false // Disable query var to avoid archive pages
    ];

    register_taxonomy('location', ['post', 'page'], $args);
}
add_action('init', 'create_location_taxonomy');

// Flush rewrite rules to ensure changes take effect
function flush_rewrite_rules_on_activation() {
    create_location_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');

// Flush rewrite rules on theme switch
add_action('after_switch_theme', 'flush_rewrite_rules_on_activation');

?>
