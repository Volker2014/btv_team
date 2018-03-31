<?php
if (!class_exists('VR_TennisInstall')) {
    class VR_TennisInstall
    {
        public static function init()
        {
            register_activation_hook( __FILE__, array('VR_TennisInstall', 'install'));
        }

        private function create_team_table()
        {
	        global $wpdb;

	        $charset_collate = $wpdb->get_charset_collate();
	        $table_name = $wpdb->prefix . VR_TENNIS_TEAM_SUFFIX;
	
	        $sql = "CREATE TABLE $table_name (
		        id mediumint(9) NOT NULL AUTO_INCREMENT,
		        liga varchar(100) NOT NULL,
		        team tinytext NOT NULL,
		        PRIMARY KEY  (id),
		        UNIQUE KEY (liga)
	        ) $charset_collate;";

	        dbDelta( $sql );
        }

        private function create_game_table()
        {
	        global $wpdb;

	        $charset_collate = $wpdb->get_charset_collate();
	        $table_name = $wpdb->prefix . VR_TENNIS_GAME_SUFFIX;
	
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

        private function create_player_table()
        {
	        global $wpdb;
	
	        $charset_collate = $wpdb->get_charset_collate();
	        $table_name = $wpdb->prefix . VR_TENNIS_PLAYER_SUFFIX;
	
	        $sql = "CREATE TABLE $table_name (
		        id mediumint(9) NOT NULL AUTO_INCREMENT,
		        ligaid mediumint(9) NOT NULL,
		        gameid mediumint(9) NOT NULL,
		        playerid mediumint(9) NOT NULL,
		        state tinytext NOT NULL,
		        PRIMARY KEY (id)
	        ) $charset_collate;";

	        dbDelta( $sql );
        }

        private function install() {
	        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	        create_team_table();
	        create_game_table();
	        create_player_table();
        }
    }
    VR_TennisInstall::init();
}
?>