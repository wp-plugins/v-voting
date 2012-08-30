<?php
/*
Plugin Name: v voting
Plugin URI: http://www.shatter.fr/bp-portfolio/
Description: This plugin allows each user to create his portfolio on your website
Version: 1.0
Requires at least: WP 3.3.1, BuddyPress 1.5
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Nicolas Crocfer (shatter)
Author URI: http://www.shatter.fr
*/


/**
 * Useful constants definitions
 */
define( 'BP_voting_IS_INSTALLED',        1 );
define( 'BP_voting_VERSION',             '1.0' );
define( 'BP_voting_PLUGIN_DIR',          dirname( __FILE__ ) );
define( 'BP_voting_PLUGIN_URL',          plugins_url() . '/v');
define('EVENTSURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
$path = "/wp-content/plugins/v/templates/default/js";
//ajax added here


//new script to add java script
function voteme_enqueuescripts1()
	{

 
	wp_enqueue_script('voteme1', EVENTSURL.'/templates/default/js/admin.js', array('jquery'));

		wp_localize_script( 'voteme1', 'votemeajax1', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}
add_action('wp_enqueue_scripts', voteme_enqueuescripts1);
//votin ajax
define('VOTEMESURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('VOTEMEPATH', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );
function voteme_enqueuescripts()
{
	wp_enqueue_script('voteme', VOTEMESURL.'/templates/default/js/vote.js', array('jquery'));
	wp_localize_script( 'voteme', 'votemeajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', voteme_enqueuescripts);
//jquery
add_action( 'init', 'wpapi_date_picker' );
function wpapi_date_picker() {
wp_register_script('jquery','/wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js');
	wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-datepicker','/wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core' ) );
wp_enqueue_script('jquery');
//wp_enqueue_script( 'jquery' );
//	wp_enqueue_script( 'jquery-datepicker', EVENTSURL.'/templates/default/js/jquery-ui-1.8.12.custom.min.js', array('jquery', 'jquery-ui-core' ) );
//	wp_enqueue_style('jquery.ui.theme',  BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/css/jquery-ui-1.8.12.custom.css');
//new added
//wp_enqueue_style('jquery.ui.theme', '/wp-includes/css/jquery-ui-dialog.css');
//wp_enqueue_style('jquery.ui.theme', '/wp-includes/css/jquery-ui-dialog.dev.css');
//wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.3.2', true);

		// or load the Google API copy in the footer
		//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2', true);
}

//new1

/* Only load the portfolio component if BuddyPress is loaded and initialized. */
function bp_voting_init() {
	if ( version_compare( BP_VERSION, '1.3', '>' ) )
		require( dirname( __FILE__ ) . '/includes/bp-voting-loader.php' );
}
add_action( 'bp_include', 'bp_voting_init' );


/* Install the tables on activation */
function bp_voting_activate() {
    require( dirname( __FILE__ ) . '/includes/bp-voting-install.php' );
    bp_voting_default_options();
}
register_activation_hook( __FILE__, 'bp_voting_activate' );


?>
