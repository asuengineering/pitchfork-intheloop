<?php
/**
 * Declare custom post types for the theme.
 * Yes, this is "supposed" to be in a plugin. ¯\_(ツ)_/¯
 *
 * @package pitchfork-innercircle
 */

/**
 * TAX: Locations. Tied to posts for event information metabox only.
 */
function innercircle_add_location_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Locations', 'text_domain' ),
		'all_items'                  => __( 'All Locations', 'text_domain' ),
		'parent_item'                => __( 'Parent Location', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Location:', 'text_domain' ),
		'new_item_name'              => __( 'New Location Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Location', 'text_domain' ),
		'edit_item'                  => __( 'Edit Location', 'text_domain' ),
		'update_item'                => __( 'Update Location', 'text_domain' ),
		'view_item'                  => __( 'View Location', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate locations with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove locations', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Locations', 'text_domain' ),
		'search_items'               => __( 'Search Locations', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No locations', 'text_domain' ),
		'items_list'                 => __( 'Locations list', 'text_domain' ),
		'items_list_navigation'      => __( 'Locations list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_in_quick_edit'         => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'event_location', array( '' ), $args );

}
add_action( 'init', 'innercircle_add_location_taxonomy', 0 );

/**
 * TAX: Audiences. Registered to standard posts.
 */
function itl_add_audience_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Audiences', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Audience', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Audiences', 'text_domain' ),
		'all_items'                  => __( 'All Audiences', 'text_domain' ),
		'parent_item'                => __( 'Parent Audience', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Audience:', 'text_domain' ),
		'new_item_name'              => __( 'New Audience Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Audience', 'text_domain' ),
		'edit_item'                  => __( 'Edit Audience', 'text_domain' ),
		'update_item'                => __( 'Update Audience', 'text_domain' ),
		'view_item'                  => __( 'View Audience', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate audiences with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove audiences', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Audiences', 'text_domain' ),
		'search_items'               => __( 'Search Audiences', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No audiences', 'text_domain' ),
		'items_list'                 => __( 'Audiences list', 'text_domain' ),
		'items_list_navigation'      => __( 'Audiences list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_in_quick_edit'         => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'audience', array( 'post' ), $args );

}
add_action( 'init', 'itl_add_audience_taxonomy', 0 );

/**
 * TAX: Organizations. Meant to fulfill references to both a FSE school and an internal FSE unit.
 * Registered to standard posts.
 */
function itl_add_organization_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Organizations', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Organization', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Organizations', 'text_domain' ),
		'all_items'                  => __( 'All Organizations', 'text_domain' ),
		'parent_item'                => __( 'Parent Organization', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Organization:', 'text_domain' ),
		'new_item_name'              => __( 'New Organization Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Organization', 'text_domain' ),
		'edit_item'                  => __( 'Edit Organization', 'text_domain' ),
		'update_item'                => __( 'Update Organization', 'text_domain' ),
		'view_item'                  => __( 'View Organization', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate organizations with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove organizations', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Organizations', 'text_domain' ),
		'search_items'               => __( 'Search Organizations', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No organizations', 'text_domain' ),
		'items_list'                 => __( 'Organizations list', 'text_domain' ),
		'items_list_navigation'      => __( 'Organizations list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_in_quick_edit'         => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'organization', array( 'post' ), $args );

}
add_action( 'init', 'itl_add_organization_taxonomy', 0 );

/**
 * TAX: Series. References to ongoing series of posts + letters from Kyle
 * Registered to standard posts.
 */
function itl_add_series_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Series', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Series', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Series', 'text_domain' ),
		'all_items'                  => __( 'All Series', 'text_domain' ),
		'parent_item'                => __( 'Parent Series', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Series:', 'text_domain' ),
		'new_item_name'              => __( 'New Series Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Series', 'text_domain' ),
		'edit_item'                  => __( 'Edit Series', 'text_domain' ),
		'update_item'                => __( 'Update Series', 'text_domain' ),
		'view_item'                  => __( 'View Series', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate series with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove series', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Series', 'text_domain' ),
		'search_items'               => __( 'Search Series', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No series', 'text_domain' ),
		'items_list'                 => __( 'Series list', 'text_domain' ),
		'items_list_navigation'      => __( 'Series list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
        'show_ui'                    => true,
        'show_in_quick_edit'         => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'series', array( 'post' ), $args );

}
add_action( 'init', 'itl_add_series_taxonomy', 0 );

/**
 * Remove default 'tag' taxonomy from posts post type. Straight from the docs:
 * https://developer.wordpress.org/reference/functions/unregister_taxonomy_for_object_type/#comment-2332
 */
function itl_unregister_tags_for_posts() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'itl_unregister_tags_for_posts' );

/**
 * Hide the description field on the taxonomy term UI.
 */
function innercircle_hide_location_taxonomy_description() {
    echo '<style>
        body.taxonomy-event_location .term-description-wrap {
            display:none;
        }
  </style>';
}
add_action('admin_head', 'innercircle_hide_location_taxonomy_description');
