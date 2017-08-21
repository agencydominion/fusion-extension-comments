<?php
/**
 * @package Fusion_Extension_Comments
 */
/**
 * Plugin Name: Fusion : Extension - Comments
 * Plugin URI: http://www.agencydominion.com/fusion/
 * Description: Comments Extension Package for Fusion.
 * Version: 1.1.3
 * Author: Agency Dominion
 * Author URI: http://agencydominion.com
 * Text Domain: fusion-extension-comments
 * Domain Path: /languages/
 * License: GPL2
 */
 
/**
 * FusionExtensionComments class.
 *
 * Class for initializing an instance of the Fusion Comments Extension.
 *
 * @since 1.0.0
 */


class FusionExtensionComments	{ 
	public function __construct() {
						
		// Initialize the language files
		add_action('plugins_loaded', array($this, 'load_textdomain'));
		
		// Plugin activation / deactivation hooks
		register_activation_hook( __FILE__, array($this, 'plugin_activated') );
		register_deactivation_hook( __FILE__, array($this, 'plugin_deactivated') );
	}
	
	/**
	 * Load Textdomain
	 *
	 * @since 1.1.3
	 *
	 */
	 
	public function load_textdomain() {
		load_plugin_textdomain( 'fusion-extension-comments', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	/**
	 * Function to run when plugin is activated.
	 *
	 * @since 1.0.0
	 *
	 */
	 
	public function plugin_activated(){
		//add htaccess rules to disable direct access to the wp-comments-post.php to reduce comment spam
		$site_parse_url = parse_url(site_url());
		$rules = array();
		$rules[] = 'RewriteEngine On';
		$rules[] = 'RewriteCond %{REQUEST_METHOD} POST';
		$rules[] = 'RewriteCond %{REQUEST_URI} .wp-comments-post\.php*';
		$rules[] = 'RewriteCond %{HTTP_REFERER} !.*'.$site_parse_url['host'].'.* [OR]';
		$rules[] = 'RewriteCond %{HTTP_USER_AGENT} ^$';
		$rules[] = 'RewriteRule (.*) http://%{REMOTE_ADDR}/$ [R=301,L]';
		$home_path = get_home_path();
		$htaccess_file = $home_path.'.htaccess';
		if (file_exists($htaccess_file) && is_writable($home_path) &&  is_writable($htaccess_file)) {
	        insert_with_markers( $htaccess_file, 'Fusion Comment Access', $rules );        
		}
    }


	/**
	 * Function to run when plugin is deactivated.
	 *
	 * @since 1.0.0
	 *
	 */
	 
    public function plugin_deactivated(){
	    //remove rules htaccess rules to disable direct access to the wp-comments-post.php to reduce comment spam
		$home_path = get_home_path();
		$htaccess_file = $home_path.'.htaccess';
		if (file_exists($htaccess_file) && is_writable($home_path) &&  is_writable($htaccess_file)) {
	    	insert_with_markers( $htaccess_file, 'Fusion Comment Access', '' ); 
		}
        
    }
}

$fsn_extension_comments = new FusionExtensionComments();

//EXTENSIONS

//comments
require_once('includes/extensions/comments.php');

?>