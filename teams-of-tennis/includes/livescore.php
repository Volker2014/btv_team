<?php
if (!class_exists('VR_TennisLiveScore')) {
    class VR_TennisLiveScore
    {
        public static function init()
        {
            add_shortcode('vr_tennisscore', array('VR_TennisLiveScore', 'showscore'));
            add_action('admin_post_add_score', array('VR_TennisLiveScore', 'handle_add_score'));
            add_action('admin_post_change_score', array('VR_TennisLiveScore', 'handle_change_score'));
            add_action('admin_post_delete_score', array('VR_TennisLiveScore', 'handle_delete_score'));
        }

        static function create_empty_points()
        {
            return array('home_points' => array(0, 0,0 ), 'guest_points' => array(0,0,0));
        }

        function handle_add_score() {
	        global $wpdb;

		    $score_table = $wpdb->prefix . VR_TENNIS_SCORE_SUFFIX;
			$score = array('home' => $_POST['home'], 'guest' => $_POST['guest'], 'points' => serialize(VR_TennisLiveScore::create_empty_points()));
			$wpdb->insert($score_table, $score);

	        wp_safe_redirect($_POST['redirect']);
        }

        function handle_change_score() {
	        global $wpdb;

	        $score_table = $wpdb->prefix . VR_TENNIS_SCORE_SUFFIX;

	        $wpdb->update($score_table, array('points' => serialize(array('home_points' => $_POST['home_points'], 
                    'guest_points' => $_POST['guest_points']))),
                    array('id' => $_POST['score_id']));

	        wp_safe_redirect($_POST['redirect']);
        }

        function handle_delete_score() {
	        global $wpdb;

	        $score_table = $wpdb->prefix . VR_TENNIS_SCORE_SUFFIX;

	        $wpdb->delete($score_table, array('id' => $_POST['score_id']));
	
	        wp_safe_redirect($_POST['redirect']);
        }

        function showscore($atts) {
	        global $wpdb;
            global $wp;
            global $vr_stateimagepath;
	
	        if (!is_user_logged_in()) {
		        return '';
	        }
	        $score_table = $wpdb->prefix . VR_TENNIS_SCORE_SUFFIX;
		
	        $scores = $wpdb->get_results("SELECT * FROM $score_table");

			global $vr_templatepath;
			ob_start();
			include($vr_templatepath . basename(__FILE__));
			return ob_get_clean();
        }
    }
    VR_TennisLiveScore::init();
}
?>