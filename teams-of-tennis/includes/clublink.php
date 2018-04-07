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
	
			global $vr_templatepath;
			ob_start();
			include($vr_templatepath . basename(__FILE__));
			return ob_get_clean();
        }
    }
    VR_TennisClubLink::init();
}
?>