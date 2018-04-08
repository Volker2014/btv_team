<?php
if (!class_exists('VR_TennisOptions')) {
    class VR_TennisOptions
    {
        public static function init()
        {
            add_action('admin_init', array('VR_TennisOptions', 'register_settings' ));
            add_action('admin_menu', array('VR_TennisOptions', 'register_options_page'));
        }

        public function action_links($links) {
           $links[] = '<a href="' . esc_url( get_admin_url(null, 'options-general.php?page=Teams-of-Tennis') ) . '">Settings</a>';
           return $links;
        }

        public function register_settings() {
           add_option( 'vr_tennisteam_link', 'http://btv.liga.nu/cgi-bin/WebObjects/TennisLeagueBTVToServe.woa/1/wa/b2sTeamPortrait?theLeaguePage=b2sTeamPortrait&team=');
           add_option( 'vr_tennisclub_link', 'http://btv.liga.nu/cgi-bin/WebObjects/TennisLeagueBTVToServe.woa/wa/b2sClubMeetings?federation=BTV&amp;club=');
           add_option( 'vr_tennisballmodus_link', 'http://www.btv.de/BTVToServe/abaxx-?$part=btv.common.getBinary&amp;docPath=/BTV-Portal/theLeague/Downloads/2017/Ballmodus%20Sommer%202018_alt&amp;docId=83465023');
           register_setting( 'vr_tennisteam_options_group', 'vr_tennisteam_link');
        }

        public function register_options_page() {
          add_options_page('Page Title', 'Teams of Tennis', 'manage_options', 'Teams-of-Tennis', array('VR_TennisOptions', 'options_page'));
        }

        public function options_page()
        {
			global $vr_templatepath;
			ob_start();
			include($vr_templatepath . basename(__FILE__));
			echo ob_get_clean();
        }
    }

    VR_TennisOptions::init();
}
?>