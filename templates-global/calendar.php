<?php
/**
 * Runs a query on the DB for calendar events and provide the data to FullCalendar.io
 *
 * @package uds-wordpress-theme
 */

// Add to calendar link class
require get_stylesheet_directory() . '/vendor/autoload.php';
use Spatie\CalendarLinks\Link;

add_action( 'wp_enqueue_scripts', 'pass_events_to_fullcalendar' );
function pass_events_to_fullcalendar() {

    // Get the data from WP_Query first.

    // Args. The 'meta_title` field is required.
    // If there are events in the repeater, the meta_entry_0 key will have a value.
    $args = array(
        'posts_per_page'	=> -1,
        'post_type'		=> 'post',
        'meta_query' => array(
            array(
                'key'     => 'ic_event_meta_entry_0_ic_event_meta_title',
                'compare' => 'EXISTS',
            ),
        ),
    );

    $event_posts = new WP_Query( $args );

    do_action( 'qm/debug', 'Found posts: ' . $event_posts->found_posts );

    $event_array = [];

    if ( $event_posts->have_posts() ) :

        while ( $event_posts->have_posts() ) : $event_posts->the_post();

            $permalink = get_the_permalink();
            $post_title = get_the_title();

            // var_dump(the_permalink());

            // Loop through rows within the post 
            while ( have_rows('ic_event_meta_entry') ) : the_row();

                $title = get_sub_field('ic_event_meta_title');
                $description = get_sub_field('ic_event_meta_subtitle');
                $display = get_sub_field('ic_event_meta_display');
                $cta_link_array = get_sub_field('ic_event_meta_link');
                $start_dt = get_sub_field('ic_event_meta_start_dt');
                $end_dt = get_sub_field('ic_event_meta_end_dt');
                $building = get_sub_field('ic_event_meta_building');
                $room = get_sub_field('ic_event_meta_room');
                $agenda = get_sub_field('ic_event_meta_agenda');

                // Basic event details, title, URL, dates
                $event = new stdClass();
                $event->{"title"} = $title;
                $event->{"url"} = $permalink;

                // Determine if date displayed should be all day or a specific interval.
                // Use correct date for proper display on the calendar.
                if ('dates' === $display) {

                    $event->{"start"} = $start_dt;
                    $event->{"end"} = $end_dt;
                    $event->{"allDay"} = true;

                } elseif ('deadline' === $display ) {

                    $event->{"start"} = $end_dt;
                    $event->{"allDay"} = false;

                } else {
                    
                    // Standard date display. Includes the times.
                    $event->{"start"} = $start_dt;
                    $event->{"end"} = $end_dt;
                    $event->{"allDay"} = false;
                }

                // Other data available in "extendedProps" once rendered.
                $event->{"post_title"} = $post_title;
                $event->{"cta_link"} = $cta_link_array;
                $event->{"description"} = $description;
                $event->{"agenda"} = $agenda;
                $event->{"date_string"} = $display;

                // Location details. If/then statement handles unset select box from the UI.
                if ( empty($building)) {
                    $building_name = '';
                    $map_link = '';
                } else {
                    $building_name = $building->name;
                    $map_link = get_field('ic_locationtax_map_url', $building);

                    $event->{"location"} = $building_name . ' ' . $room;
                    $event->{"map_link"} = $map_link;
                }

                // Builds Add to Calendar links from Spatie\CalendarLinks\Link
                // Check for a valid start date, which may be excluded by the "deadline" date type.
                
                $cal_from = date_create_from_format('Y-m-d H:i:s', $start_dt);
                $cal_to = date_create_from_format('Y-m-d H:i:s', $end_dt);

                // Builds Add to Calendar links from Spatie\CalendarLinks\Link
                $cal_from = date_create_from_format('Y-m-d H:i:s', $start_dt);
                $cal_to = date_create_from_format('Y-m-d H:i:s', $end_dt);
                
                $valid_dates = false;
                $valid_dates = validate_add_to_calendar_dates( $cal_from, $cal_to );
                if ($valid_dates) {
                    $cal_link = Link::create( $title, $cal_from, $cal_to)
                        ->description($description)
                        ->address($building_name . ' ' . $room);

                    $event->{"outlook_cal_link"} = $cal_link->ics();
                    $event->{"google_cal_link"} = $cal_link->google();

                } else {
                    
                    // No event links added to the array.
                }

                array_push( $event_array, $event );

            // End get_rows loop.
            endwhile;
        
        // End wp_query loop.
        endwhile;

    endif;

    do_action( 'qm/debug', $event_array );

    // Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );
    $js_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/fullcalendar-init.js' );
	wp_enqueue_script( 'pitchfork-innercircle-fullcalendar-init', get_stylesheet_directory_uri() . '/js/fullcalendar-init.js', array( 'pitchfork-fullcalendar' ), $js_child_version );
    wp_add_inline_script( 'pitchfork-innercircle-fullcalendar-init', 'const CALDATA = ' . json_encode( array(
        'events' => $event_array,
    ) ), 'before' );
}


