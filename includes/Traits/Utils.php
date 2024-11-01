<?php

namespace Unlockafe_addons\Traits;

if (! defined('ABSPATH'))
	exit; // Exit if accessed directly

trait Utils
{


	/**
	 ********
	 * get_post return the array of post
	 * 
	 * @since 1.0.0
	 * @param string $post_type
	 * @return array
	 */
	public function get_posts(string $post_type = 'post')
	{

		/// post arguments
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
		);

		$posts_query = new \WP_Query($args);
		$posts       = [];

		if ($posts_query->have_posts()) {
			while ($posts_query->have_posts()) {
				$posts_query->the_post();
				// assign post to the $array
				$posts[get_the_ID()] = get_the_title();
			}
			wp_reset_postdata();
		}

		return $posts;
	}

	/**
	 ********
	 * get_categories return the array of Cat Taxonomy 
	 * 
	 * @since 1.0.0
	 * @return array
	 */
	public function get_categories()
	{
		$categories = get_categories();
		$cat        = [];
		foreach ($categories as $item) {
			$cat[$item->term_id] = $item->name;
		}

		return $cat;
	}

	/**
	 ********
	 * get_tags return the array of tag Taxonomy 
	 * 
	 * @since 1.0.0
	 * @return array
	 */
	public function get_tags()
	{
		$tags = get_tags();
		$tag  = [];
		foreach ($tags as $item) {
			$tag[$item->term_id] = $item->name;
		}

		return $tag;
	}

	/**
	 ********
	 * get_author return the array of authors
	 * 
	 * @since 1.0.0
	 * @return array
	 */
	public function get_author()
	{
		$authors = get_users();
		$author  = [];
		foreach ($authors as $item) {
			$author[$item->ID] = $item->user_nicename;
		}

		return $author;
	}

	/**
	 *  Return Allowd HTML function.
	 * 
	 * @since 1.0.0
	 * @return array
	 */
	public function allowed_tags()
	{

		$allowed_tags = [
			'a' => [
				'class' => [],
				'href' => [],
				'rel' => [],
				'title' => [],
				'target' => [],
			],
			'abbr' => [
				'title' => [],
			],
			'b' => [],
			'blockquote' => [
				'cite' => [],
			],
			'cite' => [
				'title' => [],
			],
			'code' => [],
			'del' => [
				'datetime' => [],
				'title' => [],
			],
			'dd' => [],
			'div' => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'dl' => [],
			'dt' => [],
			'em' => [],
			'h1' => [],
			'h2' => [],
			'h3' => [],
			'h4' => [],
			'h5' => [],
			'h6' => [],
			'sub' => [],
			'i' => [
				'class' => [],
			],
			'img' => [
				'alt' => [],
				'class' => [],
				'height' => [],
				'src' => [],
				'width' => [],
			],
			'li' => [
				'class' => [],
			],
			'ol' => [
				'class' => [],
			],
			'p' => [
				'class' => [],
			],
			'q' => [
				'cite' => [],
				'title' => [],
			],
			'span' => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'iframe' => [
				'width' => [],
				'height' => [],
				'scrolling' => [],
				'frameborder' => [],
				'allow' => [],
				'src' => [],
			],
			'strike' => [],
			'br' => [],
			'strong' => [],
			'ul' => [
				'class' => [],
			],
		];


		return $allowed_tags;
	}


	/**
	 * Summary of get_hero_posts_query
	 * 
	 * This will return an Query object based on peramiter
	 * 
	 * @param mixed $settings
	 * @param int $page
	 * @param string $post_type
	 * @return \WP_Query
	 */
	public function get_posts_query($settings, int $page = 1, string $post_type = 'post'): \WP_Query
	{
		// Query posts without using tax_query
		$args = [
			'posts_per_page' => $settings['post_per_page'] ?? 10,
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'post_type'      => $post_type,
			'paged'          => $page,
		];
	
		// Add ordering if post_source is set
		if (!empty($settings['post_source'])) {
			$args['orderby'] = $settings['post_source'];
		}
	
		// Add specific posts to include, if set
		if (!empty($settings['include_post'])) {
			$args['post__in'] = $settings['include_post'];
		}
	
		// Add specific authors to include, if set
		if (!empty($settings['post_author'])) {
			$args['author__in'] = $settings['post_author'];
		}
	
		$the_query = new \WP_Query($args);
	
		// Now, programmatically filter posts by taxonomies
		if (!empty($settings['post_category']) || !empty($settings['post_tag'])) {
			$filtered_posts = [];
	
			while ($the_query->have_posts()) {
				$the_query->the_post();
				$post_id = get_the_ID();
	
				// Check if the post has the required categories or tags
				$has_required_taxonomies = true;
	
				if (!empty($settings['post_category'])) {
					$has_required_taxonomies = has_term($settings['post_category'], 'category', $post_id);
				}
	
				if ($has_required_taxonomies && !empty($settings['post_tag'])) {
					$has_required_taxonomies = has_term($settings['post_tag'], 'post_tag', $post_id);
				}
	
				if ($has_required_taxonomies) {
					$filtered_posts[] = $post_id;
				}
			}
	
			// Reset the post data after the loop
			wp_reset_postdata();
	
			// Return a new WP_Query object with the filtered post IDs
			$filtered_args = [
				'post__in' => $filtered_posts,
				'posts_per_page' => $settings['post_per_page'],
			];
	
			return new \WP_Query($filtered_args);
		}
	
		return $the_query;
	}

	public function unlockafe_combine_widgets($arr1 = [], $arr2 = [])
	{
		return array_replace_recursive($arr1, $arr2);
	}
	protected function filter_widgets()
	{
		// minimise array
		$new_widgets = [];
		$to_unset    = ['css', 'js'];

		// creating new array
		foreach ($this->registered_widgets as $k => $v) {
			$v['id'] = $k;

			if (isset($v['type']) && ! empty($v['type'])) {
				$v['type'] = $v['type'] == 'pro' ? true : false;
			}
			$new_widgets[] = array_diff_key($v, array_flip($to_unset));
		}
		$this->new_widgets = $new_widgets;
		return $new_widgets;
	}

	/**
	 * Summary of get_skin
	 * 
	 * Locate the templates of widget
	 * 
	 * @param mixed $path
	 * @param mixed $args
	 * @return void
	 */
	public function get_skin($path, $args = [])
	{
		$real_path = UNLOCKAFE_INCLUDE_PATH . 'Skins/' . $path . '.php';
		if (file_exists($real_path)) {
			include $real_path;
		}
	}
}