<?php
/**
 * Block Registration and Block Template
 *
 * Block name: Post Column
 * Author: Steve Ryan
 * Version: 1.0
 *
 * @package pitchfork-innercircle
 *
 */

$text_origin = get_field('ic_post_column_content_origin');
$image_origin = get_field('ic_post_column_image_origin');
$featured_story = get_field('ic_post_column_content_featured');
$header_size = get_field('ic_post_column_header_size');
$highlight_style = get_field('ic_post_column_header_highlight');

if ('arbitrary' == $image_origin) {
    $image = get_field('ic_post_column_image_upload');
    $image = wp_get_attachment_image( $image , 'medium-large', false, array( 'class' => 'img-fluid' ));
    $image = uds_wp_remove_thumbnail_height_width_attr($image);
} else {
    // 'automatic' == $image_origin
    // If this is supposed to be automatic, the logic will need to happen within the loop.
    
    // The logic should be this: 
    // -- Look for the featured image of the selected tag if that is the text_origin.
    // -- Look for any featured image of any selected post beginning with the first displayed.
    // -- Finally, select a default generic image and display it.
    $image = '';
    
} 

if (('post_tag' == $text_origin ) || ('category' == $text_origin ))  {

    if ('post_tag' == $text_origin ) {
        $selected = get_field('ic_post_column_content_tag');
    } elseif ('category' == $text_origin ) {
        $selected = get_field('ic_post_column_content_category');
    }

    $story_count = get_field('ic_post_column_content_count');
    $offset = get_field('ic_post_column_content_offset');

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $story_count,
        'offset' => $offset,
        'tax_query' => array(
            array(
                'taxonomy' => $text_origin,
                'terms'    => $selected,
            ),
        ),
    );

    $group = new WP_Query( $args );

    if ( $group->have_posts() ) :

        $storydiv = '';

        while ( $group->have_posts() ) : $group->the_post();
                            
            // Check for the first featured image from a selected post.
            // The "arbitrary" choice would be the only one previously set to make $image not empty.
            if ( ( has_post_thumbnail() ) && ( empty($image) ) ) {
                $image = get_the_post_thumbnail(get_the_ID(), 'medium-large', array( 'class' => 'img-fluid' ));
            }

            $storydiv .= '<div class="story">';
            $storydiv .= '<h4><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</h4></a>';
            // $eventline = innercircle_event_line( get_the_ID(), false );
            // $storydiv .= $eventline;
            $storydiv .= '</div>';
            
        endwhile;

        $term = get_term($selected, $text_origin);
        if ('none' != $header_size) {
            $headline = '<' . $header_size . '><span class="' . $highlight_style . '">' . $term->name . '</span></' . $header_size . '>';
        } else {
            $headline = '';
        }
        

        // Final featured image checks. 
        // Grab the featured image from the tag taxonomy if there is one.
        if (empty($image) && ('post_tag' === $text_origin )) {
            $tagimage = get_field('ic_tag_featured_image', $term);
            $image = wp_get_attachment_image( $tagimage, 'medium-large', false, array( 'class' => 'img-fluid' ));
        }

        if (empty($image)) {
            $image = '<img class="img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
        }

        // Output.

        echo '<div class="ic-post-column">';
        echo $headline;
        echo $image;
        echo $storydiv;
        echo '</div><!-- end .ic-post-column -->';

    else :

        echo '<div class="ic-post-column">';
        echo '<h3><span class="highlight-black">No selection</span></h3>';
        echo '<img class="img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
        echo '<div class="story"><a href="#">There are no stories selected</a></story>';
        echo '</div><!-- end .ic-post-column -->';

    endif;

} else {
    // $text_origin is equal to "arbirtrary"
    // Returned object from ACF is a WP_Post object already, so no additional query needed.

    $selected = get_field('ic_post_column_content_posts');

    $storydiv = '';

    if (!empty($selected)) {

        foreach( $selected as $story ):     

            // Check for a featured image if there hasn't already been one set. 
            // The "arbitrary" choice would be the only one previously set.
            if ( ( has_post_thumbnail($story->ID) ) && ( empty($image) ) ) {
                $image = get_the_post_thumbnail($story->ID, 'medium-large', array( 'class' => 'img-fluid'));
            }

            $storydiv .= '<div class="story">';
            $storydiv .= '<h4><a href="' . get_the_permalink($story->ID) . '" title="' . get_the_title($story->ID) . '">' . get_the_title($story->ID) . '</a></h4>';
            // $eventline = innercircle_event_line( $story->ID, false );
            // $storydiv .= $eventline;
            $storydiv .= '</div>';


        endforeach;

        if (empty($image)) {
            $image = '<img class="img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
        }

        // Output.
        echo '<div class="ic-post-column">';
        echo $image;
        echo $storydiv;
        echo '</div><!-- end .ic-post-column -->';
    
    } else {

        echo '<div class="ic-post-column">';
        echo '<h4><span class="highlight-black">No selection</span></h4>';
        echo '<img class="img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
        echo '<div class="story"><a href="#">There are no stories selected</a></story>';
        echo '</div><!-- end .ic-post-column -->';
    }
}


