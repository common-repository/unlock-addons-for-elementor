<?php
if (! defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly.

return [
	'widgets' => [
		'unlockafe-blog-grid' => [
			'label' => 'Blog Grid',
			'class' => '\Unlockafe_addons\Widgets\Blog_Grid',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/blog.css',
					'context' => 'self'
				]
			],
			'js' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/js/blog.js',
					'context' => 'self'
				]
			],
			'group' => 'General',
			'status' => true,
			'type' => 'basic'
		],
		'unlockafe-button' => [
			'label' => 'Button',
			'class' => '\Unlockafe_addons\Widgets\Button',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/button.css',
					'context' => 'self'
				]
			],
			'group' => 'General',
			'status' => true,
			'type' => 'basic'
		],
		'unlockafe-team-grid' => [
			'label' => 'Team Grid',
			'class' => '\Unlockafe_addons\Widgets\Team_Grid',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/team.css',
					'context' => 'self'
				]
			],
			'group' => 'General',
			'status' => true,
			'type' => 'basic'
		],
		'unlockafe-progress-bar' => [
			'label' => 'Progress Bar',
			'class' => '\Unlockafe_addons\Widgets\Progress_bar',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'dependency/css/swiper-bundle.min.css',
					'context' => 'lib',
					'handle' => 'swiper'
				],
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/pie-chart.css',
					'context' => 'self'
				]
			],
			'js' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'dependency/js/swiper-element-bundle.min.js',
					'context' => 'lib',
					'handle' => 'swiper'
				],
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/js/progress-bar.js',
					'context' => 'self'
				],
			],
			'group' => 'General',
			'status' => true,
			'type' => 'basic'
		],
		'unlockafe-product-carousel' => [
			'label'  => 'Product Carousel',
			'class' => '\Unlockafe_addons\Widgets\Product_Carousel',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'dependency/css/swiper-bundle.min.css',
					'context' => 'lib',
					'handle' => 'swiper'
				],
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/product-carousel.css',
					'context' => 'self'
				],

			],

			'js' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'dependency/js/swiper-bundle.min.js',
					'context' => 'lib',
					'handle' => 'swiper'
				],
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/js/product-carousel.js',
					'context' => 'self'
				],

			],

			'group' => 'Woocommerce',
			'status' => true,
			'type' => 'basic'
		],
		'unlockafe-product-grid' => [
			'label' => 'Product Grid',
			'class' => '\Unlockafe_addons\Widgets\Product_Grid',
			'css' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/css/product-shop.css',
					'context' => 'self'
				]
			],
			'js' => [
				[
					'file' => UNLOCKAFE_ASSETS . 'front-end/js/product-shop.js',
					'context' => 'self'
				],
			],
			'group' => 'Woocommerce',
			'status' => true,
			'type' => 'basic'
		],
	]
];