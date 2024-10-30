<?php
/*
Plugin Name: Live Your Legend Badge
Plugin URI: ***
Description: Add a simple Live Your Legend badge to your sidebar or with a shortcode
Author: Chris Forte
Version: 1.0
Author URI: http:tutticommunications.com
*/
class LYLBadge 
{
	public function __construct ( array $args = null ) {
		add_action( 'widgets_init', function(){
			register_widget( 'LYLBadge_Widget' );
		});
	}
}

include_once ('lyl-widget.php');
new LYLBadge();
?>