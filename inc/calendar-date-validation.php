<?php
/**
 * Data validation function to run on start & end dates for the calendar 
 * before attempting to build the Add to Outlook / Add to Google links.
 *
 * @package pitchfork-innercircle
 */


/**
 * Function which returns true or false based on some simple data validation.
 */
function validate_add_to_calendar_dates( $start, $end ) {

    // Are both instances date/time object?
    if (($start instanceof DateTime) && ($start instanceof DateTime)) {
        // do_action('qm/debug', 'Both are dates.');
    } else {
        do_action('qm/debug', 'Missing a date or malformed string.');
        do_action('qm/debug', $start);
        do_action('qm/debug', $end);
        return false;
    }

    // Assuming both are dates, is the start date after the end date?
    if ( $start > $end ) {
        do_action('qm/debug', 'Start before end date.');
        do_action('qm/debug', $start);
        do_action('qm/debug', $end);
        return false;
    }

    // If we haven't returned fase by now, we're OK.
    return true;

}
