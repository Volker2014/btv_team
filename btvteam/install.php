<?php
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'btvteam_action_links' );

function btvteam_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=BTVTeam') ) .'">Settings</a>';
   return $links;
}

function create_btv_team_table()
{
	global $wpdb;
	global $BTV_TEAM_SUFFIX;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . BTV_TEAM_SUFFIX;
	
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		liga varchar(100) NOT NULL,
		team tinytext NOT NULL,
		PRIMARY KEY  (id),
		UNIQUE KEY (liga)
	) $charset_collate;";

	dbDelta( $sql );
}

function create_btv_game_table()
{
	global $wpdb;
	global $BTV_GAME_SUFFIX;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . BTV_GAME_SUFFIX;
	
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		ligaid mediumint(9) NOT NULL,
		time datetime NOT NULL,
		home tinytext NOT NULL,
		guest tinytext NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	dbDelta( $sql );
}

function create_btv_player_table()
{
	global $wpdb;
	global $BTV_PLAYER_SUFFIX;
	
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . BTV_PLAYER_SUFFIX;
	
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		gameid mediumint(9) NOT NULL,
		player tinytext NOT NULL,
		state mediumint(2) NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	dbDelta( $sql );
}

function btv_team_install() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	create_btv_team_table();
	create_btv_game_table();
	create_btv_player_table();
}

register_activation_hook( __FILE__, 'btv_team_install' );
?>