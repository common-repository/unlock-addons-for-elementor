<?php

/**
 * Unlockafe Addons 
 *
 * @package Unlockafe_addons
 * @subpackage Unlockafe_addons\Classes
 */

namespace Unlockafe_addons\Classes;

use Elementor\Plugin;
use Error;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly.

class Widget_manager {

	const UNLOCKAFE_ACTIVE_WIDGETS = '_unlockafe_active_widgets';

	public $registered_widgets = array();

	public function __construct( $registered_widgets ) {
		$this->registered_widgets = $registered_widgets;
	}

	public function unlockafe_elementor_after_save( $post_id, $editor_data ) {
		$active_widgets = $this->unlockafe_active_widgets( $editor_data );
		$this->save_active_widgets( $post_id, $active_widgets );
	}

	public function unlockafe_active_widgets( $editor_data ) {
		$active_widgets = [];

		Plugin::$instance->db->iterate_data( $editor_data, function ($element) use (&$active_widgets) {

			//get widget type
			if ( ! empty( $element['widgetType'] ) ) {
				$widget_type = $element['widgetType'];
			} else {
				$widget_type = $element['elType'];
			}

			if ( ! empty( $widget_type ) && strpos( $widget_type, 'unlockafe-' ) !== false ) {
				$active_widgets[ $widget_type ] = $widget_type;
			}
		} );

		// error_log( print_r($active_widgets, true));
		return $active_widgets;
	}

