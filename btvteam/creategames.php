<?php
function get_id($table, $where) {
	global $wpdb;

	$sql = "SELECT id FROM $table WHERE $where";
	return $wpdb->get_var($sql);
}

function create_btv_games($team) {
	global $wpdb;
	global $BTV_TEAM_SUFFIX;
	global $BTV_GAME_SUFFIX;
	
	$btv_team_table = $wpdb->prefix . BTV_TEAM_SUFFIX;
	$btv_game_table = $wpdb->prefix . BTV_GAME_SUFFIX;

	$content = file_get_contents(get_option('btvteam_link') . $team . "&embedded=true");
	$html = str_get_html($content);
	$table = $html->find('table', 0);
	if ($table != null)
	{
		$row = $table->getElementsByTagName('tr', 1);
		$col = $row->getElementsByTagName('td', 0);
		$mannschaft = array();
		$mannschaft['liga'] = trim($col->plaintext);
		$mannschaft['team'] = $team;
		
		$mannschaft['id'] = get_id($btv_team_table, "liga='" . $mannschaft['liga'] . "'");
		if (is_null($mannschaft['id'])) {
			$wpdb->insert( 
				$btv_team_table,
				$mannschaft
			);
			$mannschaft['id'] = $wpdb->insert_id;
		}
	
		$table = $html->find('table', 1);
		if ($table != null)
		{
			$spiele = array(); 
			$rows = $table->getElementsByTagName('tr');
			foreach ($rows as $row) {
				$cols = $row->getElementsByTagName('td');
				$count = count($cols);
				if ($count == 5 || $count == 6) 	
				{
					$idx = 0;
					$spiel = array();
					$date = date_parse(trim($cols[$idx++]->plaintext));
					$timestamp = mktime($date['hour'], $date['minute'], 0, $date['month'], $date['day'], $date['year']);
					$spiel['time'] = date('Y-m-d H:i:s', $timestamp);
					if ($count == 6)
						$idx++;
					$spiel['home'] = trim($cols[$idx++]->plaintext);
					$spiel['guest'] = trim($cols[$idx++]->plaintext);
					$spiel['ligaid'] = $mannschaft['id'];
					$spiele[] = $spiel;
					
					$spiel['id'] = get_id($btv_game_table, 'home="' . $spiel['home'] .  '" and guest="' . $spiel['guest'] . '" and DATE_FORMAT(time, "%Y") = ' . $date['year']);
					if (is_null($spiel['id'])) {
						$wpdb->insert( 
							$btv_game_table,
							$spiel
						);					
						$spiel['id'] = $wpdb->insert_id;
					}
					else {
						$wpdb->update($btv_game_table, array('time' => $spiel['time']), array('id' => $spiel['id']));
					}
				}				
			}
		}
	}
}
?>