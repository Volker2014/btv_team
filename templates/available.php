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
