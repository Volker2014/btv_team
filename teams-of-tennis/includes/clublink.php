<?php
if (!class_exists('VR_TennisClubLink')) {
    class VR_TennisClubLink
    {
        public static function init()
        {
            add_shortcode('vr_tennisclub', array('VR_TennisClubLink', 'link'));
        }

        function link($atts) {
               extract(shortcode_atts(array(
 
                            'width' => '100%',
 
                            'height' => '500',
 
                            'club' => ''
 
                            ), $atts));
					

	        $clubPortraitLink = get_option('vr_tennisclub_link') . $club;
	
	        return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" marginheight="0" marginwidth="0" src="'.$clubPortraitLink.'"></iframe>'; 
        }
    }
    VR_TennisClubLink::init();
}
?>