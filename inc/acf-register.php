<?php
/**
 * Additional functions for Advanced Custom Fields.
 *
 * Contents:
 *   - Load path for ACF groups from the parent.
 *   - Register custom blocks for the theme.
 *
 * @package pitchfork-innercircle
 */


/**
 * Add additional loading point for the parent theme's ACF groups.
 *
 * @return $paths
 */
add_filter( 'acf/settings/load_json', 'innercircle_parent_theme_field_groups' );
function innercircle_parent_theme_field_groups( $paths ) {
	$path = get_template_directory() . '/acf-json';
	$paths[] = $path;
	return $paths;
}

/**
 * Create a save point for specifc JSON files for the the child theme's ACF groups.
 *
 * Key list
 * - Archive page meta: group_60a5595c1b0a1
 * - Location taxonomy meta: group_6094316005379
 * - Event Meta: group_60930ddbd7be0
 * - Attached flyer: group_60932c8d9b8c5
 *
 * @return $paths
 */
function innercircle_child_theme_field_groups( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}
add_filter( 'acf/settings/save_json/key=group_60a5595c1b0a1', 'innercircle_child_theme_field_groups' );
add_filter( 'acf/settings/save_json/key=group_619e841fc1c6f', 'innercircle_child_theme_field_groups' );
add_filter( 'acf/settings/save_json/key=group_6094316005379', 'innercircle_child_theme_field_groups' );
add_filter( 'acf/settings/save_json/key=group_60930ddbd7be0', 'innercircle_child_theme_field_groups' );
add_filter( 'acf/settings/save_json/key=group_60932c8d9b8c5', 'innercircle_child_theme_field_groups' );
