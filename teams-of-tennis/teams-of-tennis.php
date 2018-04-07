<?php
/*
Plugin Name:  Teams of Tennis
Plugin URI:   https://github.com/Volker2014/wp_teams_of_tennis
Description:  manage tennis teams and clubs from BTV page
Version:      0.6
Author:       Volker Riecken
Author URI:   https://github.com/Volker2014
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Min WP Version: 4.9.0
Max WP Version: 4.9.4

Teams of Tennis is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Teams of Tennis is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Teams of Tennis. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

require_once(ABSPATH . 'wp-includes/pluggable.php');

if (!function_exists('file_get_html')) {
	//include_once(plugin_dir_path(__FILE__).'simple_html_dom.php');
}

$vr_stateimagepath = plugin_dir_url(__FILE__) . 'public/images/';
$vr_templatepath = dirname(__FILE__) . '/templates/';

define( 'VR_TENNIS_TEAM_SUFFIX', 'btv_team' );
define( 'VR_TENNIS_GAME_SUFFIX', 'btv_game' );
define( 'VR_TENNIS_PLAYER_SUFFIX', 'btv_player' );
define( 'VR_TENNIS_SCORE_SUFFIX', 'vr_livescore' );

include_once(plugin_dir_path(__FILE__).'includes/install.php');
include_once(plugin_dir_path(__FILE__).'includes/options.php');
include_once(plugin_dir_path(__FILE__).'includes/teamlink.php');
include_once(plugin_dir_path(__FILE__).'includes/clublink.php');
include_once(plugin_dir_path(__FILE__).'includes/available.php');
include_once(plugin_dir_path(__FILE__).'includes/creategames.php');
include_once(plugin_dir_path(__FILE__).'includes/livescore.php');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('VR_TennisOptions', 'action_links'));
?>