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
					<input type="submit" value="Hinzuf&uuml;gen" />
	    		</td>
    		</tr>
		</form>
	</tbody>
</table>
