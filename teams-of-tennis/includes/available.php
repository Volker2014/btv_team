<?php
if (!class_exists('VR_TennisAvailable')) {
    class VR_TennisAvailable
    {
        public static function init()
        {
            add_shortcode('vr_tennisavailable', array('VR_TennisAvailable', 'available'));
            add_action('admin_post_add_player', array('VR_TennisAvailable', 'handle_add_player_available'));
            add_action('admin_post_state_change_player', array('VR_TennisAvailable', 'handle_state_change_player_available'));
            add_action('admin_post_delete_player', array('VR_TennisAvailable', 'handle_delete_player_available'));
        }
        const PLAYER_STATES = array('unknown', 'yes', 'no', 'ifneeded');

        private function get_id($table, $where) {
	        global $wpdb;

	        $sql = "SELECT id FROM $table WHERE $where";
	        return $wpdb->get_var($sql);
        }

        function handle_add_player_available() {
	        global $wpdb;

	        $user_id = get_userdatabylogin($_POST['player'])->ID;
	        if ($user_id) {	
		        $game_table = $wpdb->prefix . VR_TENNIS_GAME_SUFFIX;
		        $player_table = $wpdb->prefix . VR_TENNIS_PLAYER_SUFFIX;
		        $ligaid = $_POST['ligaid'];
		        $games = $wpdb->get_results("SELECT * FROM $game_table WHERE ligaid=" . $ligaid);

		        foreach ($games as $game) {
			        $player = array('ligaid' => $ligaid, 'gameid' => $game->id, 'playerid' => $user_id, 'state' => 'unknown');
			        $wpdb->insert($player_table, $player);
		        }
	        }

	        wp_safe_redirect($_POST['redirect']);
        }

        function handle_state_change_player_available() {
	        global $wpdb;

	        $key = array_search($_POST['state'], VR_TennisAvailable::PLAYER_STATES);
	        $key = $key + 1;
	        if ($key == count(VR_TennisAvailable::PLAYER_STATES))
		        $key = 0;
	        $player_table = $wpdb->prefix . VR_TENNIS_PLAYER_SUFFIX;

	        $wpdb->update($player_table, array('state' => VR_TennisAvailable::PLAYER_STATES[$key]), array('id' => $_POST['player_game_id']));

	        wp_safe_redirect($_POST['redirect']);
        }

        function handle_delete_player_available() {
	        global $wpdb;

	        $player_table = $wpdb->prefix . VR_TENNIS_PLAYER_SUFFIX;

	        $wpdb->delete($player_table, array('playerid' => $_POST['player_id']));
	
	        wp_safe_redirect($_POST['redirect']);
        }

        function available($atts) {
	        global $wpdb;
	        global $wp;
            global $vr_stateimagepath;
	
	        if (!is_user_logged_in()) {
		        return '';
	        }
	        $team_table = $wpdb->prefix . VR_TENNIS_TEAM_SUFFIX;
	        $game_table = $wpdb->prefix . VR_TENNIS_GAME_SUFFIX;
	        $player_table = $wpdb->prefix . VR_TENNIS_PLAYER_SUFFIX;

	        extract(shortcode_atts(array(
 
                            'width' => '100%',
 
                            'height' => '500',
 
                            'team' => ''
 
                            ), $atts));
		
	        $ligaid = VR_TennisAvailable::get_id($team_table, 'team="' . $team . '"');
	        $games = $wpdb->get_results("SELECT * FROM $game_table WHERE ligaid=" . $ligaid);
	        $player_ids = $wpdb->get_results("SELECT DISTINCT playerid FROM $player_table WHERE ligaid=" . $ligaid);
	        $players = $wpdb->get_results("SELECT * FROM $player_table WHERE ligaid=" . $ligaid, ARRAY_A);
	        if (!$player_ids)
	        {
		        $player_ids = array();
	        }
			
			global $vr_templatepath;
			ob_start();
			include($vr_templatepath . basename(__FILE__));
			return ob_get_clean();
        }
    }
    VR_TennisAvailable::init();
}
?>