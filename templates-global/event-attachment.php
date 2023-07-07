<?php
/**
 * Displays an icon or thumbnail image for an attached flyer for an IC post.
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$file = get_field('ic_attached_file');

if (! empty($file)) {

    $image = wp_get_attachment_image( $file['ID'], 'thumbnail' );
    $icon = $file['icon'];
    $filepath = $file['url'];

    echo '<div class="media downloads">';

    if (! empty($image)) {
        echo $image;
    } else {
        echo '<img class="attachment-icon" src="' . $icon . '" alt="generic attachment icon" />';
    }

    echo '<div class="media-body">';
    echo '<p>' . $file['title'] . '</p>';
    echo '<p class="file-desc">' . $file['description'] . '</p>';
    echo '<p><a class="btn btn-light" href="' . $filepath . '">Download</a>';
    echo '</div>';

    echo '</div>';
    
}

