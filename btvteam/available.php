<?php

const PLAYER_STATES = array('unknown', 'yes', 'no', 'ifneeded');

function handle_add_player_available() {
	global $wpdb;

	$user_id = get_userdatabylogin($_POST['player'])->ID;
	if ($user_id) {	
		$btv_game_table = $wpdb->prefix . BTV_GAME_SUFFIX;
		$btv_player_table = $wpdb->prefix . BTV_PLAYER_SUFFIX;
		$ligaid = $_POST['ligaid'];
		$games = $wpdb->get_results("SELECT * FROM $btv_game_table WHERE ligaid=" . $ligaid);

		foreach ($games as $game) {
			$player = array('ligaid' => $ligaid, 'gameid' => $game->id, 'playerid' => $user_id, 'state' => 'unknown');
			$wpdb->insert($btv_player_table, $player);
		}
	}

	wp_safe_redirect($_POST['redirect']);
}

function handle_state_change_player_available() {
	global $wpdb;

	print_r(§_POST);
	$key = array_search($_POST['state'], PLAYER_STATES);
	$key = $key + 1;
	if ($key == count(PLAYER_STATES))
		$key = 0;
	$btv_player_table = $wpdb->prefix . BTV_PLAYER_SUFFIX;

	$wpdb->update($btv_player_table, array('state' => PLAYER_STATES[$key]), array('id' => $_POST['player_game_id']));

	wp_safe_redirect($_POST['redirect']);
}

function handle_delete_player_available() {
	global $wpdb;

	print_r($_POST);
	$btv_player_table = $wpdb->prefix . BTV_PLAYER_SUFFIX;

	$wpdb->delete($btv_player_table, array('playerid' => $_POST['player_id']));
	
	wp_safe_redirect($_POST['redirect']);
}

add_action( 'admin_post_add_player', 'handle_add_player_available');
add_action( 'admin_post_state_change_player', 'handle_state_change_player_available');
add_action( 'admin_post_delete_player', 'handle_delete_player_available');

function BtvAvailable($atts) {
	global $wpdb;
	global $wp;
	
	if (!is_user_logged_in()) {
		return '';
	}
	$btv_team_table = $wpdb->prefix . BTV_TEAM_SUFFIX;
	$btv_game_table = $wpdb->prefix . BTV_GAME_SUFFIX;
	$btv_player_table = $wpdb->prefix . BTV_PLAYER_SUFFIX;

	extract(shortcode_atts(array(
 
                    "width" => '100%',
 
                    "height" => '500',
 
                    "team" => ''
 
                    ), $atts));
		
	$stateimagepath = plugins_url('stateimages/', __FILE__);
	$ligaid = get_id($btv_team_table, "team='" . $team . "'");
	$games = $wpdb->get_results("SELECT * FROM $btv_game_table WHERE ligaid=" . $ligaid);
	$player_ids = $wpdb->get_results("SELECT DISTINCT playerid FROM $btv_player_table WHERE ligaid=" . $ligaid);
	$players = $wpdb->get_results("SELECT * FROM $btv_player_table WHERE ligaid=" . $ligaid, ARRAY_A);
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
		$player_games = array_filter($players, function($v, $k) use ($id) {
			return $v['playerid'] == $id->playerid;
		}, ARRAY_FILTER_USE_BOTH);

		foreach ($games as $game)					
		{
			$key = array_search($game->id, array_column($player_games, 'gameid'));
			$state = $player_games[$key]['state'];
			if (!array_search($state, PLAYER_STATES))
				$state = PLAYER_STATES[0];
			$player_game_id = $player_games[$key]['id'];
?>
			<td>
				<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
					<input type="image" width="20px" height="20px" src="<?php echo $stateimagepath . $state; ?>.png" 
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
				<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" onsubmit="return confirm(\"test\");">
					<input type="hidden" value="delete_player" name="action">
					<input type="hidden" value="<?php echo $id->playerid ?>" name="player_id">
					<input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>">
					<input type="image" width="20px" height="20px" src="<?php echo $stateimagepath; ?>trash.png" 
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

add_shortcode("btvavailable", "BtvAvailable");

?>