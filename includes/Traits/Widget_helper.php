<?php

namespace Unlockafe_addons\Traits;

if (! defined('ABSPATH'))
	exit; // Exit if accessed directly

trait Widget_helper
{
	public function get_pro_notice()
	{

		// skip for pro users
		if ('lite' == \Unlockafe_addons\Unlockafe_addons::plugin_type() && true == false) {
			$this->start_controls_section(
				'ekit_section_pro',
				[
					'label' => __('Unlock Premium', 'unlock-addons-for-elementor'),
				]
			);

			$this->add_control(
				'custom_panel_alert',
				[
					'type' => \Elementor\Controls_Manager::ALERT,
					'alert_type' => 'info',
					'heading' => esc_html__('Unlock All widgets', 'unlock-addons-for-elementor'),
					'content' => '<span class="ekit-widget-pro-feature"> Get the  <a href="https://wprealizer.com/" target="_blank">Pro version</a> for more awesome elements and powerful modules.</span>',
				]
			);


			$this->end_controls_section();
		}
	}

	protected function get_upsale_data()
	{
		return [
			'condition' => ! \Elementor\Utils::has_pro(),
			'image' => esc_url(ELEMENTOR_ASSETS_URL . 'images/go-pro.svg'),
			'image_alt' => esc_attr__('Upgrade', 'unlock-addons-for-elementor'),
			'title' => esc_html__('Upgrade Pro', 'unlock-addons-for-elementor'),
			'description' => esc_html__('Get the premium version of the widget and grow your website capabilities.', 'unlock-addons-for-elementor'),
			'upgrade_url' => esc_url('https://unlockaddons.com/unlock-addons-for-elementor/'),
			'upgrade_text' => esc_html__('Upgrade Now', 'unlock-addons-for-elementor'),
		];
	}

	public function print_paragraph($text = '', $allowed_tags = [], $class = '')
	{
		if (empty($text))
			return;
		$class = $class != '' ? 'class=' . $class : '';
		echo '<p ' . wp_kses($class, true) . '>' . wp_kses($text, $allowed_tags) . '</p>';
	}


	public function get_layout_controls($array = [])
	{
		/**
		 * 
		 * Layout
		 */
		$this->start_controls_section(
			'layout',
			[
				'label' => esc_html__('Layout', 'unlock-addons-for-elementor'),
			]
		);

		$this->add_control(
			'layout_control',
			[
				'label' => esc_html__('Layout Style', 'unlock-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => $array
			]
		);

		$this->end_controls_section();
	}
	public function get_slider_controls($array = [])
	{
		/**
		 * 
		 * Slider
		 */
		$this->start_controls_section(
			'slider',
			[
				'label' => esc_html__('Slider', 'unlock-addons-for-elementor'),
			]
		);

		$this->add_control(
			'slider_control',
			[
				'label' => esc_html__('Slider Style', 'unlock-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'slider-1',
				'options' => $array
			]
		);

		$this->end_controls_section();
	}
}
