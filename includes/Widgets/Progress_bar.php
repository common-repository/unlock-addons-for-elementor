<?php

namespace Unlockafe_addons\Widgets;

use Unlockafe_addons\Traits\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Unlockafe_addons\Traits\Widget_helper;

if (! defined('ABSPATH'))
{
	exit; // Exit if accessed directly
}


/**
 * Pricing table style one
 *
 * @since 1.0.0
 */
class Progress_Bar extends Widget_Base
{
	use Widget_helper;
	use Utils;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'unlockafe-progress-bar';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Progress bar', 'unlock-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-loading';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['unlockafe-addons'];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends()
	{
		return [];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls()
	{

		/**
		 * 
		 * Layout
		 */
		$this->get_layout_controls( [ 
			'layout-1' => esc_html__( 'Style 1', 'unlock-addons-for-elementor' ),
		] );

		/**
		 * 
		 * Start control for content tab
		 */
		$this->start_controls_section(
			'content_section',
			[ 
				'label' => esc_html__( 'Contents', 'unlock-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/**
		 * * * * * * 
		 * Card content
		 */

		$this->add_control(
			'progress',
			[ 
				'label' => esc_html__( 'Progress', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'max' => 100,
				'default' => 75,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'title',
			[ 
				'label' => esc_html__( 'Title', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Web Desgin', 'unlock-addons-for-elementor' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'heading_tags',
			[ 
				'label' => esc_html__( 'Title Tag', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'description' => esc_html__( 'You can change Heading Tags from here.', 'unlock-addons-for-elementor' ),
				'options' => [ 
					'h1' => [ 
						'title' => esc_html__( 'H1', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h1',
					],
					'h2' => [ 
						'title' => esc_html__( 'H2', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h2',
					],
					'h3' => [ 
						'title' => esc_html__( 'H3', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h3',
					],
					'h4' => [ 
						'title' => esc_html__( 'H4', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h4',
					],
					'h5' => [ 
						'title' => esc_html__( 'H5', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h5',
					],
					'h6' => [ 
						'title' => esc_html__( 'H6', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-editor-h6',
					],
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'description',
			[ 
				'label' => esc_html__( 'Description', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Default description', 'unlock-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Type your description here', 'unlock-addons-for-elementor' ),
				'dynamic' => [ 
					'active' => true,
				],
			]
		);

		$this->add_control(
			'link',
			[ 
				'label' => esc_html__( 'Link', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (! empty($settings['link']['url'])) {
			$this->add_link_attributes('link', $settings['link']);
		}

		switch ($settings['layout_control']) {
			case 'layout-1':
				$this->get_skin('progress/layout-1', $settings);
				break;
			default:
				$this->get_skin('progress/layout-1', $settings);
		}
	}
}