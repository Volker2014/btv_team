<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$options = array('vr_tennisteam_link', 'vr_tennisclub_link', 'vr_tennisballmodus_link');
foreach ($options as $option) {}
    delete_option($option);
}

 // drop a custom database table
global $wpdb;
$tables = array(BTV_TEAM_SUFFIX, BTV_GAME_SUFFIX, BTV_PLAYER_SUFFIX);
foreach ($tables as $table) {
	$table_name = $wpdb->prefix . $table;
    $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
}
?>