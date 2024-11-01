<?php

namespace Unlockafe_addons\Classes;

use Unlockafe_addons\Classes\Widget_manager;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly.

class Assets_loader {

	public $registered_widgets = array();
	public $Widget_manager;
	public function __construct( $registered_widgets ) {

		// assign widgets
		$this->registered_widgets = $registered_widgets;

		// creating instance
		$this->Widget_manager     = new Widget_manager( $this->registered_widgets );

		// hook execution
		$this->run_hooks();
	}

	/**
	 *
	 * Load css/js for public users
	 *
	 * @since  1.0.0
	 */
	public function load_public_scripts() {

		// load dependency
		$this->Widget_manager->load_plugin_dependency();

		// generate css
		$this->Widget_manager->build_elementor_assets();

		// adding preview assets
		$this->Widget_manager->add_elementor_assets();

		// Enqueue WordPress's default styles first
		// wp_enqueue_style('wp-style', get_stylesheet_uri());

		// adding global/general css
		wp_enqueue_style( UNLOCKAFE_init()::PREFIX . '-public', UNLOCKAFE_ASSETS . 'front-end/css/general.css', [ 'elementor-frontend' ], UNLOCKAFE_VERSION );
	}


	/**
	 *
	 * Build Scripts for Admin
	 *
	 * @since  1.0.0
	 */
	public function unlockafe_load_admin_scripts( $admin_page ) {

		// menu pages 
		$unlockafe_menu = [ 
			'toplevel_page_unlock-addons',
			'unlock-addons_page_unlock-addons-elements',
			'unlock-addons_page_unlock-addons-integrations',
			'unlock-addons_page_unlock-addons-support',
			'unlock-addons_page_unlock-addons-go-premium'
		];

		if ( ! in_array( $admin_page, $unlockafe_menu ) ) {
			return;
		}

		$asset_file = UNLOCKAFE_ADDONS_PATH . 'assets/build/index.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_style( UNLOCKAFE_init()::PREFIX . '-admin', UNLOCKAFE_ASSETS . 'build/index.css', [], UNLOCKAFE_VERSION, 'all' );
		wp_enqueue_script( UNLOCKAFE_init()::PREFIX . '-admin', UNLOCKAFE_ASSETS . 'build/index.js', $asset['dependencies'], UNLOCKAFE_VERSION, true );

		wp_localize_script( UNLOCKAFE_init()::PREFIX . '-admin', 'unlockafe_data', [
			'_nonce' => wp_create_nonce('_unlockafe_nonce')
		]);
	}

	protected function run_hooks() {
		add_action( 'elementor/editor/after_save', [ $this->Widget_manager, 'unlockafe_elementor_after_save' ], 10, 2 );
		add_filter( 'elementor/files/file_name', [ $this->Widget_manager, 'singuler_file' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this->Widget_manager, 'unlockafe_editor_styles' ] );

	}

}