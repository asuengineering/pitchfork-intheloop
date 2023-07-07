<?php
/**
 * The template for displaying category pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pitchfork-innercircle
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'pass_events_to_uds_calendar' );
function pass_events_to_uds_calendar() {

    // Loop through the active query once to build date array for UDS Calendar.
    // Needs to happen above get_header() call because the result is enqueued to JS.

    if ( have_posts() ) {
        $archive_calendar_dates = array();
        
        // Start the loop.
        while ( have_posts() ) {
            the_post();
            $post_calendar_dates = innercircle_post_calendar_date( get_the_ID() );
            $archive_calendar_dates = array_merge( $archive_calendar_dates, $post_calendar_dates);
        }
    }

    rewind_posts();

    $archive_calendar_dates = array_unique($archive_calendar_dates);

    // Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );
    $js_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/uds-calendar.js' );
    wp_enqueue_script( 'uds-wordpress-uds-calendar', get_stylesheet_directory_uri() . '/js/uds-calendar.js', array(), $js_child_version );
    wp_add_inline_script( 'uds-wordpress-uds-calendar', 'const CALDATA = ' . json_encode( array(
        'events' => $archive_calendar_dates,
    ) ), 'before' );
}

get_header();

?>

<main id="skip-to-content">

    <?php get_template_part( 'templates-global/category' , 'header'); ?>

	<div id="content" class="container pb-6">
        <?php

        if ( have_posts() ) {

            echo '<div class="row">';
            echo '<div class="archive-loop col-md-9">';

            // Start the loop.
            while ( have_posts() ) {
                the_post();
                get_template_part( 'templates-loop/loop-category');
            }

            echo '</div>';      // end article column
            echo '<aside class="col-md-3">';
            echo '<div class="force-mobile" id="calendar"></div>'; // UDS Calendar;
            echo '</aside></div><!-- end .row -->';
        }
        
        // Check for pagination
        global $wp_query;
        $maxpages = $wp_query->max_num_pages;
        if ( $maxpages > 1 ) {
            echo '<div class="row"><div class="col">';
            pitchfork_pagination();
            echo '</div></div>';
        }

        ?>

	</div>

</main><!-- #main -->

<?php 

// Additional post columns based on tag selection.
get_template_part( 'templates-global/category-additional');


// Grid links section for all tags within the current category.
$current = get_queried_object();
$currentID = $current->term_id;
$all_tags = array();
$grid_links = '';

$args = array(
    'posts_per_page'	=> -1,
    'cat'		=> $currentID,
);

// Loop through the query, build an array of all tag IDs.
$tag_query = new WP_Query( $args );
if ( $tag_query->have_posts() ) :

    while ( $tag_query->have_posts() ) : $tag_query->the_post();

        $posttags = get_the_tags();
        if ($posttags) {
            foreach($posttags as $posttag) {
                $all_tags[] = $posttag->term_id;
            }
        }

    endwhile;

    // Clean up array. Loop through it to generate the tag names and links.
    $all_tags = array_unique($all_tags);

    foreach($all_tags as $tag) {
        $tag_object = get_term($tag, 'post_tag');
        $tag_permalink = get_term_link($tag);
        $grid_links .= '<a href="' . $tag_permalink . '" class="link">' . $tag_object->name . '</a>';
    }

    if (! empty ($grid_links)) {
        $grid_links = '<div class="uds-grid-links four-columns ">' . $grid_links . '</div>';
    }

    // Output the whole section if there's data in the query.
    ?>
    <section class="uds-section bg-color bg-gray-6">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><span class="highlight-gold">Related Tags</span></h2>
                        <?php echo wp_kses_post($grid_links); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

endif;
   
get_footer();