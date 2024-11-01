<?php

namespace Unlockafe_addons\Admin;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly.

class Admin {

	/**
	 *
	 * $instance property for instance
	 */
	private static $instance = null;
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
		add_filter( 'plugin_action_links_' . UNLOCKAFE_ADDONS_BASE, [ $this, 'unlockafe_action_links' ] );

	}

	/**
	 *
	 * @return \Instance
	 * @since  1.0.0
	 */
	public static function getInstance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		// admin page
		add_action( 'admin_menu', [ $this, 'menu' ] );
	}

	/**
	 * Admin menu options
	 * 
	 * @return void
	 */
	public function menu() {
		add_menu_page(
			esc_html__( 'Unlock Addons', 'unlock-addons-for-elementor' ),
			esc_html__( 'Unlock Addons', 'unlock-addons-for-elementor' ),
			'manage_options',
			'unlock-addons',
			[ $this, 'dashboard' ],
			UNLOCKAFE_ASSETS . 'images/unlockafe-addon-icon.svg',
			'58.1'
		);

		// All elements menager page
		add_submenu_page(
			'unlock-addons',
			__( 'Elements', 'unlock-addons-for-elementor' ),
			__( 'Elements', 'unlock-addons-for-elementor' ),
			'manage_options',
			'unlock-addons-elements',
			[ $this, 'dashboard' ],
		);

		// all pluigns list from wpreqlizer
		add_submenu_page(
			'unlock-addons',
			__( 'Integrations', 'unlock-addons-for-elementor' ),
			__( 'Integrations', 'unlock-addons-for-elementor' ),
			'manage_options',
			'unlock-addons-integrations',
			[ $this, 'dashboard' ],
		);

		// Support page
		add_submenu_page(
			'unlock-addons',
			__( 'Support', 'unlock-addons-for-elementor' ),
			__( 'Support', 'unlock-addons-for-elementor' ),
			'manage_options',
			'unlock-addons-support',
			[ $this, 'dashboard' ],
		);

		// Promotions page
		add_submenu_page(
			'unlock-addons',
			__( 'Go premium', 'unlock-addons-for-elementor' ),
			__( 'Go premium', 'unlock-addons-for-elementor' ),
			'manage_options',
			'unlock-addons-go-premium',
			[ $this, 'dashboard' ],
		);
	}

	/**
	 * Admin Dashboard View
	 * @return void
	 */
	public function dashboard() {
		// dashboard output
		include_once UNLOCKAFE_INCLUDE_PATH . 'Admin/views/main.dashboard.php';
	}

	function unlockafe_action_links( $actions ) {
		$links   = array(
			'<a href="' . admin_url( 'admin.php?page=unlock-addons' ) . '">' . __( 'Settings', 'unlock-addons-for-elementor' ) . '</a>',
			'<a href="' . admin_url( 'admin.php?page=unlock-addons-go-premium' ) . '" style="color:#c60055; font-weight: bold;">' . __( 'Get Premium', 'unlock-addons-for-elementor' ) . '</a>',
		);
		$actions = array_merge( $actions, $links );
		return $actions;
	}
}