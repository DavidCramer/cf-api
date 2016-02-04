<?php
/**
 * Caldera Forms API.
 *
 * @package   Caldera_Forms_Api
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 David Cramer
 */
namespace calderawp\cf_api;

/**
 * Main plugin class.
 *
 * @package Caldera_Forms_Api
 * @author  David Cramer
 */
class core {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'caldera-forms-api';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|\calderawp\cf_api\core
	 */
	protected static $instance = null;

	/**
	 * Holds the option screen prefix
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// initialize routes
		add_action( 'rest_api_init', array( $this, 'init_routes' ) );

	}


	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object|\calderawp\cf_api\core    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( $this->plugin_slug, false, basename( CF_API_PATH ) . '/languages');

	}

	/**
	 * init the routs loader
	 *
	 * @since 1.0.0
	 */
	public function init_routes() {

		new routes();

	}

}