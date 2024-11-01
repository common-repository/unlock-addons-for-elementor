<?php

namespace Unlockafe_addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (! defined('ABSPATH')){
	exit; // Exit if accessed directly
}


/**
 * Pricing table style one
 *
 * @since 1.0.0
 */
class Blog_Grid extends Widget_Base
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
		return 'unlockafe-blog-grid';
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
		return __( 'Blog Grid', 'unlock-addons-for-elementor' );
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
		return 'eicon-posts-group';
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
		$this->get_layout_controls(
			array(
				'layout-1' => esc_html__( 'Style 1', 'unlock-addons-for-elementor' ),
				'layout-2' => esc_html__( 'Style 2', 'unlock-addons-for-elementor' ),
				'layout-3' => esc_html__( 'Style 3', 'unlock-addons-for-elementor' ),
				'layout-4' => esc_html__( 'Style 4', 'unlock-addons-for-elementor' ),
			),
		);

		/**
		 * 
		 * Start control for content tab
		 */
		$this->start_controls_section(
			'widget_settings',
			[ 
				'label' => esc_html__( 'Settings', 'unlock-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);



		$this->add_control(
			'post_per_page',
			[ 
				'label' => esc_html__( 'Post Per page', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumb', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
			]
		);

		/**
		 * * * * * * 
		 * Post Title
		 */
		$this->add_control(
			'show_title',
			[ 
				'label' => esc_html__( 'Show Title', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_length',
			[ 
				'label' => esc_html__( 'Title Length', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'condition' => [
					'show_title' => 'yes',
				],
				'default' => 7,
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
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		/**
		 * * * * * * 
		 * Excerpt
		 */
		$this->add_control(
			'show_excerpt',
			[ 
				'label' => esc_html__( 'Show excerpt', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[ 
				'label' => esc_html__( 'Excerpt Length', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 100,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);


		/**
		 * * * * * * 
		 * meta control
		 */
		$this->add_control(
			'meta_options',
			[ 
				'label' => esc_html__( 'Meta Data', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [ 
					'date' => esc_html__( 'Date', 'unlock-addons-for-elementor' ),
					'comment' => esc_html__( 'Comment', 'unlock-addons-for-elementor' ),
					'author' => esc_html__( 'Author', 'unlock-addons-for-elementor' ),
					'category' => esc_html__( 'Category', 'unlock-addons-for-elementor' ),
				],
				'default' => ['category', 'date'],
				'condition' => [
					'layout_control!' => 'layout-3'
				]
			]
		);

		// Aditional Meta options
		$this->add_control(
			'show_author',
			[ 
				'label' => esc_html__( 'Show Author', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'layout_control' => 'layout-3'
				]
			]
		);

		$this->add_control(
			'show_date',
			[ 
				'label' => esc_html__( 'Show Date', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'layout_control' => 'layout-3'
				]
			]
		);


		/**
		 * * * * * * 
		 * Read more
		 */
		$this->add_control(
			'show_read_more',
			[ 
				'label' => esc_html__( 'Read More', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before'
			]
		);
		$this->add_control(
			'read_more_text',
			[ 
				'label' => esc_html__( 'Read More Text', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'unlock-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Type button name', 'unlock-addons-for-elementor' ),
				'condition' => [ 'show_read_more' => 'yes' ]
			]
		);
		$this->add_control(
			'open_new_window',
			[ 
				'label' => esc_html__( 'Open in new window', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'unlock-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'unlock-addons-for-elementor' ),
				'return_value' => 'yes',
				// 'default' => 'yes',
			]
		);

		$this->end_controls_section();



		/**
		 * 
		 * Start control for QUERY tab
		 */
		$this->start_controls_section(
			'widget_query',
			[ 
				'label' => esc_html__( 'Query', 'unlock-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// post source
		$this->add_control(
			'post_source',
			[ 
				'label' => esc_html__( 'Post Source', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [ 
					'title' => esc_html__( 'Title', 'unlock-addons-for-elementor' ),
					'date' => esc_html__( 'Date', 'unlock-addons-for-elementor' ),
					'modified' => esc_html__( 'Modified', 'unlock-addons-for-elementor' ),
					'rand' => esc_html__( 'Random', 'unlock-addons-for-elementor' )
				],
			]
		);

		// notice for view
		$this->add_control(
			'post_source_notice',
			[
				'type' => \Elementor\Controls_Manager::NOTICE,
				'notice_type' => 'warning',
				'dismissible' => true,
				'heading' => esc_html__( 'Alert!', 'unlock-addons-for-elementor' ),
				'content' => esc_html__( 'Show by views will only work since plugin activated.', 'unlock-addons-for-elementor' ),
				'condition' => [ 'post_source' => 'views' ]
			]
		);

		// post ordering
		$this->add_control(
			'post_ordering',
			[ 
				'label' => esc_html__( 'Ordering', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [ 
					'ASC' => esc_html__( 'ASC', 'unlock-addons-for-elementor' ),
					'DESC' => esc_html__( 'DESC', 'unlock-addons-for-elementor' )
				],
			]
		);



		/**
		 ********* 
		 * Post Exclude / include
		 */

		$this->add_control(
			'ex_in_post',
			[ 
				'label' => esc_html__( 'Exclude / Include any post', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'in_tabs'
		);

		$this->start_controls_tab(
			'start_include_tab',
			[ 
				'label' => esc_html__( 'Include', 'unlock-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'include_post',
			[ 
				'label' => esc_html__( 'Include Post', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_posts(),
				'description' => esc_html__( 'Select posts to include showing frontend', 'unlock-addons-for-elementor' )
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'exclude_tab',
			[ 
				'label' => esc_html__( 'Exclude', 'unlock-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'exclude_post',
			[ 
				'label' => esc_html__( 'Exclude Post', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_posts(),
				'description' => esc_html__( 'Select posts to exclude showing frontend', 'unlock-addons-for-elementor' )
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		/**
		 * * * * * * 
		 * Filter post
		 */

		//  Tax Relation
		$this->add_control(
			'tax_relation',
			[ 
				'label' => esc_html__( 'Relation', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [ 
					'AND' => esc_html__( 'AND', 'unlock-addons-for-elementor' ),
					'OR' => esc_html__( 'OR', 'unlock-addons-for-elementor' ),
					'NOT' => esc_html__( 'NOT', 'unlock-addons-for-elementor' ),
				],
				'description' => esc_html__( 'Select taxonomy Logical relation', 'unlock-addons-for-elementor' )
			]
		);

		// Category
		$this->add_control(
			'post_category',
			[ 
				'label' => esc_html__( 'Post By Category', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_categories(),
				'description' => esc_html__( 'Posts of selected categories will be displayed in the slider', 'unlock-addons-for-elementor' )
			]
		);

		// Tag
		$this->add_control(
			'post_tag',
			[ 
				'label' => esc_html__( 'Post By Tag', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_tags(),
				'description' => esc_html__( 'Posts of selected Tag will be displayed in the slider', 'unlock-addons-for-elementor' )
			]
		);

		// Author
		$this->add_control(
			'post_author',
			[ 
				'label' => esc_html__( 'Post By Author', 'unlock-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_author(),
				'description' => esc_html__( 'Posts of selected Author will be displayed in the slider', 'unlock-addons-for-elementor' )
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

		// get query
		$the_query = $this->get_posts_query($settings);

		if ('layout-1' == $settings['layout_control']) :
?>
			<div class="unlockafe-grid lg-3 md-2">
				<?php
				while ($the_query->have_posts()) :
					$the_query->the_post();

					// exclude posts
					if (! empty($settings['exclude_post']) && in_array(get_the_ID(), $settings['exclude_post']))
						continue;

					$this->get_skin('blog/layout-1', $settings);

				endwhile;
				wp_reset_query();
				?>
			</div>

		<?php
		elseif ('layout-2' == $settings['layout_control']) :
		?>
			<div class="unlockafe-grid lg-3 md-2">
				<?php
				while ($the_query->have_posts()) :
					$the_query->the_post();

					// exclude posts
					if (! empty($settings['exclude_post']) && in_array(get_the_ID(), $settings['exclude_post']))
						continue;

					$this->get_skin('blog/layout-2', $settings);

				endwhile;
				wp_reset_query();
				?>
			</div>
		<?php
		elseif ('layout-3' == $settings['layout_control']) :
		?>
			<div class="unlockafe-grid lg-3 md-2">
				<?php
				while ($the_query->have_posts()) :
					$the_query->the_post();

					// exclude posts
					if (! empty($settings['exclude_post']) && in_array(get_the_ID(), $settings['exclude_post']))
						continue;

					$this->get_skin('blog/layout-3', $settings);

				endwhile;
				wp_reset_query();
				?>
			</div>

		<?php
		elseif ('layout-4' == $settings['layout_control']) :
		?>
			<div class="unlockafe-grid  md-2">
				<?php
				while ($the_query->have_posts()) :
					$the_query->the_post();

					// exclude posts
					if (! empty($settings['exclude_post']) && in_array(get_the_ID(), $settings['exclude_post']))
						continue;

					$this->get_skin('blog/layout-4', $settings);

				endwhile;
				wp_reset_query();
				?>
			</div>
<?php
		endif;
	}
}