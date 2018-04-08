<?php
if (!class_exists('VR_TennisGames')) {
    class VR_TennisGames
    {
        public function __construct()
        {}
        
        private function get_id($table, $where) {
	        global $wpdb;

	        $sql = "SELECT id FROM $table WHERE $where";
	        return $wpdb->get_var($sql);
        }
        
        public function create($team) {
	        global $wpdb;
	
            if (!function_exists('file_get_html')) {
	            include_once('simple_html_dom.php');
            }

	        $team_table = $wpdb->prefix . VR_TENNIS_TEAM_SUFFIX;
	        $game_table = $wpdb->prefix . VR_TENNIS_GAME_SUFFIX;

	        $content = file_get_contents(get_option('vr_tennisteam_link') . $team . '&embedded=true');
	        $html = str_get_html($content);
	        $table = $html->find('table', 0);
	        if ($table != null)
	        {
		        $row = $table->getElementsByTagName('tr', 1);
		        $col = $row->getElementsByTagName('td', 0);
		        $mannschaft = array();
		        $mannschaft['liga'] = trim($col->plaintext);
		        $mannschaft['team'] = $team;
		
		        $mannschaft['id'] = $this->get_id($team_table, "liga='" . $mannschaft['liga'] . "'");
		        if (is_null($mannschaft['id'])) {
			        $wpdb->insert( 
				        $team_table,
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
					
					        $spiel['id'] = $this->get_id($game_table, 'home="' . $spiel['home'] .  '" and guest="' . $spiel['guest'] . '" and DATE_FORMAT(time, "%Y") = ' . $date['year']);
					        if (is_null($spiel['id'])) {
						        $wpdb->insert( 
							        $game_table,
							        $spiel
						        );					
						        $spiel['id'] = $wpdb->insert_id;
					        }
					        else {
						        $wpdb->update($game_table, array('time' => $spiel['time']), array('id' => $spiel['id']));
					        }
				        }				
			        }
		        }
	        }
        }
    }
}
?>