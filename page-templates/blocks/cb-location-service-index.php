<?php
/**
 * Block template for CB Location Service Index.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

global $post;
$parent_id = $post->post_parent;

$ancestors       = get_post_ancestors( $parent_id );
$top_ancestor_id = $ancestors ? end( $ancestors ) : $post->ID;

$locations_page = get_page_by_path( 'locations', OBJECT, 'page' );

$is_direct_child = ( $parent_id && $locations_page && $parent_id === $locations_page->ID );

if ( $is_direct_child ) {
	return; // this feature will never be used but is retained in case requirements change.

	// phpcs:disable
	// list child pages of this page that use the 'location_page.php' template.
	$children = get_pages(
		array(
			'child_of'    => $post->ID,
			'parent'	  => $post->ID,
			'sort_column' => 'menu_order',
			'sort_order'  => 'ASC',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-templates/location_page.php',
		)
	);

	foreach ( $children as $child ) {
		echo '<a href="' . get_permalink( $child->ID ) . '">' . esc_html( $child->post_title ) . '</a><br>';
	}
	// phpcs:enable
} elseif ( $parent_id ) {

	// list siblings using the 'location_page.php' template.

	$siblings = get_pages(
		array(
			'child_of'    => $parent_id,
			'parent'	  => $parent_id,
			'sort_column' => 'menu_order',
			'sort_order'  => 'ASC',
			'meta_key'	  => '_wp_page_template',
			'meta_value'  => 'page-templates/location_page.php',
		)
	);

	echo '<div class="container py-5 services_nav"><div class="services_nav__grid">';
	foreach ( $siblings as $sibling ) {
		if ( $sibling->ID !== $post->ID ) { // Exclude the current post.
			?>
			<a class="services_nav__card"  href="<?= esc_url( get_permalink( $sibling->ID ) ); ?>">
				<div class="services_nav__inner">
                    <h3><?= esc_html( $sibling->post_title ); ?></h3>
				</div>
			</a>
			<?php
		}
	}
	echo '</div></div>';
} else {
	echo '<p>Something went wrong.</p>';
}
