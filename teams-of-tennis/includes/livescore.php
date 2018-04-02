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
?>
        <style>
        td {
	        font-size:60%;
        }
        </style>
        <table>
	        <tbody>
<?php
	        foreach ($scores as $score)					
	        {
                $points = unserialize($score->points);
                if (!$points)
                {
                    $points = VR_TennisLiveScore::create_empty_points();
                }
?>
		        <tr>
				    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
    			        <td>
					        <input type="text" value="<?php echo $score->home; ?>" name="home" />
    			        </td>
    			        <td style="width: 50px;">
<?php
                foreach ($points['home_points'] as $i => $value) {
?>
					        <input type="number" value="<?php echo $value; ?>" name="home_points[<?php echo $i; ?>]" min="0" />
<?php
                }
?>
    			        </td>
    			        <td style="width: 50px;">
<?php
                foreach ($points['guest_points'] as $i => $value) {
?>
					        <input type="number" value="<?php echo $value; ?>" name="guest_points[<?php echo $i; ?>]" min="0" />
<?php
                }
?>
    			        </td>
    			        <td>
					        <input type="text" value="<?php echo $score->guest ?>" name="guest" />
    			        </td>
    			        <td>
					        <input type="hidden" value="change_score" name="action" />
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>" />
					        <input type="hidden" value="<?php echo $score->id; ?>" name="score_id" />
					        <input type="submit" value="Setze" />
    			        </td>
				    </form>
			        <td>
				        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
					        <input type="hidden" value="delete_score" name="action" />
					        <input type="hidden" value="<?php echo $score->id ?>" name="score_id" />
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>" />
					        <input type="image" width="20px" height="20px" src="<?php echo $vr_stateimagepath; ?>trash.png" 
						        title="Willst Du das Spiel <?php echo $score->home . ' - ' . $score->guest; ?> aus der Liste löschen?"/>
				        </form>
			        </td>
		        </tr>
<?php			
	        }
?>
				<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
    		        <tr>
    			        <td>
					        <input type="text" value="" name="home" />
    			        </td>
    			        <td colspan="2">
    			        </td>
    			        <td>
					        <input type="text" value="" name="guest" />
    			        </td>
    		        </tr>
	    	        <tr>
    			        <td>
					        <input type="hidden" name="action" value="add_score" />
					        <input type="hidden" name="redirect" value="<?php echo home_url( $wp->request ); ?>" />
					        <input type="submit" value="Hinzufügen" />
	    		        </td>
    		        </tr>
				</form>
	        </tbody>
        </table>
<?php
	        return '';
        }
    }
    VR_TennisLiveScore::init();
}
?>