<?php
/**
 * Loads the plugin if dependencies are met.
 *
 * @package   Caldera_Forms_Api
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 David Cramer & CalderaWP LLC
 */


if ( file_exists( CF_API_PATH . 'vendor/autoload.php' ) ){
	//autoload dependencies
	require_once( CF_API_PATH . 'vendor/autoload.php' );

	// initialize plugin
	\calderawp\cf_api\core::get_instance();

}else{
	return new WP_Error( 'caldera-forms-api--no-dependencies', __( '{{Dependencies for Caldera Forms API could not be found.', 'caldera-forms-api' ) );
}


