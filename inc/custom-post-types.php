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
		'hierarchical'               => false,
		'public'                     => true,
        'show_ui'                    => true,
        'show_in_quick_edit'         => false,
        'meta_box_cb'                => false,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
	);
	register_taxonomy( 'event_location', array( 'post' ), $args );

}
add_action( 'init', 'innercircle_add_location_taxonomy', 0 );

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