<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
//variables
$allowed_tags = $this->allowed_tags();
$h_tag        = $args['heading_tags'];
$permalink    = $this->get_render_attribute_string( 'name_link' );
$size         = 'full';
$size         = ( $args['image_thumb_size'] == 'custom' ) ? array_values( $args['image_thumb_custom_dimension'] ) : $args['image_thumb_size'];
?>
<div class="unlockafe-team-wrap">
	<div class="team-img ps-relative overflow-hide">

		<?php if ( isset( $args['image']['id'] ) && ! empty( $args['image']['id'] ) ) : ?>
			<?php echo wp_get_attachment_image( $args['image']['id'], $size, '', [ 'class' => 'w-100' ] ) ?>
		<?php elseif ( isset( $args['image']['url'] ) && empty( $args['image']['id'] ) ) : ?>
			<img class="wd-100" src="<?php echo esc_url( $args['image']['url'] ) ?>" alt="">
		<?php endif; ?>

		<div class="team-hover ps-absolute">
			<?php if ( $args['social_profiles'] ) : ?>
				<ul>
					<?php foreach ( $args['social_profiles'] as $i => $profile ) : ?>
						<?php
						if ( $profile['social_link']['url'] != '' ) {
							$this->add_link_attributes( 'social_link' . $i, $profile['social_link'] );
						}
						?>
						<li>
							<a <?php $this->print_render_attribute_string( 'social_link' . $i ); ?>>
							<?php \Elementor\Icons_Manager::render_icon( $profile['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>

	<div class="team-content">
		<?php
			$this->print_paragraph( $args['designation'], $allowed_tags );
			printf( 
				'<%1$s><a %3$s>%2$s</a></%1$s>',
				wp_kses( $h_tag, $allowed_tags ),
				wp_kses( $args['name'], $allowed_tags ),
				wp_kses( $permalink, true )
			);
		?>
	</div>
</div>