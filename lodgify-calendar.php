<?php
/*
Plugin Name: Lodgify Calendar Widgets
Plugin URI: 
Description: Display a calendar widgets based on property ID from Hostaway
Author: Braudy Pedrosa
Version: 1.3
Author URI: https://www.buildupbookings.com/
*/


// avoid direct access
if ( !function_exists('add_filter') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define('LCW_VERSION', "1.0"); 
define('LCW_DIR', plugin_dir_path( __FILE__ )); 
define('LCW_URL', plugin_dir_url( __FILE__ )); 


include_once(LCW_DIR.'functions.php');
include_once(LCW_DIR.'shortcodes.php');


// load scripts
function _lcw_enqueue_scripts(){
	// wp_enqueue_script( 'datepicker-script', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array('jquery'));
	// wp_enqueue_style( 'datepicker-style', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css' );
	wp_enqueue_script( 'calendar-script', LCW_URL . 'lib/availability-calendar/datepicker/js/bootstrap-datepicker.min.js', array( 'jquery' ) );
	wp_enqueue_style( 'calendar-style', LCW_URL . 'lib/availability-calendar/datepicker/css/bootstrap-datepicker.min.css' );
	wp_enqueue_script( 'moment-js ', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', array('jquery'));
	// wp_enqueue_style( 'calendar-custom-style', LCW_URL . 'lib/availability-calendar/datepicker/css/custom.css' );

	wp_enqueue_script('lcw-script', LCW_URL . 'assets/lodgify-calendar.js', array('jquery'));
	wp_enqueue_style( 'lcw-style', LCW_URL . 'assets/lodgify-calendar.css' );

}

add_action( 'wp_enqueue_scripts', '_lcw_enqueue_scripts' );