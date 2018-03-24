<?php
function btv_team_link($atts) {
       extract(shortcode_atts(array(
 
                    "width" => '100%',
 
                    "height" => '500',
 
                    "team" => ''
 
                    ), $atts));
					
	create_btv_games($team);

	$teamPortraitLink = get_option('btvteam_link') . $team;
	
	return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" marginheight="0" marginwidth="0" src="'.$teamPortraitLink.'"></iframe>'; 
}

add_shortcode("btvteam", "btv_team_link");
;
?>