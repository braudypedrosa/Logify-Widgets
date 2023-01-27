<?php ob_start();

define('REQUEST_URL_PROPERTY_SUMMARY', 'https://www.bookerville.com/API-PropertySummary?');
define('REQUEST_URL_PROPERTY_DETAILS', 'https://www.bookerville.com/API-PropertyDetails?');


function _bookerville_fetch_all_properties(){
    
    $xml_response  = simplexml_load_string(_bookerville_get(REQUEST_URL_PROPERTY_SUMMARY));

    foreach($xml_response->children() as $property) {
        $property_id = $property['property_id'];
        $bkvAccountId = $property['bkvAccountId'];
        $managerFirstName = $property['managerFirstName'];
        $managerLastName = $property['managerLastName'];
        $managerPhone = $property['managerPhone'];
        $businessName = $property['businessName'];
        $offLine = $property['offLine'];
    }
}

function _bookerville_fetch_property_details($property_id) {

    $parameter = '&bkvPropertyId='.$property_id;
    $xml_response = simplexml_load_string(_bookerville_get(REQUEST_URL_PROPERTY_DETAILS, $parameter));

    foreach($xml_response->children() as $property_detail) {

    }
}


function _bookerville_get($request_url, $parameter = '') {
    $key = get_option('_bookerville_secret_key');

    // echo $request_url.'s3cr3tK3y='.$key.''.$parameter;

    $response = wp_remote_get($request_url.'s3cr3tK3y='.$key.''.$parameter);
    $responseBody = wp_remote_retrieve_body( $response );

    return $responseBody;
}

