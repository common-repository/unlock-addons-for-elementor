<?php

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
	$post_id      = get_the_ID();
	$permalink    = get_the_permalink();
	$post_title   = get_the_title();
	$allowed_tags = $this->allowed_tags();
	$h_tag        = $args['heading_tags'];
	$_blank       = $args['open_new_window'];
	$meta_op      = $args['meta_options'];
	$post_excerpt = get_the_excerpt( $post_id );
?>

<!-- Blog Design 1 -->
<article class="unlockafe-blog-wrap">
	<div class="unlockafe-blog-img ps-relative">
		<?php
			$size = 'full';
			$size = ( $args['post_thumb_size'] == 'custom' ) ? array_values( $args['post_thumb_custom_dimension'] ) : $args['post_thumb_size'];
			echo get_the_post_thumbnail( '', $size, [ 'class' => 'ps-absolute top-section-0 left-section-0 wd-100 ht-100 object-cvr' ] );
		?>
	</div>
	<div class="unlockafe-blog-info">
		<?php
			if ( $args['show_title'] ) :
				printf(
					'<%1$s class="unlockafe-blog-title"><a href="%3$s">%2$s</a></%1$s>',
					wp_kses( $h_tag, $allowed_tags ),
					wp_kses( wp_trim_words( $post_title, $args['title_length'], '...' ), $allowed_tags ),
					esc_url($permalink)
				);
			endif;

			if ( $args['show_excerpt'] ) :
				$this->print_paragraph( wp_trim_words( $post_excerpt, $args['excerpt_length'], '...' ) );
			endif;
		?>

		<?php if ( $args['show_read_more'] == 'yes' ) : ?>
			<a class="blog-btn" href="<?php echo esc_url( $permalink ) ?>"
				target="<?php echo ( $_blank == 'yes' ) ? esc_attr( '_blank' ) : ''; ?>"><?php echo esc_html( $args['read_more_text'] ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
					<path
						d="M2.40373 0V1.25892H9.96946L0 11.7017L0.847314 12.5892L10.8168 2.14646V10.0714H12.0186V0H2.40373Z">
					</path>
				</svg>
			</a>
		<?php endif; ?>
	</div>
</article><!-- End Blog Design 1 -->