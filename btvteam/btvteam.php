<?php
/*
Plugin Name: BTV Team
Plugin URI: 
Description: Show a BTV Team, create games from btv team page, manage available page
Version: 0.3
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
include_once(plugin_dir_path(__FILE__).'available.php');
include_once(plugin_dir_path(__FILE__).'creategames.php');

define( 'BTV_TEAM_SUFFIX', 'btv_team' );
define( 'BTV_GAME_SUFFIX', 'btv_game' );
define( 'BTV_PLAYER_SUFFIX', 'btv_player' );

?>