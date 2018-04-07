<div>
    <?php screen_icon(); ?>
    <h2>Teams of Tennis Settings</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'vr_tennisteam_options_group' ); ?>
        <table>
            <tr valign="top">
                <th scope="row"><label for="vr_tennisteam_link">Team Link</label></th>
                <td><input type="text" name="vr_tennisteam_link" size="150" value="<?php echo get_option('vr_tennisteam_link'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="vr_tennisclub_link">Club Link</label></th>
                <td><input type="text" name="vr_tennisclub_link" size="150" value="<?php echo get_option('vr_tennisclub_link'); ?>" /></td>
            </tr>
<!-- coming soon            <tr valign="top">
                <th scope="row"><label for="vr_tennisballmodus_link">Ballmode Link</label></th>
                <td><input type="text" name="vr_tennisballmodus_link" size="150" value="<?php echo get_option('vr_tennisballmodus_link'); ?>" /></td>
            </tr>-->
        </table>
        <?php  submit_button(); ?>
    </form>
</div>
