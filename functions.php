<?php ob_start();

define('AVAILABILITY_API_GATEWAY', 'https://api.lodgify.com/v2/availability/');
define('PROPERTIES_API_GATEWAY', 'https://api.lodgify.com/v2/properties/');


// load template
function _lcw_listing_load_template(){
	include_once(LCW_DIR.'/settings.php');
}

// initialize sub menu for settings
function _lcw_register_submenu_page(){

	add_menu_page( 
		__( 'Lodgify Calendar Widgets', 'textdomain' ),
		'Lodgify Calendar',
		'manage_options',
		'lodgify_widgets',
		'_lcw_listing_load_template',
		'dashicons-calendar-alt',
	); 
}

add_action( 'admin_menu', '_lcw_register_submenu_page' );


function _lcw_get_info_by_property_id($listingID) {

	// API request
	$response = wp_remote_get( PROPERTIES_API_GATEWAY.$listingID."?includeInOut=false",
		array( 
			'timeout' => 10,
			'headers' => array( 
				'accept' => 'application/json',
				'X-ApiKey'=> get_option('lcw_public_key')
			) 
	));

	$results = json_decode($response['body'], true);

	$data = array();

	array_push($data, $results['rooms'][0]['id']);
	array_push($data, $results['original_min_price']);

	return $data;

}



// get availability of a specific property
function _lcw_get_property_availability($listingID){


    // only check availability within current day to end of the year
    $today = date("Y-m-d");
    $yearEnd = date('Y-m-d', strtotime("+ 6 months"));

    // initialize array for available dates
    $availableDates = array();

    $data = array(
        'start' => $today,
        'end' => $yearEnd,
		'includeDetails' => true,
    );

	// API request
	$response = wp_remote_get( AVAILABILITY_API_GATEWAY.$listingID."?".http_build_query($data),
		array( 
			'timeout' => 10,
			'headers' => array( 
				'accept' => 'application/json',
				'X-ApiKey'=> get_option('lcw_public_key')
			) 
	));

	$results = json_decode($response['body'], true);

	$periods = $results[0]['periods'];

	foreach($periods as $available) {
		if($available['available'] == 0) {
			$start = $available['start'];
			$end = $available['end'];

			if($start == $end) {
				array_push($availableDates, $end);

			} else {
				$between = _lcw_get_between_dates($start, $end);
				$availableDates = array_merge($availableDates, $between);
			}
			
		}
	}

	// echo AVAILABILITY_API_GATEWAY.$listingID."?".http_build_query($data);
	
	return $availableDates;

}

// get dates in between two dates
function _lcw_get_between_dates($startDate, $endDate) {
    $rangArray = [];
 
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
 
    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }
 
    return $rangArray;
}