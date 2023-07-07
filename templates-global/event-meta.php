<?php
/**
 * Displays a series of cards at the bottom of an IC post/
 * Geared toward the captured event details and calendar display of posts.
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add to calendar link class
require get_stylesheet_directory() . '/vendor/autoload.php';
use Spatie\CalendarLinks\Link;

// Loop through the ACF Event repeater field.
if( have_rows('ic_event_meta_entry') ):

    // Loop through rows.
    while( have_rows('ic_event_meta_entry') ) : the_row();

        $title = get_sub_field('ic_event_meta_title');
        $subtitle = get_sub_field('ic_event_meta_subtitle');
        $display = get_sub_field('ic_event_meta_display');
        $link = get_sub_field('ic_event_meta_link');
        $start_dt = get_sub_field('ic_event_meta_start_dt');
        $end_dt = get_sub_field('ic_event_meta_end_dt');
        $building = get_sub_field('ic_event_meta_building');
        $room = get_sub_field('ic_event_meta_room');
        $agenda = get_sub_field('ic_event_meta_agenda');

        // do_action('qm/debug', $building);

        // Location details. If/then statement handles unset select box from the UI.
        if (empty($building)) {
            $building_name = '';
            $map_link = '';
        } else {
            $building_name = $building->name;
            $map_link = get_field('ic_locationtax_map_url', $building);
        }

        // Output the whole string of either of the fields are filled out. 
        // If not, keep it empty and prevent the icon from being produced.
        if ( (!empty($building_name)) || (!empty($room)) ) {
            $card_location_string = '<p><span class="fas fa-map-marker-alt"></span>';

            if (! empty($building_name)) {
                $card_location_string .= '<a href="' . esc_url($map_link) . '">' . $building_name . '</a> ' . $room . '</p>';
            } else {
                $card_location_string .= $building_name . ' ' . $room . '</p>';
            }
            
        } else {
            $card_location_string = '';
        }


        // The output, starting with opening column + card + card header
        ?>

        <div class="card card-ic-event">
            <div class="card-header">

        <?php 

        if (! empty( $title )) {
            echo '<h3>' . $title . '</h3>';
        }

        if (! empty( $subtitle )) {
            echo '<p>' . $subtitle . '</p>';
        }

        echo '</div>';
        echo '<div class="card-details">';

        // Card details
        $start_full = date_create_from_format('Y-m-d H:i:s', $start_dt);
        $start_date = date('F d, Y', strtotime($start_dt));
        $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),date('g:i a', strtotime($start_dt)));

        $end_full = date_create_from_format('Y-m-d H:i:s', $end_dt);
        $end_date = date('F d, Y', strtotime($end_dt));
        $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),date('g:i a', strtotime($end_dt)));

        if ('dates' === $display ) {

            ?>

                <p><span class="far fa-calendar"></span>Start: <?php echo $start_date; ?></p>
                <p><span class="far fa-calendar"></span>End: <?php echo $end_date; ?></p>
                <?php echo $card_location_string; ?>

            <?php

        } elseif ('agenda' === $display ) {

            ?>

                <p><span class="far fa-calendar"></span><?php echo $start_date; ?></p>
                <p><?php echo wp_kses_post( $agenda ); ?><p>
                <?php echo $card_location_string; ?>
                
            <?php

        } elseif ('deadline' === $display) {

            ?>

                <p><span class="far fa-alarm-exclamation"></span><?php echo $end_date; ?> by <?php echo $end_time; ?></p>
                <?php echo $card_location_string; ?>

            <?php

        } else {
            
            // Handles 'standard' === $display and any errors.
            ?>
                
                <p><span class="far fa-calendar"></span><?php echo $start_date; ?></p>
                <p><span class="far fa-clock"></span><?php echo $start_time . ' - ' . $end_time; ?></p>
                <?php echo $card_location_string; ?>

            <?php
        }

        if (! empty($link)) {
            echo '<a class="btn btn-md btn-maroon" href="' . esc_html($link['url']) . '">' . esc_html($link['title']) . '</a>';
        }

        echo '</div>'; // end .card-details.

        // Builds Add to Calendar links from Spatie\CalendarLinks\Link
        $cal_from = date_create_from_format('Y-m-d H:i:s', $start_dt);
        $cal_to = date_create_from_format('Y-m-d H:i:s', $end_dt);
        
        $valid_dates = false;
        $valid_dates = validate_add_to_calendar_dates( $cal_from, $cal_to );
        if ($valid_dates) {
            $cal_link = Link::create( $title, $cal_from, $cal_to)
                ->description($subtitle)
                ->address($card_location_string);

            $cal_add_string = '<div class="card-footer">';
            $cal_add_string .= '<a href="' . $cal_link->ics() . '" target="_blank">Add to Outlook</a>';
            $cal_add_string .= '<a href="' . $cal_link->google() . '" target="_blank">Add to Google</a>';
            $cal_add_string .= '</div>';

        } else {
            $cal_add_string = '';
        }
        
        echo $cal_add_string;
        echo '</div>'; // end .card.

    // End loop.
    endwhile;

// No value.
else :
    // Do something...
endif;