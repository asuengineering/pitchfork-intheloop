<?php

function uds_wordpress_child_add_font_awesome_pro() {
    // Deregister the free version of FA from the parent theme.
	wp_dequeue_script('uds-wordpress-fa-scripts');

	// Register Font Awesome Pro from a generated kit.
	$kit_url = 'https://kit.fontawesome.com/c4a74c102f.js';

	wp_enqueue_script( 'uds-wordpress-child-font-awesome', $kit_url, array(), null, true );
	wp_script_add_data( 'uds-wordpress-child-font-awesome', array('crossorigin'), array('anonymous') );

}
add_action( 'wp_enqueue_scripts', 'uds_wordpress_child_add_font_awesome_pro', 100 );