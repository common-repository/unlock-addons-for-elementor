<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
// $title = ;
$allowed_tags = $this->allowed_tags();
$h_tag        = $args['heading_tags'];
$link         = $this->get_render_attribute_string( 'link' );
?>
<div class="unlockafe-grid lg-3 md-2">
	<div class="unlockafe-pie-chart-wrap">
		<div class="unlockafe-pie-chart" data-percent="75">
			<div class="unlockafe-pie-chart-media">
				<svg viewBox="0 0 32 32" class="unlockafe-pie-chart-svg">
					<circle class="background" cx="16" cy="16" r="14"></circle>
					<circle class="foreground" cx="16" cy="16" r="14"></circle>
				</svg>
				<?php if ( ! empty( $args['progress'] ) ) : ?>
					<span class="unlockafe-pie-chart-count"><?php echo intval( $args['progress'] ); ?>%</span>
				<?php endif; ?>
			</div>
		</div>
		<?php
		if ( ! empty( $args['title'] ) ) :
			printf( 
				'<%1$s class="unlockafe-pie-chart-title"><a href="%3$s">%2$s</a></%1$s>',
				wp_kses( $h_tag, $allowed_tags ),
				wp_kses( $args['title'], $allowed_tags ),
				wp_kses( $link, true )
			);
		endif;
		$this->print_paragraph( $args['description'] );
		?>
	</div>
	</d>