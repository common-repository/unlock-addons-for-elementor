<?php

namespace Unlockafe_addons\Widgets;

use Unlockafe_addons\Traits\Utils;
use Unlockafe_addons\Traits\Widget_helper;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
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
class Button extends Widget_Base
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
		return 'unlockafe-button';
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
		return __( 'Button', 'unlock-addons-for-elementor' );
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
		return 'eicon-button';
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
	protected function register_controls($args = [])
	{

		$default_args = [
			'section_condition' => [],
			'button_default_text' => esc_html__( 'Click here', 'unlock-addons-for-elementor' ),
			'text_control_label' => esc_html__( 'Text', 'unlock-addons-for-elementor' ),
			'icon_exclude_inline_options' => [],
		];

		$args = wp_parse_args($args, $default_args);

		/**
		 * 
		 * Layout
		 */
		$this->start_controls_section(
			'layout',
			[ 
				'label' => esc_html__( 'Button', 'unlock-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'layout_control',
			[ 
				'label' => esc_html__( 'Layout Style', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => array(
					'layout-1' => esc_html__( 'Style 1', 'unlock-addons-for-elementor' ),
					'layout-2' => esc_html__( 'Style 2', 'unlock-addons-for-elementor' ),
					'layout-3' => esc_html__( 'Style 3', 'unlock-addons-for-elementor' ),
				),
			]
		);

		// buttton text
		$this->add_control(
			'text',
			[ 
				'label' => esc_html__( 'Text', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Click here', 'unlock-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Click here', 'unlock-addons-for-elementor' ),
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

		$this->add_control(
			'selected_icon',
			[ 
				'label' => esc_html__( 'Icon', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
			]
		);

		$this->add_control(
			'icon_align',
			[ 
				'label' => esc_html__( 'Alignment', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'row',
				'options' => [ 
					'row-reverse' => [ 
						'title' => esc_html__( 'Start', 'unlock-addons-for-elementor' ),
						'icon' => "eicon-h-align-left",
					],
					'row' => [ 
						'title' => esc_html__( 'End', 'unlock-addons-for-elementor' ),
						'icon' => "eicon-h-align-right",
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global' => 'flex-direction: {{VALUE}}',
				],
				'condition' => [
					'text!' => '',
					'selected_icon[value]!' => ''
				]
			]
		);

		// buttton text
		$this->add_control(
			'btn_id',
			[ 
				'label' => esc_html__( 'Button ID', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();



		/***
		 * ***************
		 * Styles
		 * **************
		 */

		$this->start_controls_section(
			'style_section',
			[ 
				'label' => esc_html__( 'Style', 'unlock-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[ 
				'label' => esc_html__( 'Position', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [ 
					'left' => [ 
						'title' => esc_html__( 'Left', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [ 
						'title' => esc_html__( 'Right', 'unlock-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .ade-btn-global',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .ade-btn-global',
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[ 
				'label' => esc_html__( 'Normal', 'unlock-addons-for-elementor' ),

			]
		);

		$this->add_control(
			'button_text_color',
			[ 
				'label' => esc_html__( 'Text Color', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global, {{WRAPPER}} .ade-btn-global .btn-flip span::after, {{WRAPPER}} .ade-btn-global .btn-flip span::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ade-btn-global .button-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ade-btn-global .button-icon-wrap' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => ['classic', 'gradient'],
				// 'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ade-btn-global',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
					],
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[ 
				'label' => esc_html__( 'Hover', 'unlock-addons-for-elementor' ),

			]
		);

		$this->add_control(
			'hover_color',
			[ 
				'label' => esc_html__( 'Text Color', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global:hover, {{WRAPPER}} .ade-btn-global:hover .btn-flip span::after, {{WRAPPER}} .ade-btn-global:hover .btn-flip span::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ade-btn-global:hover .button-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ade-btn-global:hover .button-icon-wrap' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'types' => ['classic', 'gradient'],
				// 'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ade-btn-global:hover, {{WRAPPER}} .ade-btn-global:focus',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],

			]
		);

		$this->add_control(
			'button_hover_border_color',
			[ 
				'label' => esc_html__( 'Border Color', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global:hover, {{WRAPPER}} .ade-btn-global:focus' => 'border-color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'button_hover_transition_duration',
			[ 
				'label' => esc_html__( 'Transition Duration', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['s', 'ms', 'custom'],
				'default' => [
					'unit' => 's',
				],
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global' => 'transition-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[ 
				'label' => esc_html__( 'Hover Animation', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .ade-btn-global',
				'separator' => 'before',

			]
		);

		$this->add_responsive_control(
			'border_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ade-btn-global',

			]
		);

		$this->add_responsive_control(
			'text_padding',
			[ 
				'label' => esc_html__( 'Padding', 'unlock-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
				'selectors' => [
					'{{WRAPPER}} .ade-btn-global' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',

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

		if ($settings['text'] == '') {
			return;
		}

		if (! empty($settings['link']['url'])) {
			$this->add_link_attributes('link', $settings['link']);
		}

		if (! empty($settings['btn_id'])) {
			$this->add_render_attribute(
				'btn_id',
				[
					'id' => $settings['btn_id'],
				]
			);
		}

		switch ($settings['layout_control']) {
			case 'layout-1':
				$this->get_skin('button/layout-1', $settings);
				break;

			case 'layout-2':
				$this->get_skin('button/layout-2', $settings);
				break;

			case 'layout-3':
				$this->get_skin('button/layout-3', $settings);
				break;

			default:
				$this->get_skin('button/layout-1', $settings);
		}
	}
}