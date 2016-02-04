<?php
/**
 * CF_API Unit Tests Bootstrap
 *
 * @since 1.3.2
 */
class CF_API_Unit_Tests_Bootstrap {

	/** @var \CF_API_Unit_Tests_Bootstrap instance */
	protected static $instance = null;

	/** @var string directory where wordpress-tests-lib	is installed */
	public $wp_tests_dir;

	/** @var string testing directory */
	public $tests_dir;

	/** @var string plugin directory */
	public $plugin_dir;

	/**
	 * Setup the unit testing environment
	 *
	 * @since 1.3.2
	 */
	public function __construct() {

		ini_set( 'display_errors', 'on' );
		error_reporting( E_ALL );
		
		$this->tests_dir 	= dirname( __FILE__ );
		$this->plugin_dir	= dirname( $this->tests_dir );
		$this->wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib';

		// load test function so tests_add_filter() is available
		require_once( $this->wp_tests_dir . '/includes/functions.php' );

		// load CF_API
		tests_add_filter( 'muplugins_loaded', array( $this, 'load_cf_api' ) );

		// load the WP testing environment
		require_once( $this->wp_tests_dir . '/includes/bootstrap.php' );

		// load CF_API testing framework
		$this->includes();
	}

	/**
	 * Load CF_API
	 *
	 * @since 1.3.2
	 */
	public function load_cf_api() {
		require_once( $this->plugin_dir . '/caldera-forms-api.php' );
	}


	/**
	 * Load CF_API-specific test cases
	 *
	 * @since 1.3.2
	 */
	public function includes() {

		// test cases
		require_once( $this->tests_dir . '/framework/class-cf-api-unit-test-case.php' );

		//Helpers
		require_once( $this->tests_dir . '/framework/helpers/class-helper.php' );
	}

	/**
	 * Get the single class instance.
	 *
	 * @since 2.2
	 * @return CF_API_Unit_Tests_Bootstrap
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

CF_API_Unit_Tests_Bootstrap::instance();