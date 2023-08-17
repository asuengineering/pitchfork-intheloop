<?php

/**
 * Inner Circle Event Line
 * When called will echo a one line summary of any attached event meta data that is present on a post.
 *
 * @param int $post A post ID
 * @param bool $include_category Return the categories as well.
 * @return string $output Returns the HTML markup required.
 */
function innercircle_event_line($post, $include_category) {

    $output = '';

    $eventmeta = get_field('ic_event_meta_entry', $post);

    // If eventmeta is empty, the array won't be countable. Produces a warning.
    if (empty($eventmeta)) {
        $eventmeta = [];
    }

    if (count($eventmeta) > 1 ) :

        $output .= '<div class="event-meta"><span class="far fa-calendar"></span>Multiple dates and times</div>';

        if ( $include_category ) {
            $categories_list = preg_replace( '/<a /', '<a class="btn btn-tag btn-tag-alt-white"', get_the_category_list( ' ' ) );
            $output .= '<div class="card-tags">' . $categories_list . '</div>';
        } else {
            // No category string desired.
        }

    elseif (have_rows('ic_event_meta_entry', $post)) :

        // Loop through rows.
        while( have_rows('ic_event_meta_entry', $post) ) : the_row();

            // Required meta fields.
            $display = get_sub_field('ic_event_meta_display');
            $start_dt = get_sub_field('ic_event_meta_start_dt');
            $end_dt = get_sub_field('ic_event_meta_end_dt');
            $location = get_sub_field('ic_event_meta_location');

            // Date and time strings.
            $start_date = date('F d, Y', strtotime($start_dt));
            $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),date('g:i a', strtotime($start_dt)));

            $end_date = date('F d, Y', strtotime($end_dt));
            $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),date('g:i a', strtotime($end_dt)));

            // Location details. If/then statement handles unset select box from the UI.
			$building = $location['building'] ?? '';

            if (empty($building)) {
                $building_name = '';
            } else {
                $building_name = $building->name;
            }

            if (!empty($location)){
                $location_string = '<span class="fas fa-map-marker-alt"></span>'. $building_name . ' ' . $location['room'];
            } else {
                $location_string = '';
            }

            $eventmeta = '';

            // Output depending on the type of event displayed.
            if ('dates' === $display ) {

                $eventmeta .= '<span class="far fa-calendar"></span>' . $start_date . ' through ' .  $end_date;

            } elseif ('agenda' === $display ) {

                $eventmeta .= '<span class="far fa-calendar"></span>' . $start_date ;

            } elseif ('deadline' === $display) {

                $eventmeta .= '<span class="far fa-alarm-exclamation"></span>' . $end_date . ' by ' . $end_time;

            } else {
                // Handles 'standard' === $display and any errors.
                $eventmeta .= '<span class="far fa-calendar"></span>' . $start_date . '<span class="far fa-clock"></span>' . $start_time . ' - ' . $end_time;
            }

            $output = '<div class="event-meta">' . $eventmeta . $location_string . '</div>';

            if ( $include_category ) {
                $categories_list = preg_replace( '/<a /', '<a class="btn btn-tag btn-tag-alt-white"', get_the_category_list( ' ' ) );
                $output .= '<div class="card-tags">' . $categories_list . '</div>';
            } else {
                // No category string desired.
            }

        // End loop.
        endwhile;

    endif;

    return $output;
}
