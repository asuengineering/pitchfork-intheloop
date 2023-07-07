<?php
/**
 * Produces a medium-sized hero, based on an image selection and the category name/details.
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$term = get_queried_object();
$hero_bg = get_field('ic_category_hero_bg', $term);

// Set highlight and text color classes based on light/dark TF field.
$text_color_tf = get_field('ic_category_text_color', $term);
if ($text_color_tf) {
    $highlight_color = "highlight-white";
    $text_color = 'text-white';
} else {
    $highlight_color = "highlight-gold";
    $text_color = 'text-dark';
}

// Set hero size based on presence/absence of a description.
if ( empty( get_the_archive_description($term) ) ) {
    $hero_size = 'uds-hero-sm';
} else {
    $hero_size = 'uds-hero-md';
}

// Hero background image is optional. Display a hero if there's enough info for one.
if( $hero_bg ) {

    echo '<div class="' . $hero_size . ' alignfull">';
    echo '<div class="hero-overlay"></div>';
    echo '<img class="hero" src="' . esc_url($hero_bg['url']) . '" alt="' . esc_attr($hero_bg['alt']) . '" />';
    // echo wp_get_attachment_image( $hero_bg, 'full', false, array('class' => 'hero') );
    echo '<div role="doc-subtitle"><span class="' . $highlight_color . '">Category:</span></div>';
    the_archive_title( '<h1 class="' . $text_color . '">', '</h1>' );
    the_archive_description( '<div class="content ' . $text_color . '">', '</div>' );
    // // if (! empty(tag_description($term))) {
    //     echo '<div class="content"><p class="'. $text_color . '">' . tag_description($term) . '</p></div>';
    // }
    echo '</div>';

} else {

    // There's not enough data for a formal hero. Let's still give it a heading.
    echo '<section class="container category-header">';
    echo '<div class="row"><div class="col-md-12">';
    echo '<h3><span class="highlight-gold">Category:</span></h3>';
    the_archive_title( '<h1 class="page-title">', '</h1>' );
    if (! empty(tag_description($term))) {
        echo '<p class="lead '. $text_color . '">' . tag_description($term) . '</p>';
    }
    echo '</div></div></section>';
}

?>
