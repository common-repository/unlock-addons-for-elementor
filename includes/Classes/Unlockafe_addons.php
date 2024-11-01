<?php

/**
 * Unlockafe Addons 
 *
 * @package Unlockafe_addons
 */

namespace Unlockafe_addons\Classes;

use Unlockafe_addons\Admin\Admin;
use Unlockafe_addons\Classes\Assets_loader;
use Unlockafe_addons\API\Widgets_API;
use Unlockafe_addons\Traits\Utils;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly.

class Unlockafe_addons {
	use Utils;
	/**
	 *
	 * $instance property for instance
	 */
	private static $instance = null;

	/**
	 *
	 * Registerd widgets in cofig
	 */
	protected $registered_widgets;

	/**
	 *
	 * Storing/create all the instance
	 */
	public $get_instance = [];


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
	/**
	 * Constructor of plugin class
	 *
	 * @since 3.0.0
	 */
	private function __construct() {

		//admin page
		Admin::getInstance();
		$widgets                  = require_once UNLOCKAFE_INCLUDE_PATH . 'Widgets/init.php';
		$this->registered_widgets = apply_filters( 'unlockafe_addons/widgets', $widgets );
		$this->unlockafe_load_instance();
		$this->register_hooks();
	}

	/**
	 *
	 * Registering Hooks for UNLOCKAFE
	 *
	 * @since  1.0.0
	 */
	public function register_hooks() {

		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
				add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
			} else {
				add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
			}
		}

		//loading assets
		$this->assets_loader();

		/// pro
		add_filter( 'elementor/editor/localize_settings', [ $this, 'unlockafe_promote_pro_elements' ] );

		// Register category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_custom_widget_categories' ] );

		//add link
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'add_action_links' );

		// register RestAPI
		add_action( 'rest_api_init', [ $this->get_instance['widget_api'], 'register_routes' ] );

		/// remove promotions
		add_filter( 'unlockafe_addon/promotions', function ($value) {
			return [];
		} );
	}

	/**
	 *
	 * Creating instance for all the dependency class
	 *
	 * @since  1.0.0
	 */
	public function unlockafe_load_instance() {
		$this->get_instance['assets_loader'] = new Assets_loader( $this->registered_widgets );
		$this->get_instance['widget_api']    = new Widgets_API( $this->registered_widgets );
	}

	/**
	 *
	 * Registering cusotm a widget
	 *
	 * @since  1.0.0
	 */
	public function register_widgets( $widgets_manager ) {

		$get_widgets = is_array( get_option( '_unlockafe_addons_opstions' ) ) ? get_option( '_unlockafe_addons_opstions', true ) : [];

		$ids     = array_column( $get_widgets, 'id' );
		$widgets = $this->unlockafe_combine_widgets( $this->registered_widgets['widgets'], array_combine( $ids, $get_widgets ) );


		foreach ( $widgets as $key => $widget ) {

			if ( isset( $widget['class'] ) && $widget['status'] == true && class_exists($widget['class']) ) {
				$widgets_manager->register( new $widget['class'] );
			}

		}
	}
	/**
	 * `plugin_type` returning Plugin type
	 * 
	 * @return string
	 */
	public static function plugin_type() {
		return apply_filters( 'unlockafe_addon/plugin_type', 'lite' );
	}

	/**
	 * Loading pluign assets
	 */
	public function assets_loader() {

		add_action( 'wp_enqueue_scripts', [ $this->get_instance['assets_loader'], 'load_public_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this->get_instance['assets_loader'], 'unlockafe_load_admin_scripts' ] );
	}

	/**
	 * Add custom widget categories
	 */
	public function add_custom_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'unlockafe-addons',
			[ 
				'title' => __( 'Unlock Addons', 'unlock-addons-for-elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
		$elements_manager->add_category(
			'unlock-addons-pro',
			[ 
				'title' => __( 'Unlock Addons Pro', 'unlock-addons-for-elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
	}
	public function unlockafe_promote_pro_elements( $config ) {

		$pro_widgets = [];

		if ( isset( $config['promotionWidgets'] ) ) {
			$pro_widgets = $config['promotionWidgets'];
		}


		$add_pro_widget = apply_filters( 'unlockafe_addon/promotions', [ 
			[ 
				'name' => 'unlockafe-team-carousel',
				'title' => __( 'Team Carousel', 'unlock-addons-for-elementor' ),
				'icon' => 'eicon-slider-push',
				'categories' => '["unlock-addons-pro"]'
			],
			[ 
				'name' => 'unlockafe-blog-carousel',
				'title' => __( 'Blog Carousel', 'unlock-addons-for-elementor' ),
				'icon' => 'eicon-posts-carousel',
				'categories' => '["unlock-addons-pro"]'
			],
		] );

		$config['promotionWidgets'] = array_merge( $pro_widgets, $add_pro_widget );

		return $config;
	}

}