<?php
/**
 * @package   Caldera_Forms_Api
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 David Cramer & CalderaWP LLC
 *
 * @wordpress-plugin
 * Plugin Name: Caldera Forms API
 * Plugin URI:  http://CalderaWP.com
 * Description: API Endpoints for Caldera Forms
 * Version:     1.0.0
 * Author:      David Cramer
 * Author URI:  https://CalderaWP.com
 * Text Domain: caldera-forms-api
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('CF_API_PATH',  plugin_dir_path( __FILE__ ) );
define('CF_API_CORE',  __FILE__ );
define('CF_API_URL',  plugin_dir_url( __FILE__ ) );
define('CF_API_VER',  '1.0.0' );



// Load instance
add_action( 'plugins_loaded', 'cf_api_bootstrap' );
function cf_api_bootstrap(){
	global $wp_version;

	if ( is_admin() || defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		include_once CF_API_PATH . 'vendor/calderawp/dismissible-notice/src/functions.php';
	}

	if ( ! version_compare( $wp_version, '4.4', '>=' ) ) {
		if ( is_admin() ) {
			
			//BIG BIG nope nope nope!
			$message = __( sprintf( 'Caldera Forms API requires WordPress version %1s or later. We strongly recommend version 4.4 or later for security and performance reasons. Current version is %2s.', '4.5', $wp_version ), 'caldera-forms-api' );
			echo caldera_warnings_dismissible_notice( $message, true, 'activate_plugins' );
		}

	}elseif ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		if ( is_admin() ) {
			
			//BIG nope nope nope!
			$message = __( sprintf( 'Caldera Forms API requires PHP version %1s or later. We strongly recommend PHP 5.5 or later for security and performance reasons. Current version is %2s.', '5.3.0', PHP_VERSION ), 'caldera-forms-api' );
			echo caldera_warnings_dismissible_notice( $message, true, 'activate_plugins' );
		}

	}else{
		//bootstrap plugin
		require_once( CF_API_PATH . 'bootstrap.php' );

	}

}
