<?php
function btvteam_register_settings() {
   add_option( 'btvteam_link', 'http://btv.liga.nu/cgi-bin/WebObjects/TennisLeagueBTVToServe.woa/1/wa/b2sTeamPortrait?theLeaguePage=b2sTeamPortrait&team=');
   register_setting( 'btvteam_options_group', 'btvteam_link');
}
add_action( 'admin_init', 'btvteam_register_settings' );

function btvteam_register_options_page() {
  add_options_page('Page Title', 'BTV Team', 'manage_options', 'BTVTeam', 'btvteam_options_page');
}
add_action('admin_menu', 'btvteam_register_options_page');

function btvteam_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>BTV Team Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'btvteam_options_group' ); ?>
  <table>
  <tr valign="top">
  <th scope="row"><label for="btvteam_link">Link</label></th>
  <td><input type="text" name="btvteam_link" size="150" value="<?php echo get_option('btvteam_link'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}
?>