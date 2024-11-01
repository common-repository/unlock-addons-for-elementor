<?php

namespace Unlockafe_addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Product_Grid extends Widget_Base
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
        return 'unlockafe-product-grid';
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

    public function get_title()
    {
        return __('Products Grid', 'unlock-addons-for-elementor');
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
        return 'eicon-products-archive';
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

    protected function _register_controls()
    {

        //Start the Content Control Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'unlock-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        /**
		 * * * * * * 
		 * Number of Products
		 **/        
        $this->add_control(
            'product_count',
            [
                'label' => __('Number of Products', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 5,
            ]
        );

        /**
		 * * * * * * 
		 * Select Products
		 **/
        $this->add_control(
            'selected_products',
            [
                'label' => __('Select Products', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_all_products(),
                'multiple' => true,
                'label_block' => true,
            ]
        );
        /**
		 * * * * * * 
		 * Product Alignment
		 **/
        $this->add_control(
            'alignment',
            [
                'label' => __('Product Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .unlockafe-flex' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        //End the Content Control Section


        //Start General Control Section
        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General Control', 'unlock-addons-for-elementor'),
            ]
        );
        		/**
		 * * * * * * 
		 * number of product in a row
		 **/
        $this->add_control(
            'product_in_a_row',
            [
                'label' => __('Number of Products in a Row', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 4,
                'step' => 1,
                'default' => 3,
            ]
        );
		/**
		 * * * * * * 
		 * Order
		 **/
        $this->add_control(
			'section_order',
			[ 
				'label' => esc_html__( 'Order', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);

        /**
		 * * * * * * 
		 * Sort By
		 **/
        $this->add_control(
			'sort_by',
			[
				'label' => __('Sort By', 'unlock-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title' => __('Title', 'unlock-addons-for-elementor'),
					'price' => __('Price', 'unlock-addons-for-elementor'),
					'ID' => __('Product ID', 'unlock-addons-for-elementor'),
					'date' => __('Date', 'unlock-addons-for-elementor'),
                    'review_avg'=>__('Review','unlock-addons-for-elementor'),
				],
			]
		);

        /**
		 * * * * * * 
		 * Sort Order
		 **/		
	
		$this->add_control(
			'sort_order',
			[
				'label' => __('Sort Order', 'unlock-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC' => __('Ascending', 'unlock-addons-for-elementor'),
					'DESC' => __('Descending', 'unlock-addons-for-elementor'),
				],
			]
		);
		/**
		 * * * * * * 
		 * Arrange Product
		 **/
        $this->add_control(
			'section_visiblity',
			[ 
				'label' => esc_html__( 'Arrange Product', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);
        /**
		 * * * * * * 
		 * Show Badge
		 **/
        $this->add_control(
            'show_badge',
            [
                'label' => __('Show Badge', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
		 * * * * * * 
		 * Show Add to Cart
		 **/
        $this->add_control(
            'show_add_to_cart',
            [
                'label' => __('Show Add to Cart', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
		 * * * * * * 
		 * Show in Stock
		 **/
        $this->add_control(
            'show_in_stock',
            [
                'label' => __('Show in Stock', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
		 * * * * * * 
		 * Show Reviews
		 **/
        $this->add_control(
            'show_reviews',
            [
                'label' => __('Show Reviews', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
		 * * * * * * 
		 * Show Product Gallery
		 **/
        $this->add_control(
            'show_gallery',
            [
                'label' => __('Show Product Gallery', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
		/**
		 * * * * * * 
		 * Price
		 **/
        $this->add_control(
			'section_price',
			[ 
				'label' => esc_html__( 'Price', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);
        
        $this->add_control(
            'all_price',
            [
                'label' => __('Show Price', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );   
        /**
		 * * * * * * 
		 * Show Regular Price
		 **/
        $this->add_control(
            'show_regular_price',
            [
                'label' => __('Show Regular Price', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'condition'   => [
                    'all_price' => 'yes',
                ],
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        /**
		 * * * * * * 
		 * Is Line-Through
		 **/        
        $this->add_control(
            'regular_price_text_decoration',
            [
                'label' => __('Is Line-Through.', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'unlock-addons-for-elementor'),
                'label_off' => esc_html__('No', 'unlock-addons-for-elementor'),
                'return_value' => 'line-through',
                'default' => '',
                'condition' => [ 
					'show_regular_price' => 'yes',
                    'all_price' => 'yes',
				],
                'selectors' => [
                    '{{WRAPPER}} .regular_price_line_through ' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );
        /**
		 * * * * * * 
		 * Show Sale Price
		 **/
        $this->add_control(
            'show_sale_price',
            [
                'label' => __('Show Sale Price', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'condition'   => [
                    'all_price' => 'yes',
                ],
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
		 * * * * * * 
		 * Show Variable Price
		 **/
        $this->add_control(
            'show_variable_price',
            [
                'label' => __('Show Variable Price', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'condition'   => [
                    'all_price' => 'yes',
                ],
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        //End General Control Section


        //Start Basics Control Section
        $this->start_controls_section(
            'basics',
            [
                'label' => esc_html__('Basics Style', 'unlock-addons-for-elementor'),
            ]
        );
		/**
		 * * * * * * 
		 * Add heading
		 **/
        $this->add_control(
			'section_title',
			[ 
				'label' => esc_html__( 'Product Title', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);
        /**
		 * * * * * * 
		 * Title Tag
		 **/
        $this->add_control(
            'title_tag',
            [
                'label' => __('Title Tag', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'p',
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
                    'p' => [
                        'title' => esc_html__( 'P', 'unlock-addons-for-elementor' ),
                        'icon' => 'eicon-editor-paragraph',
                    ],
                ],
            ]
        );
        
        /**
		 * * * * * * 
		 * Product Title Alignment
		 **/
        $this->add_control(
            'alignment_title',
            [
                'label' => __('Title Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .product-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
		/**
		 * * * * * * 
		 * Add heading
		 **/
        $this->add_control(
			'section_pri',
			[ 
				'label' => esc_html__( 'Price', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);
        /**
		 * * * * * * 
		 * Price Text Size
		 **/    
        $this->add_control(
            'price_text_size_px',
            [
                'label' => __('Price Text Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 25,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-Price-amount' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .regular_price_line_through' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        /**
		 * * * * * * 
		 * Price Text Weight
		 **/           
        $this->add_control(
            'price_text_weight',
            [
                'label' => __('Price Text Weight', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '100' => __('100 (Thin)', 'unlock-addons-for-elementor'),
                    '200' => __('200 (Extra Light)', 'unlock-addons-for-elementor'),
                    '300' => __('300 (Light)', 'unlock-addons-for-elementor'),
                    '400' => __('400 (Normal)', 'unlock-addons-for-elementor'),
                    '500' => __('500 (Medium)', 'unlock-addons-for-elementor'),
                    '600' => __('600 (Semi Bold)', 'unlock-addons-for-elementor'),
                    '700' => __('700 (Bold)', 'unlock-addons-for-elementor'),
                    '800' => __('800 (Extra Bold)', 'unlock-addons-for-elementor'),
                    '900' => __('900 (Black)', 'unlock-addons-for-elementor'),
                ],
                'default' => '400',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-Price-amount' => 'font-weight: {{VALUE}};',
                ],
            ]
        );
		/**
		 * * * * * * 
		 * Add heading
		 **/
        $this->add_control(
			'section_des',
			[ 
				'label' => esc_html__( 'Description', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				
			]
		);


         /**
		 * * * * * * 
		 * Description
		 **/
        $this->add_control(
            'show_description',
            [
                'label' => __('Show Description', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'unlock-addons-for-elementor'),
                'label_off' => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );   
              /**
		 * * * * * * 
		 * Description font size
		 **/
        $this->add_control(
            'description_text_size_px',
            [
                'label' => __('Description Text Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 25,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'condition' => [ 
					'show_description' => 'yes',
				],
                'selectors' => [
                    '{{WRAPPER}} .product-footer-list' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /**
		 * * * * * * 
		 * Description Length
		 **/
		$this->add_control(
			'description_length',
			[ 
				'label' => esc_html__( 'Description Length(Word)', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 10,
				'condition' => [ 
					'show_description' => 'yes',
				],
			]
		);

        /**
		 * * * * * * 
		 * Product Description Alignment
		 **/
        $this->add_control(
            'alignment_des',
            [
                'label' => __('Product Description Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'show_description' => 'yes',
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .product-footer-details' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        //End the Basics Control Section

        //Image Size Control
        $this->start_controls_section(
            'image',
            [
                'label' => __('Image', 'unlock-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        /**
		 * * * * * * 
		 * Image Size
		 **/
        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'thumbnail' => __('Thumbnail', 'unlock-addons-for-elementor'),
                    'medium' => __('Medium', 'unlock-addons-for-elementor'),
                    'large' => __('Large', 'unlock-addons-for-elementor'),
                    'full' => __('Full', 'unlock-addons-for-elementor'),
                ],
            ]
        );
        /**
		 * * * * * * 
		 * Image Clickable
		 **/
        $this->add_control(
            'image_clickable',
            [
                'label' => __('Image Clickable', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'unlock-addons-for-elementor'),
                'label_off' => __('No', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        //End Image Size Control

        //Start Color Control Section
        $this->start_controls_section(
            'color',
            [
                'label' => esc_html__('Color', 'unlock-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        /**
		 * * * * * * 
		 * Card Color
		 **/
        $this->add_control(
            'product_card',
            [
                'label' => __('Card Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .product ' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .product .product-content-fade' => 'background-color: {{VALUE}}',
                ],
            ]
            );
        /**
		 * * * * * * 
		 * Title Color
		 **/
        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .product-title a h1' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a h2' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a h3' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a h4' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a h5' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a h6' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-title a p' => 'color: {{VALUE}}',
                ],
            ]
        );
        /**
         * * * * * * 
         * Description Color
         */
        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [ 
					'show_description' => 'yes',
				],
                'selectors' => [
                    '{{WRAPPER}} .product-footer-list' => 'color: {{VALUE}}',
                ],
            ]
        );

            $this->add_control(
                'section_price_color',
                [ 
                    'label' => esc_html__( 'Price', 'unlock-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'condition'   => [
                        'all_price' => 'yes',
                    ],
                    
                ]
            );    

        /**
         * * * * * * 
         * Regular Price Color
         */
        $this->add_control(
            'Regular_Price_color',
            [
                'label' => __('Regular Price Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'condition'   => [
                    'all_price' => 'yes',
                    'show_regular_price'=>'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .regular_price_line_through' => 'color: {{VALUE}}',
                ],
            ]
        );
        /**
         * * * * * * 
         * Sale Price Color
         */
        $this->add_control(
            'Sale_Price_color',
            [
                'label' => __('Sale Price Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition'   => [
                    'all_price' => 'yes',
                    'show_sale_price'=>'yes',
                ],
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .sale_price' => 'color: {{VALUE}}',
                ],
            ]
        );
        /**
         * * * * * * 
         * Variable Price Color
         */
        $this->add_control(
            'variable_Price_color',
            [
                'label' => __('Variable Price Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                
                'condition'   => [
                    'all_price' => 'yes',
                    'show_variable_price'=>'yes',
                ],
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .variable_price' => 'color: {{VALUE}}',
                ],
            ]
        );




        $this->end_controls_section();

        //End Color Control Section


    }


    private function get_all_products()
    {
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
        ];

        $query = new \WP_Query($args);
        $products = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $products[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }

        return $products;
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

        // Get the sorting and order direction from settings
        $sort_by = $settings['sort_by'];
        $sort_order = $settings['sort_order'];
        $title_tag = $settings['title_tag'];

        // Use transient for caching the query results
        $transient_key = 'unlockafe_product_query_' . md5(wp_json_encode($settings));
        $the_query = get_transient($transient_key);

        if ($the_query === false) {
            $args = [
                'post_type' => 'product',
                'posts_per_page' => $settings['product_count'],
                'order' => $sort_order,
                // 'meta_query' => [
                //     'relation' => 'OR', // Use OR relation if multiple conditions are required
                // ],
            ];

            // Add meta query conditions
            if ($sort_by === 'price') {
                $args['meta_query'][] = [
                    'key' => '_price',
                    'compare' => 'EXISTS',
                    'type' => 'DECIMAL', // Specify the type for better performance
                ];
                $args['orderby'] = 'meta_value_num';
            } elseif ($sort_by === 'review_avg') {
                $args['meta_query'][] = [
                    'key' => '_wc_average_rating',
                    'compare' => 'EXISTS',
                    'type' => 'DECIMAL',
                ];
                $args['orderby'] = 'meta_value_num';
            } elseif ($sort_by === 'review_count') {
                $args['meta_query'][] = [
                    'key' => '_wc_rating_count',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC',
                ];
                $args['orderby'] = 'meta_value_num';
            }

            if (!empty($settings['selected_products'])) {
                $args['post__in'] = $settings['selected_products'];
            }

            // Execute the query
            $the_query = new \WP_Query($args);
            // Cache the results for 12 hours (43200 seconds)
            set_transient($transient_key, $the_query, 43200);
        }

        ?>
            <div class="unlockafe-container" style="margin-top: 100px; margin-bottom: 100px">
            <div class="unlockafe-flex xxl-5 lg-4 md-3 sm-2">
                <?php
                if ($the_query->have_posts()) {
                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $this->get_skin('product_grid/layout-1', $settings);
                    endwhile;
                } else {
                    echo '<p>No products found.</p>'; // Handle no products case
                }
                wp_reset_postdata(); // Use wp_reset_postdata
                ?>
            </div>
            </div>
            <?php
    }
}