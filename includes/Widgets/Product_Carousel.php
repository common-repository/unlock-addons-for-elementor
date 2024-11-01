<?php

namespace Unlockafe_addons\Widgets;

use Elementor\Widget_Base;
use WP_Query;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) 
{
    exit;
}

class Product_Carousel extends Widget_Base
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
        return 'unlockafe-product-carousel';
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
        return __('Products Carousel', 'unlock-addons-for-elementor');
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
        return 'eicon-slides';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the accodion of categories the accodion widget belongs to.
     *
     * @since 1.0.0
     * @access public
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
     * Register accodion widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */


    protected function register_controls()
    {
        /**
         * 
         * Layout
         */
        $this->get_slider_controls(
            array(
                'slider-1' => esc_html__('Slider 1', 'unlock-addons-for-elementor'),
                'slider-2' => esc_html__('Slider 2', 'unlock-addons-for-elementor'),
            ),
        );
        /**
         * Start control for content tab
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'unlock-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'unlockafe_product_show_length',
            [
                'label' => __('How many Product Show.?', 'unlock-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'default' => 5,
            ]
        );
        /**
         * * * * * * 
         * Select Products
         */
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

        $this->add_control(
            'product_count',
            [
                'label' => __('Number of Products in slider', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 4,
                'step' => 1,
                'default' => 4,
            ]
        );

        // post source
        /**
         * * * * * * 
         * Order
         */
        $this->add_control(
            'section_order',
            [
                'label' => esc_html__('Order And Filter', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        $this->add_control(
            'post_source',
            [
                'label' => esc_html__('Post Source', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'title' => esc_html__('Title', 'unlock-addons-for-elementor'),
                    'date' => esc_html__('Date', 'unlock-addons-for-elementor'),
                    'modified' => esc_html__('Modified', 'unlock-addons-for-elementor'),
                    'rand' => esc_html__('Random', 'unlock-addons-for-elementor')
                ],
            ]
        );
        $this->add_control('unlockafe_product_carousel_product_filter', [
            'label'   => esc_html__('Filter By', 'unlock-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'recent-products',
            'options' => $this->unlockafe_get_product_filterby_options(),
        ]);

        $this->add_control('order', [
            'label'   => __('Order', 'unlock-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'asc'  => 'Ascending',
                'desc' => 'Descending',
            ],
            'default' => 'desc',

        ]);

        $this->end_controls_section();
        /**
         * Start control for content tab
         */
        $this->start_controls_section(
            'genaral_section',
            [
                'label' => esc_html__('General Control', 'unlock-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        /**
         * * * * * * 
         * Slider Icon
         */
        $this->add_control(
            'section_slider_icon',
            [
                'label' => esc_html__('Slider Icon', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        /**
         * * * * * * 
         * Size
         */
        $this->add_control(
            'icon_size',
            [
                'label' => __('Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon_size' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        /**
         * * * * * * 
         * Opacity
         */
        $this->add_control(
            'icon_opacity',
            [
                'label' => __('Opacity', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon_size' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        /**
         * * * * * * 
         * heading Arrenge product 
         */
        $this->add_control(
            'section_arrange',
            [
                'label' => esc_html__('Arrange Product', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        //-------------------------Start Title Section--------------------//
        /**
         * * * * * * 
         * product Title Show
         */
        $this->add_control(
            'show_slider_title',
            [
                'label' => esc_html__('Show Slider Title', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'unlock-addons-for-elementor'),
                'label_off' => esc_html__('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        /**
         * * * * * * 
         * Title
         */
        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Title', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'show_slider_title' => 'yes',
                ],

            ]
        );
        /**
         * * * * * * 
         * Title Tag
         */
        $this->add_control(
            'slider_heading_tags',
            [
                'label' => esc_html__('Title Tag', 'unlock-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'description' => esc_html__('You can change Heading Tags from here.', 'unlock-addons-for-elementor'),
                'condition' => [
                    'show_slider_title' => 'yes',
                ],
                'options' => [
                    'h1' => [
                        'title' => esc_html__('H1', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h1',
                    ],
                    'h2' => [
                        'title' => esc_html__('H2', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h2',
                    ],
                    'h3' => [
                        'title' => esc_html__('H3', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h3',
                    ],
                    'h4' => [
                        'title' => esc_html__('H4', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h4',
                    ],
                    'h5' => [
                        'title' => esc_html__('H5', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h5',
                    ],
                    'h6' => [
                        'title' => esc_html__('H6', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-h6',
                    ],
                    'p' => [
                        'title' => esc_html__('P', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-editor-paragraph',

                    ]
                ],
                'default' => 'p',
                'condition' => [
                    'show_slider_title' => 'yes',
                ],
            ]
        );

        // Alignment Control
        $this->add_control(
            'title_alignment',
            [
                'label' => __('Title Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'condition' => [
                    'show_slider_title' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .meta-wrapper h1' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper h2' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper h3' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper h4' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper h5' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper h6' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .meta-wrapper p' => 'text-align: {{VALUE}};',


                ],
            ]
        );
        /**
         * * * * * * 
         * Title Color
         */
        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'show_slider_title' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .meta-wrapper  h1' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h2' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h3' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h4' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h5' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h6' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  p' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h1 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h2 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h3 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h4 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h5 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  h6 a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .meta-wrapper  p a' => 'color: {{VALUE}}',
                ],
            ]
        );
        /**
         * * * * * * 
         * Title Clickable?
         */
        $this->add_control(
            'unlockafe_product_carousel_title_clickable',
            [
                'label' => esc_html__('Title Clickable?', 'unlock-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_slider_title' => 'yes',
                ],
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        //-------------------------End Title Section----------------------//

        //-------------------------Start Section Add To Cart----------------------//
        $this->add_control(
            'unlockafe_product_carousel_show_add_to_cart',
            [
                'label'        => __('Add to Cart', 'unlock-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'unlock-addons-for-elementor'),
                'label_off'    => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        //------------------------- Start Add to cart slider-1 Section----------------------//
        /**
         * * * * * * 
         * heading Cart
         */
        $this->add_control(
            'add_to_cart_icon',
            [
                'label' => esc_html__('Cart', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'slider_control' => 'slider-1',
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                ],

            ]
        );
        //size 
        $this->add_control(
            'size_image_to_icon',
            [
                'label' => __('Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'condition' => [
                    'slider_control' => 'slider-1',
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart-icon' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //gap 
        $this->add_control(
            'gap_image_to_icon',
            [
                'label' => __('Gap', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'condition' => [
                    'slider_control' => 'slider-1',
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .thumbnail-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Alignment Control
        $this->add_control(
            'add_to_alignment',
            [
                'label' => __('Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'condition' => [
                    'slider_control' => 'slider-1',
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart-2' => 'text-align: {{VALUE}};',


                ],
            ]
        );
        //-----------------------End Add to cart Slider-1 Section-------------------//


        //----------------------Start Add to cart slider-2 Section------------------//
        /**
         * * * * * * 
         * heading Cart
         */
        $this->add_control(
            'section_add_to_cart',
            [
                'label' => esc_html__('Cart', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],

            ]
        );
        /**
         * * * * * * 
         * Text Size
         */
        $this->add_control(
            'add_to_cart_text_size',
            [
                'label' => __('Text Size', 'unlock-addons-for-elementor'),
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
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-add-to-cart' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        /**
         * * * * * * 
         * Height
         */
        $this->add_control(
            'add_to_cart_height_size',
            [
                'label' => __('Height', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-slide .product-wrapper .product-group-button div.add-to-cart' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        /**
         * * * * * * 
         * Text Color
         */
        $this->add_control(
            'add_to_cart_text_color',
            [
                'label' => __('Text Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .btn-add-to-cart' => 'color: {{VALUE}}',
                ],
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
            ]
        );
        /**
         * * * * * * 
         * Background Color
         */
        $this->add_control(
            'add_to_cart_bg_color',
            [
                'label' => __('Background Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .btn-add-to-cart' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
            ]
        );
        /**
         * * * * * * 
         * Hover Text Color
         */
        $this->add_control(
            'add_to_cart_text_hover_color',
            [
                'label' => __('Hover Text Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .btn-add-to-cart:hover' => 'color: {{VALUE}}',
                ],
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
            ]
        );
        /**
         * * * * * * 
         * Hover Background Color
         */
        $this->add_control(
            'add_to_cart_hover_bg_color',
            [
                'label' => __('Hover Background Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#41E451',
                'selectors' => [
                    '{{WRAPPER}} .btn-add-to-cart:hover' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'unlockafe_product_carousel_show_add_to_cart' => 'yes',
                    'slider_control' => 'slider-2',
                ],
            ]
        );
        //------------------------- End Add to cart slider-2 Section----------------------//

        $this->add_control(
            'unlockafe_product_carousel_show_sale',
            [
                'label'        => __('Show Sale Status', 'unlock-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'unlock-addons-for-elementor'),
                'label_off'    => __('Hide', 'unlock-addons-for-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            'unlockafe_product_carousel_price',
            [
                'label'        => esc_html__('Show Product Price?', 'unlock-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        //----------------------------------End Image Section----------------------------//
        /**
         * * * * * * 
         * Start Discription Section
         */
        $this->add_control(
            'section_discription',
            [
                'label' => esc_html__('Discription', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        /**
         * * * * * * 
         * Discription
         */
        $this->add_control(
            'unlockafe_product_carousel_excerpt',
            [
                'label'        => esc_html__('Short Description?', 'unlock-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
        /**
         * * * * * * 
         * Excerpt Words
         */
        $this->add_control(
            'unlockafe_product_carousel_excerpt_length',
            [
                'label'     => __('Excerpt Words', 'unlock-addons-for-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '10',
                'condition' => [
                    'unlockafe_product_carousel_excerpt' => 'yes',
                ],
            ]
        );
        /**
         * * * * * * 
         * Expansion Indicator
         */
        $this->add_control(
            'unlockafe_product_carousel_excerpt_expanison_indicator',
            [
                'label'       => esc_html__('Expansion Indicator', 'unlock-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => '...',
                'condition'   => [
                    'unlockafe_product_carousel_excerpt' => 'yes',
                ],
                'ai' => [
                    'active' => false,
                ],
            ]
        );
        /**
         * * * * * * 
         * Font Size Control
         */

        $this->add_control(
            'description_font_size',
            [
                'label' => __('Description Font Size', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 16, // Default font size
                ],
                'condition' => [
                    'unlockafe_product_carousel_excerpt' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .short_description' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        /**
         * * * * * * 
         * Discription Color
         */
        $this->add_control(
            'disceiption_color',
            [
                'label' => __('Discription Color', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',

                'selectors' => [
                    '{{WRAPPER}} .short_description' => 'color: {{VALUE}}',
                ],
                'condition'   => [
                    'unlockafe_product_carousel_excerpt' => 'yes',
                ],
            ]
        );

        /**
         * * * * * * 
         * Alignment Control
         */
        $this->add_control(
            'description_alignment',
            [
                'label' => __('Description Alignment', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'unlock-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'condition' => [
                    'unlockafe_product_carousel_excerpt' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .short_description' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        //----------------------------------End Discription Section----------------------------//
        /**
         * * * * * * 
         * Image Section
         */
        $this->add_control(
            'section_image',
            [
                'label' => esc_html__('Image', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        /**
         * * * * * * 
         * Image Clickable?
         */
        $this->add_control(
            'unlockafe_product_carousel_image_clickable',
            [
                'label' => esc_html__('Image Clickable?', 'unlock-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        //----------------------------------End Image Section----------------------------//
        /**
         * * * * * * 
         * Other
         */
        $this->add_control(
            'section_other',
            [
                'label' => esc_html__('Other', 'unlock-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        /**
         * * * * * * 
         * Not Found Message
         */
        $this->add_control(
            'unlockafe_product_carousel_not_found_msg',
            [
                'label'     => __('Not Found Message', 'unlock-addons-for-elementor'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Products Not Found', 'unlock-addons-for-elementor'),
                'separator' => 'before',
                'ai' => [
                    'active' => false,
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Filter product.
     *
     * Filter WordPress product for use in the widget.
     *
     * @since 1.0.0
     * @access protected
     * @return array Product.
     */

    protected function unlockafe_get_product_filterby_options()
    {
        return apply_filters('unlockafe/product-carousel/filterby-options', [
            'recent-products'       => esc_html__('Recent Products', 'unlock-addons-for-elementor'),
            'featured-products'     => esc_html__('Featured Products', 'unlock-addons-for-elementor'),
            'best-selling-products' => esc_html__('Best Selling Products', 'unlock-addons-for-elementor'),
            'sale-products'         => esc_html__('Sale Products', 'unlock-addons-for-elementor'),
            'top-products'          => esc_html__('Top Rated Products', 'unlock-addons-for-elementor'),
            'related-products'      => esc_html__('Related Products', 'unlock-addons-for-elementor'),
        ]);
    }
    /**
     * Retrieve all categories.
     *
     * Retrieve all WordPress categories for use in the widget.
     *
     * @since 1.0.0
     * @access protected
     * @return array Categories.
     */
    protected function get_all_categories()
    {
        $categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
        $category_options = [];
        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }
        return $category_options;
    }

    /**
     * Retrieve all product.
     *
     * Retrieve all WordPress posts for use in the widget.
     *
     * @since 1.0.0
     * @access protected
     * @return array Posts.
     */
    protected function get_all_products()
    {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $products = get_posts($args);
        $product_options = [];

        foreach ($products as $product) {
            $product_options[$product->ID] = $product->post_title;
        }

        return $product_options;
    }


    /**
     * Render list widget output on the frontend.
     *
     * Output the HTML for the widget based on user settings.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $product_count = $settings['product_count'];
        if (!empty($settings['selected_products'])) {
            $args['post__in'] = $settings['selected_products'];
        }
        if ('slider-1' == $settings['slider_control']) {
            $this->get_skin('woocommerce/product/slider/slider-1', $settings);
        } else if ('slider-2' == $settings['slider_control']) {
            $this->get_skin('woocommerce/product/slider/slider-2', $settings);
        }
?>
        
<?php
    }
}