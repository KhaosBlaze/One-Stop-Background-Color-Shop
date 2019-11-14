<?php
/**
 * @package One_Stop_Background_Color_Shop
 * @version 0.0.2
 */
/*
Plugin Name: One Stop Background Color Shop
Plugin URI: TBD
Description: This plugin allows for a one click modification of your site's background color.
Author: Charles Sherburne
Version: 0.0.2
Author URI: TBD
*/

//Register the color option that can be modifiedl ater
function osbcs_register_settings() {
   add_option( 'osbcs_color', '#'.get_background_color()); // Set current background color as default
   register_setting( 'osbcs_group', 'osbcs_color');
}

add_action( 'admin_init', 'osbcs_register_settings' );

//Setup options page to be able to change color
function osbcs_options_page() {
    add_options_page(
	'One Stop Background Color Shop!', 
	'One Stop Background Color Shop', 
	'manage_options', 
	'one-stop-bg-color-shop', 
	'osbcs_option_page_html'
    );
}

add_action('admin_menu', 'osbcs_options_page');

//Setup css code to change background color to chosen color
function osbcs_custom_css(){
  $color = get_option('osbcs_color'); //Fetch colori
  require 'css/osbcs.php'; //Fetch css
}

add_action( 'wp_enqueue_scripts', 'osbcs_custom_css', 999); //Load CSS after theme

function osbcs_option_page_html()
{
 //Kick the user back if they don't have the correct permissions
 if ( ! current_user_can( 'manage_options' ) ) {return; }?>
 <!---Create html form to submit color--->
 <div class="wrap">
   <h1><?php echo esc_html( get_admin_page_title() );?></h1>
   <form action="options.php" method="post">
     <?php settings_fields( 'osbcs_group' ); ?>
     <h3>Pick your color!</h3><br>
     What color wheel you pick.<br>
     <input type="color" name="osbcs_color" value="<?php echo get_option('osbcs_color');//fetch color ?>"></input>
      <?php  submit_button('Save Color'); ?> <!--- Save that color --->
   </form>
 </div>
<?php
}

?>
