<?php
if (!class_exists('VR_TennisLink')) {
    class VR_TennisLink
    {
        public static function init()
        {
            add_shortcode('vr_tennisteam', array('VR_TennisLink', 'link'));
        }

        public function link($atts) {
               extract(shortcode_atts(array(
 
                            'width' => '100%',
 
                            'height' => '500',
 
                            'team' => ''
 
                            ), $atts));
					
	        $creategames = new VR_TennisGames();
            $creategames->create($team);

	        $teamPortraitLink = get_option('vr_tennisteam_link') . $team;
	
	        return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" marginheight="0" marginwidth="0" src="'.$teamPortraitLink.'"></iframe>'; 
        }
    }

    VR_TennisLink::init();
}
?>