	public function save_active_widgets( $post_id, $active_widgets ) {

		if ( \defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		$document = is_object( Plugin::$instance->documents ) ? Plugin::$instance->documents->get( $post_id ) : [];


		if ( ! in_array( get_post_status( $post_id ), [ 'publish', 'private' ] ) || ( ! is_object( $document ) && ! $document->is_built_with_elementor() ) ) {
			return false;
		}

		// one more condition left ( Check widgets )

		try {
			// add all the active widgets to db
			update_post_meta( $post_id, self::UNLOCKAFE_ACTIVE_WIDGETS, $active_widgets );

			// remove existing assets
			$this->remove_assets( $post_id );

			// create file if ! exist
			$this->create_dir();

			// build the scripts
			$this->build_assets( $post_id, $active_widgets );
			return true;

		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * remove_assets
	 * Removing existing assets
	 * 
	 * @param int $post_id
	 * @return void
	 */
	public function remove_assets( int $post_id = null ) {
		foreach ( [ 'css', 'js' ] as $ext ) {

			// build file path
			$file_id = ( $post_id != null ) ? '-' . $post_id : '';
			$file    = UNLOCKAFE_WP_ASSETS_PATH . 'unlockafe' . $file_id . '.' . $ext;

			// check and delete
			if ( file_exists( $file ) ) {
				wp_delete_file( $file );
			}
		}
	}

	public function build_assets( $post_id, $active_widgets ) {
		// build css
		$this->get_script( $post_id, $active_widgets, 'css' );
		// build js
		$this->get_script( $post_id, $active_widgets, 'js' );
	}

	public function get_script( $post_id, $active_widgets, $ext ) {
		$file_id   = ( $post_id != '' ) ? '-' . $post_id : '';
		$main_file = UNLOCKAFE_WP_ASSETS_PATH . UNLOCKAFE_init()::PREFIX . $file_id . '.' . $ext;

		// get all the scriont ${ext}
		$output = '';
		$paths  = [];

		// loop throw the active widgets

		if ( $post_id != null ) {
			foreach ( $active_widgets as $w ) {
				if ( isset( $this->registered_widgets['widgets'][ $w ][ $ext ] ) ) {
					// collect all the path
					if ( is_array( $this->registered_widgets['widgets'][ $w ][ $ext ] ) ) {
						foreach ( $this->registered_widgets['widgets'][ $w ][ $ext ] as $path ) {

							if( $path['context'] == 'lib'){
								continue;
							}

							// append the file to $path array
							$paths[] = $path['file'];
						}
					}
				}
			}
		} else {

			foreach ( $this->registered_widgets['widgets'] as $w ) {
				if ( isset( $w[ $ext ] ) && is_array( $w[ $ext ] ) ) {

					foreach ( $w[ $ext ] as $path ) {
						// append the file to $path array
						if( $path['context'] == 'lib' && isset($path['handle']) ){
							if( $ext == 'css' ){
								wp_enqueue_style( 
									$path['handle'],
									$path['file'],
									[],
									UNLOCKAFE_VERSION,
									'all'
								);
							}
							if( $ext == 'js' ){
								wp_enqueue_script( 
									$path['handle'],
									$path['file'],
									['jquery'],
									UNLOCKAFE_VERSION,
									true
								);
							}
							
						}else{
							$paths[] = $path['file'];
						}
						
						
					}
				}
			}
		}

		if ( $ext == 'js' ) {
			$output .= '(function($){"use strict"';
		}

		// concat all the assets
		foreach ( $paths as $file ) {
			$res = wp_remote_get( $file );
			if ( is_array( $res ) && ! is_wp_error( $res ) ) {
				$output .= $res['body'];
			}
		}

		if ( $ext == 'js' ) {
			$output .= '}(jQuery))';
		}

		// put all the styles
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		// Initialize the WP_Filesystem global variable
		global $wp_filesystem;
		WP_Filesystem();

		$wp_filesystem->put_contents( $main_file, $output, FS_CHMOD_FILE );
	}

	public function singuler_file( $file_name ) {

		// return if empty
		if ( empty( $file_name ) )
			return;

		// retrive the post ID
		$post_id = preg_replace( '/[^0-9]/', '', $file_name );

		$active_widgets = get_post_meta( $post_id, self::UNLOCKAFE_ACTIVE_WIDGETS );

		if ( ! empty( $active_widgets ) ) {
			// enqueu styles
			$style_handle = UNLOCKAFE_init()::PREFIX . '-' . $post_id;
			$js_handle    = UNLOCKAFE_init()::PREFIX . '-' . $post_id;

			// load css
			wp_enqueue_style(
				$style_handle,
				UNLOCKAFE_WP_ASSETS_URI . $style_handle . '.css',
				[ UNLOCKAFE_init()::PREFIX . '-public' ],
				get_post_modified_time(),
				'all'
			);

			// load js
			wp_enqueue_script(
				$js_handle,
				UNLOCKAFE_WP_ASSETS_URI . $js_handle . '.js',
				[],
				get_post_modified_time(),
				true
			);

		}

		return $file_name;
	}

	/**
	 * Summary of add_elementor_assets
	 * 
	 * This method is responsible for enqueue and bundle css
	 * of Elementor
	 * 
	 * @return void
	 */
	public function add_elementor_assets() {

		if ( Plugin::instance()->editor->is_edit_mode() || Plugin::instance()->preview->is_preview_mode() ) {

			$this->build_elementor_assets();

			// styles
			wp_enqueue_style(
				UNLOCKAFE_init()::PREFIX,
				UNLOCKAFE_WP_ASSETS_URI . UNLOCKAFE_init()::PREFIX . '.css',
				[],
				UNLOCKAFE_VERSION
			);

			// scripts
			wp_enqueue_script(
				UNLOCKAFE_init()::PREFIX,
				UNLOCKAFE_WP_ASSETS_URI . UNLOCKAFE_init()::PREFIX . '.js',
				[ 'jquery' ],
				UNLOCKAFE_VERSION,
				true
			);
		}
	}


	public function build_elementor_assets() {
		// removing old assets
		$this->remove_assets();

		// check and create dir
		$this->create_dir();

		// build assets
		$this->build_assets( '', '' );
	}

	/**  
	 * create_dir to create Folder
	 * in specific directory
	 * 
	 * @return void
	 */
	private function create_dir() {
		if ( ! file_exists( UNLOCKAFE_WP_ASSETS_PATH ) ) {
			wp_mkdir_p( UNLOCKAFE_WP_ASSETS_PATH );
		}
	}

	public function unlockafe_editor_styles() {
		wp_enqueue_style( UNLOCKAFE_init()::PREFIX . '-editor', UNLOCKAFE_ASSETS . 'editor.css', [], UNLOCKAFE_VERSION );
	}

	public function load_plugin_dependency(){
		
		//

	}
}
