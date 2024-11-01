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

<article class="unlockafe-blog-element-five">
	<div class="unlockafe-blog-img ps-relative overflow-hide">
		<?php
		$size = 'full';
		$size = ( $args['post_thumb_size'] == 'custom' ) ? array_values( $args['post_thumb_custom_dimension'] ) : $args['post_thumb_size'];
		echo get_the_post_thumbnail( '', $size, [ 'class' => 'ps-absolute top-section-0 left-section-0 wd-100 ht-100 object-cvr' ] );
		?>
	</div>
	<div class="unlockafe-blog-info ps-relative">
		<ul class="custom-ul">
			<?php
			// Loop through the meta order array
			foreach ( $meta_op as $meta_key ) {

				// Loop through the meta order array
				switch ( $meta_key ) {
					case 'date':
						$post_date = get_the_date();
						$date_url = get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) );
						echo '<li><a href="' . esc_url( $date_url ) . '">' . esc_html( $post_date ) . '</a></li>';
						break;
					case 'category':
						$categories = get_the_category( $post_id );
						echo '<li><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
						break;
					case 'author':
						$user_id = get_the_author_meta( 'ID' );
						$author_name = get_the_author_meta( 'display_name', $user_id );
						$user_url = get_author_posts_url( $user_id );
						echo '<li><a href="' . esc_url( $user_url ) . '">' . esc_html( $author_name ) . '</a></li>';
						break;
					case 'comment':
						$comments_number = get_comments_number( $post_id );

						$text = __( 'Comment', 'unlock-addons-for-elementor' );
						if ( $comments_number > 1 ) {
							$text = __( 'Comments', 'unlock-addons-for-elementor' );
						}

						echo '<li><a href="' . esc_url( get_comments_link() ) . '">' . esc_html( $comments_number ) . ' ' . esc_html( $text ) . '</a></li>';
						break;
				}
			}
			?>
		</ul>
		<?php
		if ( $args['show_title'] ) :
			printf(
				'<%1$s class="unlockafe-blog-title"><a href="%3$s">%2$s</a></%1$s>',
				wp_kses( $h_tag, $allowed_tags ),
				wp_kses( wp_trim_words( $post_title, $args['title_length'], '...' ), $allowed_tags ),
				esc_url( $permalink )
			);
		endif;
		?>

		<?php if ( $args['show_read_more'] == 'yes' ) : ?>
			<div class="unlockafe-blog-btn-wrap">
				<a class="blog-btn" href="<?php echo esc_url( $permalink ) ?>"
					target="<?php echo ( $_blank == 'yes' ) ? esc_attr( '_blank' ) : ''; ?>"><?php echo esc_html( $args['read_more_text'] ); ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
						<path
							d="M2.40373 0V1.25892H9.96946L0 11.7017L0.847314 12.5892L10.8168 2.14646V10.0714H12.0186V0H2.40373Z">
						</path>
					</svg>
				</a>
			</div>
		<?php endif; ?>
	</div>
</article>