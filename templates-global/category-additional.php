<?php
/**
 * Produces post-column faux blocks based on a limited selection interface within the tag edit screen.
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$term = get_queried_object();
$taglist = get_field('ic_category_associated_tags', $term);
$tagcount = get_field('ic_category_associated_tags_count', $term);
$featuredimage = '';

if ($taglist) {

    // Determine column class based on the number of terms selected.
    $colnum = count($taglist);
    $colclass = '';
    if ($colnum < 3) {
        $colclass="col-md-6";
    } else {
        $colclass="col-md-4";
    }

    // There's at least one tag to display. Set up the section.

    echo '<section class="uds-section bg-color bg-gray-1">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<h2><span class="highlight-black">Related posts</span></h2>';
    echo '<p>Be sure to check out the following posts for additional opportinities.</p>';
    echo '</div></div>';
    echo '<div class="row ic-post-columns">';
    
    foreach ($taglist as $tag) {

        // Define args, build a new query.
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $tagcount,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'terms'    => $tag,
                ),
            ),
        );

        $group = new WP_Query( $args );

        if ( $group->have_posts() ) :

            $tagname = get_term($tag, 'post_tag');

            $headline = '<h4><span class="highlight-black">' . $tagname->name . '</span></h4>';
            $storydiv = '';
            $featuredimage = '';

            while ( $group->have_posts() ) : $group->the_post();

                // Check for the first featured image from a selected post.
                // The "arbitrary" choice would be the only one previously set to make $image not empty.
                if ( ( has_post_thumbnail() ) && ( empty($featuredimage) ) ) {
                    $featuredimage = get_the_post_thumbnail(get_the_ID(), 'medium-large', array( 'class' => 'img-fluid' ));
                }

                $storydiv .= '<div class="story">';
                $storydiv .= '<h4><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</h4></a>';
                $eventline = innercircle_event_line( get_the_ID(), false );
                $storydiv .= $eventline;
                $storydiv .= '</div>';
                
            endwhile;

            // If there are no post images within the returned set, use a generic image.
            if (empty($featuredimage)) {
                $featuredimage = '<img class="wp-post-image img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
            }

            // Output.
            echo '<div class="' . $colclass . '">';
            echo '<div class="ic-post-column">';
            echo $headline;
            echo $featuredimage;
            echo $storydiv;
            echo '</div><!-- end .ic-post-column -->';
            echo '</div>';

        else :

            echo '<div class="no-select ' . $colclass . '">';
            echo '<div class="ic-post-column">';
            echo '<h4><span class="highlight-black">No associated posts</span></h4>';
            echo '<img class="wp-post-image img-fluid" src="' . get_stylesheet_directory_uri() . '/img/160602-Success-PapagoPark-011-AD.jpg" alt="ASU student in sillouette, sunset over Papago Park" />';
            echo '<div class="story">There are no stories associated with this tag.</div>';
            echo '</div><!-- end .ic-post-column -->';
            echo '</div>';
    
        endif;

    }

    echo '</div></div></section>';

}

