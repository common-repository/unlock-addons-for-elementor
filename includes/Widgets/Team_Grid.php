<?php

namespace Unlockafe_addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (! defined('ABSPATH'))
{
	exit; // Exit if accessed directly
}


/**
 * Pricing table style one
 *
 * @since 1.0.0
 */
class Team_Grid extends Widget_Base
{
	use \Unlockafe_addons\Traits\Widget_helper;
	use \Unlockafe_addons\Traits\Utils;

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
		return 'unlockafe-team-grid';
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
		return __( 'Team', 'unlock-addons-for-elementor' );
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
		return 'eicon-call-to-action';
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
		 * =======================
		 * Member information
		 */
		$this->start_controls_section(
			'team_member_info',
			[ 
				'label' => esc_html__( 'Team Member', 'unlock-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'layout_control',
			[ 
				'label' => esc_html__( 'Layout Style', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'layout-1' => esc_html__( 'Style 1', 'unlock-addons-for-elementor' ),
					'layout-2' => esc_html__( 'Style 2', 'unlock-addons-for-elementor' ),
				),
			]
		);


		/**
		 * ==================
		 *  Team Member controls
		 * ==================
		 */
		$this->add_control(
			'image',
			[ 
				'label' => esc_html__( 'Choose Image', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_thumb', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				// 'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

		$this->add_control(
			'is_link_name',
			[ 
				'label' => esc_html__( 'Link name', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'separator' => 'before'
			]
		);

		// name
		$this->add_control(
			'name',
			[ 
				'label' => esc_html__( 'Name', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Member name', 'unlock-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Member name', 'unlock-addons-for-elementor' ),
				'separetor' => 'before'
			]
		);

		$this->add_control(
			'name_link',
			[ 
				'label' => esc_html__( 'Link', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
				'condition' => [
					'is_link_name' => 'yes',
					'name!' => ''
				],
				'separator' => 'before'
			]
		);


		// Designation
		$this->add_control(
			'designation',
			[ 
				'label' => esc_html__( 'Designation', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Member Designation', 'unlock-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Member Designation', 'unlock-addons-for-elementor' ),
			]
		);

		// title tag
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
				'condition' => [
					'name!' => '',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();


		/**
		 * ==================
		 *  Team Member Social
		 * ==================
		 */

		$this->start_controls_section(
			'team_member_social',
			[ 
				'label' => esc_html__( 'Social', 'unlock-addons-for-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'social_icon',
			[ 
				'label' => esc_html__( 'Social Icon', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				// 'skin' => 'inline',
				// 'label_block' => false,
			]
		);

		$repeater->add_control(
			'social_link',
			[ 
				'label' => esc_html__( 'Social Link', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => ['url', 'is_external', 'nofollow'],
				'default' => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'social_profiles',
			[ 
				'label' => esc_html__( 'Repeater List', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook-f',
							'library' => 'fa-solid',
						],
						'social_link' => esc_url('https://www.facebook.com/wprealizer'),
					],
					[
						'social_icon' => [
							'value' => 'fab fa-x-twitter',
							'library' => 'fa-solid',
						],
						'social_link' => esc_url('https://twitter.com/wprealizer'),
					],
					[
						'social_icon' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-solid',
						],
						'social_link' => esc_url('https://www.instagram.com/'),
					],
					[
						'social_icon' => [
							'value' => 'fab fa-linkedin-in',
							'library' => 'fa-solid',
						],
						'social_link' => esc_url('https://www.linkedin.com/'),
					],
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

		if ($settings['is_link_name'] == 'yes') {
			$this->add_link_attributes('name_link', $settings['name_link']);
		}


		if (empty($settings['name']))
			return;

		switch ($settings['layout_control']) {
			case 'layout-1':
				$this->get_skin('team-grid/layout-1', $settings);
				break;

			case 'layout-2':
				$this->get_skin('team-grid/layout-2', $settings);
				break;

			default:
				$this->get_skin('team-grid/layout-1', $settings);
		}
	}
}