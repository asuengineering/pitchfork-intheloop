<?php
/**
 * Functions pertaining to data validation within ACF.
 * 
 * Not included in the child theme as of 09-Aug-2022 because... ACF doesn't support it yet.
 * See response in ACF support ticket for details. TL;DR: Gutenberg is missing a pre-save hook 
 * that they can tie into to perform the action and prevent the save.
 * 
 * Should be WELL TESTED before making this come alive again. =) 
 *
 * @package pitchfork-innercircle
 */

 function return_repeater_row_string($acf_input_name){
    // When using the acf/validate_value filter, the name of the current input is $input_name.
    // That should look something like this: acf[repeater_field_id]][row-xxx][field_id]
    // This function will return 'row-xxx'
    // Use case: Validate a control within a repeater field against another control in the same row.
    $needle = strpos($input_name, 'row-' );
    $secondbracket = strpos($input_name, ']', $needle);
    $length = $secondbracket - $needle;
    $rownum = substr($input_name, $needle, $length);
    
    return $rownum;
 }

/**
 * Validate meta box end date content.
 *    1. End date should be > start date.
 *    2. Except if date type = deadline. It'll be the only date collected at that point.
 */ 
function innercircle_acf_validate_end_date( $valid, $value, $field, $input_name ) {

    do_action( 'qm/debug', 'Arrived');

    // Bail early if value is already invalid.
    if( $valid !== true ) {
        return $valid;
    }

    // EndDate Field ID: field_60930e835b060
    // StartDate Field ID: field_60930de85b05f
    
    // Calculate which row is being accessed in the repeater.
    $rownum = return_repeater_row_string($input_name);
    $start_date = $_POST['acf']['field_6093127e5b065'][$rownum]['field_60930de85b05f'];

    // Get start date, make sure that both are the same date format.
    $start_dts = strtotime($start_date);
    $end_dts = strtotime($value);

    if (! $start_dts) {
        // strtotime returns false if the date string can't be converted.
        // Likely means that the control is unset. No validation necessary in that case.
        return $valid;
    }

    if ( $start_dts > $end_dts ) {
        return __( 'The end time must occur after the start time.');
    } else {
        return $valid;
    }
}
add_filter('acf/validate_value/name=ic_event_meta_end_dt', 'innercircle_acf_validate_end_date', 10, 4);
