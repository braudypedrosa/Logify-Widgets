<?php 


// Add Shortcode
function display_lodgify_calendar( $atts ) {

    // shortcode attributes
    $data = shortcode_atts(
        array(
            'listingid' => '',
        ), 
        $atts, 
        'lodgify_calendar' 
    );


    if(!$data['listingid'] == 0) {
        $ID = rand(00000, 99999);
        $availableDates = _lcw_get_property_availability($data['listingid']);


        return '<div class="lcw_availability_calendar" id="'.$ID.'" data-id="lcw_ac_'.$ID.'" data-disabledDates="'.implode(',', $availableDates).'"><div class="calendar" id="calendar1"></div><div class="calendar" id="calendar2"></div><div class="calendar" id="calendar3"></div></div>';
    } else {
        return 'Listing ID is required!';
    }
    
}
add_shortcode( 'lodgify_calendar', 'display_lodgify_calendar' );




function display_lodgify_booking_widget( $atts ) {

    $data = shortcode_atts(
        array(
            'listingid' => '',
            'minstay' => 1,
        ), 
        $atts, 
        'lodgify_booking_widget' 
    );

    $roomID = _lcw_get_info_by_property_id($data['listingid'])[0];
    $minPrice = _lcw_get_info_by_property_id($data['listingid'])[1];


    if(!$data['listingid'] == 0) {
        $ID = rand(00000, 99999);
        $availableDates = _lcw_get_property_availability($atts['listingid']);

        return '<div class="lcw_booking_widget" data-bookingurl="https://checkout.lodgify.com/oceanfrontpropertiesinc/en/?currency=USD#" data-listingid="'.$data['listingid'].'" data-minstay="'.$data['minstay'].'" data-roomid="'.$roomID.'" data-minprice="'.$minPrice.'" data-disabledDates="'.implode(',', $availableDates).'"><div class="lcw_form_errors"></div><div class="lcw_bw_top_info">from $ '.$minPrice.' per night</div><div class="lcw_daterange input-daterange"><input type="text" class="form-control arrival" placeholder="Check in"><input type="text" disabled class="form-control departure" placeholder="Check out"><input type="text" class="lcw_guests" placeholder="Guests"><div class="lcw_bw_calculations"></div><button class="lcw_form_button">Book</button></div></div>';
    
    } else {
        return 'Listing ID is required!';
    }
}

add_shortcode( 'lodgify_booking_widget', 'display_lodgify_booking_widget' );

