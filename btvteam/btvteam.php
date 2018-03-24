<?php
/*
Plugin Name: BTV Team
Plugin URI: 
Description: Show a BTV Team, create games from btv team page, manage available page
Version: 0.2
Author: Volker Riecken
Author URI: 
Update Server: 
Min WP Version: 4.9.4
Max WP Version: 4.9.4
*/

require_once( ABSPATH . "wp-includes/pluggable.php" );

if (!function_exists('file_get_html')) {
	//include_once(plugin_dir_path(__FILE__).'simple_html_dom.php');
}

include_once(plugin_dir_path(__FILE__).'install.php');
include_once(plugin_dir_path(__FILE__).'options.php');
include_once(plugin_dir_path(__FILE__).'teamlink.php');
include_once(plugin_dir_path(__FILE__).'creategames.php');

define( 'BTV_TEAM_SUFFIX', 'btv_team' );
define( 'BTV_GAME_SUFFIX', 'btv_game' );
define( 'BTV_PLAYER_SUFFIX', 'btv_player' );

function BtvAvailable($atts) {
	global $wpdb;
	global $BTV_TEAM_SUFFIX;
	global $BTV_GAME_SUFFIX;
	
	if (!is_user_logged_in()) {
		return '';
	}
	
	extract(shortcode_atts(array(
 
                    "width" => '100%',
 
                    "height" => '500',
 
                    "team" => ''
 
                    ), $atts));
					
	$btv_team_table = $wpdb->prefix . BTV_TEAM_SUFFIX;
	$btv_game_table = $wpdb->prefix . BTV_GAME_SUFFIX;

	$ligaid = get_id($btv_team_table, "team='" . $team . "'");
	$games = $wpdb->get_results("SELECT * FROM $btv_game_table WHERE ligaid=" . $ligaid);
	print_r($games);
	return '';
}

add_shortcode("btvavailable", "BtvAvailable");

;
?>