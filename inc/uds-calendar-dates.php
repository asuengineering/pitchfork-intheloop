<?php
/**
 * Inner Circle UDS Calendar Dates
 * When called will return an array of dates associated with the current post ID.
 * Can be fed into the JS function for producing a UDS Calendar component.
 *
 * @param int $post A post ID
 * @return array $output Returns array of strings representing dates associated with the post.
 */
function innercircle_post_calendar_date($post) {

    $output = array();
    
    $eventmeta = get_field('ic_event_meta_entry', $post);

    if (have_rows('ic_event_meta_entry', $post)) :

        // Loop through rows.
        while( have_rows('ic_event_meta_entry', $post) ) : the_row();

            // Required meta fields.
            $display = get_sub_field('ic_event_meta_display');
            $start_dt = get_sub_field('ic_event_meta_start_dt');
            $end_dt = get_sub_field('ic_event_meta_end_dt');

            // Date and time strings.
            $start_date = date('F d, Y', strtotime($start_dt));
            $end_date = date('F d, Y', strtotime($end_dt));

            // Output depending on the type of event displayed.
            if ('deadline' === $display) {

                $output[] = $end_date;

            } else {

                $output[] = $start_date;
            }
            
        // End loop.
        endwhile;

    endif;

    return $output;
}