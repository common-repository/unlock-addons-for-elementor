<?php

/**
 * Plugin Name: Unlock Addons for Elementor
 * Description: Unlock Addons for Elementor plugin offer 10+ Free widgets includes widgets and addons like Blog Post Grid, Megamenu, Post Carousel, Countdown, Testimonials.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Author: WPRealizer
 * Author URI: https://wprealizer.com
 * Plugin URI: https://unlockaddons.com/unlock-addons-for-elementor/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: unlock-addons-for-elementor
 *
 * Elementor tested up to: 3.23.4
 * Elementor Pro tested up to: 3.23.3
 *
 *
 * Unlock Addons for Elementor Addons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Unlock Addons for Elementor Addons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Quantum Addons. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
 */


if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


/**
 * Define constance
 */

define( 'UNLOCKAFE_VERSION', '1.0.0' );
define( 'UNLOCKAFE_SLUG', 'unlock-addons-for-elementor' );
define( 'UNLOCKAFE_ADDONS_BASE', plugin_basename( __FILE__ ) );
define( 'UNLOCKAFE_ADDONS_URL', plugins_url( '/', __FILE__ ) );
define( 'UNLOCKAFE_ADDONS_DIR', dirname( __FILE__ ) );
define( 'UNLOCKAFE_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'UNLOCKAFE_ASSETS', UNLOCKAFE_ADDONS_URL . 'assets/' );
define( 'UNLOCKAFE_INCLUDE_PATH', UNLOCKAFE_ADDONS_DIR . '/includes/' );
define( 'UNLOCKAFE_TEMPLATE_PATH', UNLOCKAFE_ADDONS_DIR . '/includes/Widgets/templates/' );
define( 'UNLOCKAFE_WP_ASSETS_PATH', wp_upload_dir()['basedir'] . '/' . UNLOCKAFE_SLUG . '/' );
define( 'UNLOCKAFE_WP_ASSETS_URI', wp_upload_dir()['baseurl'] . '/' . UNLOCKAFE_SLUG . '/' );

/**
 * AutoLoad fiels
 */
require UNLOCKAFE_ADDONS_PATH . '/autoload.php';

/**
 * Main UNLOCKAFE Class
 *
 * The init class that runs the Unlock Addons plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * @since 1.0.0
 */
final class UNLOCKAFE_Final
{

	/**
	 *
	 * $instance property for instance
	 */
	private static $instance = null;

	/**
	 * Plugin prefix
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const PREFIX = 'unlockafe';


	
	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct()
	{

		// Init Plugin
		add_action('plugins_loaded', array($this, 'plugins_loaded'));
	}

	/**
	 *
	 * @return \Instance
	 * @since  1.0.0
	 */
	public static function getInstance()
	{
		if (! isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function plugins_loaded()
	{

		if (! did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'unlockafe_elementor_load_notice']);
			return;
		}

		// load textdomain
		load_plugin_textdomain( 'unlock-addons-for-elementor', false, basename( dirname( __FILE__ ) ) . '/languages' );

		// run
		\Unlockafe_addons\Classes\Unlockafe_addons::getInstance();
	}

	/**
	 * Check if elementor active and notice
	 * 
	 * @return void
	 */
	public function unlockafe_elementor_load_notice()
	{
		$plugin = 'elementor/elementor.php';
		if ($this->is_elementor_activated()) {
			if (! current_user_can('activate_plugins')) {
				return;
			}
			$activation_url = wp_nonce_url( 'plugins.php?action = activate&amp;plugin = ' . $plugin . '&amp;plugin_status = all&amp;paged = 1&amp;s', 'activate-plugin_' . $plugin );
			$admin_notice   = '<p>' . esc_html__( 'Elementor is missing. You need to activate your installed Elementor to use Unlock Addons for Elementor.', 'unlock-addons-for-elementor' ) . '</p>';
			$admin_notice .= '<p>' . sprintf( '<a href         = "%s" class          = "button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'unlock-addons-for-elementor' ) ) . '</p>';
		} else {
			if (! current_user_can('install_plugins')) {
				return;
			}
			$install_url  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$admin_notice = '<p>' . esc_html__( 'Elementor Required. You need to install & activate Elementor to use Unlock Addons for Elementor.', 'unlock-addons-for-elementor' ) . '</p>';
			$admin_notice .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'unlock-addons-for-elementor' ) ) . '</p>';
		}
		echo '<div class="notice notice-error is-dismissible">' . wp_kses($admin_notice, true) . '</div>';
	}

	/**
	 * Elementor activated or not
	 */
	public function is_elementor_activated()
	{
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset($installed_plugins[$file_path]);
	}
}

if (! function_exists('UNLOCKAFE_Init')) {
	function UNLOCKAFE_init()
	{
		return UNLOCKAFE_Final::getInstance();
	}
	UNLOCKAFE_Init();
}