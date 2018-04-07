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
					
	        $teamPortraitLink = get_option('vr_tennisteam_link') . $team;
	
			global $vr_templatepath;
			ob_start();
			include($vr_templatepath . basename(__FILE__));
			return ob_get_clean();
		}
    }

    VR_TennisLink::init();
}
?>