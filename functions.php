<?php
/**
 * UDS WordPress Child Theme functions and definitions
 *
 * @package uds-wordpress-child-theme
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Enqueue child scripts and styles.
 */
function uds_wordpress_child_scripts() {
	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$css_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/css/child-theme.min.css' );
	wp_enqueue_style( 'pitchfork-child-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array( 'pitchfork-styles' ), $css_child_version );
	wp_enqueue_style( 'pitchfork-fullcalendar-styles', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css', array(), null );

	$js_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/child-theme.js' );
	wp_enqueue_script( 'pitchfork-child', get_stylesheet_directory_uri() . '/js/child-theme.js', array(), $js_child_version );
	wp_enqueue_script( 'pitchfork-fullcalendar', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.js', array(), null, false );

}
add_action( 'wp_enqueue_scripts', 'uds_wordpress_child_scripts' );

/**
 * Enqueue the child-theme.css into the editor.
 */
function uds_wp_gutenberg_child_css() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/child-theme.min.css' );

}
add_action( 'after_setup_theme', 'uds_wp_gutenberg_child_css' );


// Other included partials for functions.php.
// ===============================================
require get_stylesheet_directory() . '/inc/custom-post-types.php';
require get_stylesheet_directory() . '/inc/acf-register.php';
require get_stylesheet_directory() . '/inc/font-awesome-pro.php';
require get_stylesheet_directory() . '/inc/event-line.php';
require get_stylesheet_directory() . '/inc/uds-calendar-dates.php';
require get_stylesheet_directory() . '/inc/calendar-date-validation.php';
require get_stylesheet_directory() . '/inc/rest-api-extensions.php';

/** 
 * Pull just the categories from a post.
 * Format as card tags.
 */
function innercircle_print_categories() {
	$categories_list = preg_replace( '/<a /', '<a class="btn btn-tag btn-tag-alt-white"', get_the_category_list( ' ' ) );

	if ( $categories_list ) {
		if ( ! is_single() ) {
			printf( '<div class="card-tags">%s</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			printf( '<div class="category-tags">%s</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

 /** 
 * Pull just the tags from a post.
 * Format as links with a tag icon.
 */
function innercircle_print_tags() {
/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'uds-wordpress-theme' ) );
	if ( $tags_list ) {
		/* translators: %s: Tags of current post */
		printf( '<div class="tags-links"><span class="fas fa-tags" title="Tags"></span>%s</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/** 
 * Combine the two functions above for single.php
 */
function innercircle_print_categories_tags() {
	innercircle_print_categories();
	innercircle_print_tags();
}

/**
 * Hides the display of the default taxonomy description field.
 * 
 * @link https://wordpress.stackexchange.com/questions/253124/remove-category-description-textarea
 */

function innercircle_hide_taxonomy_description_fields() {
	// CSS specifically targets the default tag screens.
	echo '<style type="text/css">';
	echo '.taxonomy-post_tag .term-description-wrap { display:none; }';
	echo '</style>';
}
add_action( 'admin_head-term.php', 'innercircle_hide_taxonomy_description_fields' );
add_action( 'admin_head-edit-tags.php', 'innercircle_hide_taxonomy_description_fields' );

/**
 * Filters the returned HTML of a post_thumbnail call and removes
 * the embedded height and width attributes.
 *
 * @param string $html the inital returned result from the_post_thumbnail.
 * @link https://developer.wordpress.org/reference/functions/the_post_thumbnail/#comment-1945
 */
function uds_wp_remove_thumbnail_height_width_attr( $html ) {
	return preg_replace( '/(width|height)="\d+"\s/', '', $html );
}

/**
 * Convert Hex color string to array of rgb values.
 * @link https://css-tricks.com/snippets/php/convert-hex-to-rgb/
 */
function innercircle_hex2rgb( $color ) {
	if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
	}
	if ( strlen( $color ) == 6 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
			return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

apply_filters('cas_maestro_change_users_capability', 'manage_options');



/**
 * Remove the default WordPress object label from archive title pages.
 * https://developer.wordpress.org/reference/hooks/get_the_archive_title/#user-contributed-notes
 *
 * @param string $title archive title.
 * @return string
 */
function pitchfork_innercircle_custom_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_tax() ) { // for custom post types.
		$title = sprintf( '%1$s', single_term_title( '', false ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'pitchfork_innercircle_custom_archive_title' );