<?php

namespace Unlockafe_addons\API;
use Unlockafe_addons\Traits\Utils;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly.

class Widgets_API {
	use Utils;

	/**
	 * Default Registerd widgets
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $registered_widgets = [];

	/**
	 * optimized Registerd widgets
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $new_widgets = [];

	/**
	 * Namespace for RestAPI
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $namespace = 'unlockafe-addons/v1';

	public function __construct( $registered_widgets ) {
		$this->registered_widgets = $registered_widgets['widgets'];
	}

	public function register_routes() {

		// get all the widgets
		register_rest_route( $this->namespace, '/widgets/', array(
			'methods' => 'GET',
			'callback' => [ $this, 'get_widgets' ],
			'permission_callback' => function () {
				return is_user_logged_in();
			},
		) );
		// Update Element status
		register_rest_route( $this->namespace, '/widgets/update/', array(
			'methods' => 'POST',
			'callback' => [ $this, 'unlockafe_widgets' ],
			'permission_callback' => function () {
				return is_user_logged_in();
			},
		) );
		// Get Dashboard
		register_rest_route( $this->namespace, '/dashboard/', array(
			'methods' => 'GET',
			'callback' => [ $this, 'dashboard_data' ],
			'permission_callback' => function () {
				return is_user_logged_in();
			},
		) );
	}

	function get_widgets( $data ) {

		// initialized
		$response = [];

		$get_widgets = is_array( get_option( '_unlockafe_addons_opstions' ) ) ? get_option( '_unlockafe_addons_opstions' ) : [];

		$response = array(
			// 'widgets' => ( $get_widgets != '' ) ? $get_widgets : $this->filter_widgets()
			'widgets' => $this->unlockafe_combine_widgets( $this->filter_widgets(), $get_widgets )

		);

		return new \WP_REST_Response( $response, 200 );
	}


	public function unlockafe_widgets( $data ) {
		$params = $data->get_params();

		if ( isset( $params['_nonce'] ) && ! wp_verify_nonce( $params['_nonce'], '_unlockafe_nonce' ) ) {
			return new \WP_REST_Response( array( 'message' => 'Invalid nonce' ), 403 );
		}

		if ( isset( $params['widgets'] ) ) {
			// update the array
			update_option( '_unlockafe_addons_opstions', json_decode( $params['widgets'], true ) );

			return new \WP_REST_Response( $params['widgets'], 200 );
		}

		return new \WP_REST_Response( array( 'message' => 'Something wrong!' ), 403 );
	}

	public function dashboard_data() {

		// get active element
		$get_widgets = is_array( get_option( '_unlockafe_addons_opstions' ) ) ? get_option( '_unlockafe_addons_opstions' ) : [];
		$all_widgets = $this->unlockafe_combine_widgets( $this->filter_widgets(), $get_widgets );

		$status    = array_column( $all_widgets, 'status' );
		$active    = array_filter( $status );
		$in_active = array_filter( $status, function ($item) {
			return empty( $item );
		} );

		$data = [ 
			'total_elements' => [ 
				'label' => __( 'Total Elements', 'unlock-addons-for-elementor' ),
				'counter' => count( $status ),
			],
			'active_elements' => [ 
				'label' => __( 'Active Elements', 'unlock-addons-for-elementor' ),
				'counter' => count( $active ),
			],
			'inactive_elements' => [ 
				'label' => __( 'Inactive Elements', 'unlock-addons-for-elementor' ),
				'counter' => count( $in_active ),
			]
		];

		return new \WP_REST_Response( $data, 200 );
	}
}
