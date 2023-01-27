<?php 


// Add Shortcode
function custom_shortcode() {
    _bookerville_fetch_property_details(9972);
}
add_shortcode( 'test', 'custom_shortcode' );

