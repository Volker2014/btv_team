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
?>
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
          <tr valign="top">
          <th scope="row"><label for="vr_tennisballmodus_link">Ballmodus Link</label></th>
          <td><input type="text" name="vr_tennisballmodus_link" size="150" value="<?php echo get_option('vr_tennisballmodus_link'); ?>" /></td>
          </tr>
          </table>
          <?php  submit_button(); ?>
          </form>
          </div>
<?php
        }
    }
    VR_TennisOptions::init();
}
?>