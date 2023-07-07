<?php

/**
 * Register the ACF event fields for the /event API endpoint.
 *
 * @see https://since1979.dev/add-custom-acf-fields-to-the-wp-rest-api/
 * @uses register_rest_field() https://developer.wordpress.org/reference/functions/register_rest_field/
 * @uses array() https://www.php.net/manual/en/function.array.php
 */

function innercircle_register_post_event_api_fields() {

    register_rest_field(
		'post',
		'ic_events',
		array(
			'get_callback' => 'innercircle_get_post_event_api_fields',
			'schema' => null,
		)
	);
}
add_action( 'rest_api_init', 'innercircle_register_post_event_api_fields' );


/**
 * Fetch and return the value of the ACF event fields.
 *
 * @param   object $post      The Post object.
 *
 * @see https://since1979.dev/add-custom-acf-fields-to-the-wp-rest-api/
 * @uses get_field() https://www.advancedcustomfields.com/resources/get_field/
 */
function innercircle_get_post_event_api_fields( $post ) {

    $postid = $post['id'];

    // Loop through the ACF Event repeater field.
    if ( have_rows('ic_event_meta_entry', $post['id']) ):

        $event_array = get_field('ic_event_meta_entry', $postid);

        return $event_array;

    else :
        // There are no rows to be added to the API.
        return null;

    endif;

}