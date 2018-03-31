<?php
/*
Plugin Name:  Teams of Tennis
Plugin URI: 
Description:  manage tennis teams and clubs from BTV page
Version:      0.5
Author:       Volker Riecken
Author URI: 
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Min WP Version: 4.9.4
Max WP Version: 4.9.4

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

require_once(ABSPATH . 'wp-includes/pluggable.php');

if (!function_exists('file_get_html')) {
	//include_once(plugin_dir_path(__FILE__).'simple_html_dom.php');
}

$vr_stateimagepath = plugin_dir_url(__FILE__) . 'public/images/';

define( 'VR_TENNIS_TEAM_SUFFIX', 'btv_team' );
define( 'VR_TENNIS_GAME_SUFFIX', 'btv_game' );
define( 'VR_TENNIS_PLAYER_SUFFIX', 'btv_player' );

//include_once(plugin_dir_path(__FILE__).'uninstall.php');
include_once(plugin_dir_path(__FILE__).'includes/install.php');
include_once(plugin_dir_path(__FILE__).'includes/options.php');
include_once(plugin_dir_path(__FILE__).'includes/teamlink.php');
include_once(plugin_dir_path(__FILE__).'includes/clublink.php');
include_once(plugin_dir_path(__FILE__).'includes/available.php');
include_once(plugin_dir_path(__FILE__).'includes/creategames.php');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('VR_TennisOptions', 'action_links'));
?>