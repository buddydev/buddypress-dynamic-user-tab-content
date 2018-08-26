<?php
/**
 * Plugin Name: BuddyPress Dynamic User Tab Content
 * Version: 1.0.1
 * Plugin URI: https://buddydev.com/create-dynamic-user-profile-tabs-for-buddypress/
 * Author: BuddyDev
 * Author URI: https://BuddyDev.com
 * Description: Create dynamic content for BuddyPress profile tabs created with BuddyPress User Profile Tabs Creator Pro plugin.
 *
 * License: GPL2 or above
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Dynamic User tab contents helper.
 */
class BP_Dynamic_User_Tab_Content {

	/**
	 * Singleton instance
	 *
	 * @var BP_Dynamic_User_Tab_Content
	 */
	private static $instance = null;

	/**
	 * Absolute path to this plugin directory.
	 *
	 * @var string
	 */
	private $path;

	/**
	 * Absolute url to this plugin directory.
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Plugin basename.
	 *
	 * @var string
	 */
	private $basename;

	/**
	 * Constructor
	 */
	private function __construct() {

		$this->path     = plugin_dir_path( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->basename = plugin_basename( __FILE__ );
		$this->load();
	}

	/**
	 * Get singleton instance
	 *
	 * @return BP_Dynamic_User_Tab_Content
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Load dependencies
	 */
	private function load() {
		$path = $this->get_path();
		require_once  $path . 'core/bp-dutc-functions.php';
		require_once  $path . 'core/bp-dutc-post-type-helper.php';
		require_once  $path . 'core/bp-dutc-shortcode.php';
		if ( is_admin() ) {
			require_once $path . 'core/bp-dutc-admin.php';
		}
	}

	/**
	 * Get the main plugin file.
	 *
	 * @return string
	 */
	public function get_file() {
		return __FILE__;
	}

	/**
	 * Get absolute url to this plugin dir.
	 *
	 * @return string
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * Get absolute path to this plugin dir.
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}


	/**
	 * Check if network active.
	 *
	 * @return bool
	 */
	public function is_network_active() {

		if ( ! is_multisite() ) {
			return false;
		}

		// Check the sitewide plugins array.
		$base    = $this->basename;
		$plugins = get_site_option( 'active_sitewide_plugins' );

		if ( ! is_array( $plugins ) || ! isset( $plugins[ $base ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Is the PHp version good enough for us?
	 * Checks if php version >= 5.4
	 *
	 * @return boolean
	 */
	public function has_php_version() {
		return version_compare( PHP_VERSION, '5.4', '>=' );
	}
}

/**
 * Helper method to access BP_Dynamic_Tab_Content instance
 *
 * @return BP_Dynamic_User_Tab_Content
 */
function bp_dynamic_tab_content() {
	return BP_Dynamic_User_Tab_Content::get_instance();
}

bp_dynamic_tab_content();

