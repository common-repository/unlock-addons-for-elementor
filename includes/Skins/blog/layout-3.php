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

<article class="unlockafe-blog-element-three">
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
				esc_url( $permalink )
			);
		endif;

		if ( $args['show_excerpt'] ) :
			$this->print_paragraph( wp_trim_words( $post_excerpt, $args['excerpt_length'], '...' ) );
		endif;
		?>
		<?php if ( $args['show_author'] == 'yes' || $args['show_date'] == 'yes' ) : ?>
			<div class="unlockafe-blog-meta">
				<?php if ( $args['show_author'] == 'yes' ) : ?>
					<div class="unlockafe-blog-meta-img">
						<?php
						$user_id     = get_the_author_meta( 'ID' );
						$author_name = get_the_author_meta( 'display_name', $user_id );
						$user_url    = get_author_posts_url( $user_id );

						// print markup
						echo get_avatar( $user_id );
						echo '<a class="meta-info" href="' . esc_url( $user_url ) . '">' . esc_html( $author_name ) . '</a>';
						?>
					</div>
				<?php endif; ?>

				<?php
				if ( $args['show_date'] == 'yes' ) :
					$post_date = get_the_date();
					$date_url  = get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) );
					// print markup
					echo '<a class="meta-info" href="' . esc_url( $date_url ) . '">' . esc_html($post_date) . '</a>';
				endif;
				?>
			</div>
		<?php endif; ?>
	</div>
</article>