<?php
/*
Plugin Name: Redirect From IP
Description: Magic Auto rating 3000
Version: 0.1
Author: Lataste Théo
License: GPL2
*/

function redirect_from_IP() {

    $ipToRedirect = explode(',', preg_replace('/\s+/', '', trim(preg_replace('/\s\s+/', ' ', get_option('ipToRedirect')))));
    $domainToRedirect = get_option('domainToRedirect');

    if(in_array($_SERVER['REMOTE_ADDR'], $ipToRedirect)){
        header("Location: ".$domainToRedirect.$_SERVER[REQUEST_URI], true, 302);
        exit;
    }

}

function myplugin_register_settings() {
    add_option( 'myplugin_option_name', 'This is my option value.');
    register_setting( 'myplugin_options_group', 'myplugin_option_name', 'myplugin_callback' );
}

function myplugin_register_options_page() {
    add_options_page('Page Title', 'Redirect from IP', 'manage_options', 'myplugin', 'myplugin_options_page');
}

function myplugin_options_page()
{
?>
  <div>
  <h2>Redirection d'IP</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'redirectFromIp' ); ?>
      <label for="ipToRedirect">IP pour lesquelles activer la redirection (séparéés par une virgule)</label>
      <textarea style="display:block;width:450px;" id="ipToRedirect" rows="10" name="ipToRedirect"><?php echo get_option('ipToRedirect'); ?></textarea>
      <label for="domainToRedirect">Domaine vers lequel rediriger : </label>
      <input style="width:260px;" type="text" id="domainToRedirect" name="domainToRedirect" value="<?php echo get_option('domainToRedirect'); ?>" />


  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}

function update_extra_post_info() {
    register_setting( 'redirectFromIp', 'ipToRedirect' );
    register_setting( 'redirectFromIp', 'domainToRedirect' );
}

add_action('admin_menu', 'myplugin_register_options_page');
add_action( 'admin_init', 'myplugin_register_settings' );
add_action('plugins_loaded', 'redirect_from_IP', 10, 3 );
add_action( 'admin_init', 'update_extra_post_info' );