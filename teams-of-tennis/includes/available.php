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
?>
        <style>
        td {
	        font-size:60%;
        }
        </style>
        <table>
	        <thead>
		        <tr>
			        <td></td>
<?php
	        foreach ($games as $game)					
	        {
		        echo '<td>' . $game->home . ' - ' . $game->guest , '<br/>' . date('d.m.Y H:i', strtotime($game->time)) . '</td>';
	        }
?>
			        <td></td>
		        </tr>
	        </thead> 
	        <tbody>
<?php
	        foreach ($player_ids as $id)					
	        {
		        echo '<tr>';
		        $player = get_userdata($id->playerid);
		        echo '<td>' . $player->display_name . '</td>';
		        $player_games = array_values(array_filter($players, function($v, $k) use ($id) {
			        return $v['playerid'] == $id->playerid;
		        }, ARRAY_FILTER_USE_BOTH));

		        foreach ($games as $game)					
		        {
			        $key = array_search($game->id, array_column($player_games, 'gameid'));
			        $state = $player_games[$key]['state'];
			        if (!array_search($state, VR_TennisAvailable::PLAYER_STATES))
				        $state = VR_TennisAvailable::PLAYER_STATES[0];
			        $player_game_id = $player_games[$key]['id'];
?>
			        <td>
				        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
					        <input type="image" width="20px" height="20px" src="<?php echo $vr_stateimagepath . $state; ?>.png" 
						        alt="<?php echo $player->display_name . ': ' . $state ?>" title="<?php echo $player->display_name . ': ' . $state; ?>" />
					        <input type="hidden" value="<?php echo $state; ?>" name="state" />											
					        <input type="hidden" value="state_change_player" name="action">
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>">
					        <input type="hidden" value="<?php echo $player_game_id; ?>" name="player_game_id">
				        </form>
			        </td>
<?php
		        }
        ?>
			        <td>
				        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
					        <input type="hidden" value="delete_player" name="action">
					        <input type="hidden" value="<?php echo $id->playerid ?>" name="player_id">
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>">
					        <input type="image" width="20px" height="20px" src="<?php echo $vr_stateimagepath; ?>trash.png" 
						        title="Willst Du den Spieler <?php echo $player->display_name; ?> aus der Liste löschen?"/>
				        </form>
			        </td>
<?php			
		        echo '</tr>';
	        }
?>
		        <tr>
			        <td colspan="2">
				        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
					        <input type="text" name="player" title="Benutzername eingeben" value="<?php echo get_userdata(get_current_user_id())->user_login;?>" required>
					        <input type="hidden" name="action" value="add_player">
					        <input type="hidden" name="ligaid" value="<?php echo $ligaid; ?>">
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>">
					        <input type="submit" value="Hinzufügen">
				        </form>
			        </td>
		        </tr>
	        </tbody>
        </table>
<?php
	        return '';
        }
    }
    VR_TennisAvailable::init();
}
?>