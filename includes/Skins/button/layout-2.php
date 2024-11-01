<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>

<a class="common-design-btn-two ade-btn-global" <?php $this->print_render_attribute_string( 'link' ); $this->print_render_attribute_string( 'btn_id' ); ?>>
	<?php echo esc_html( $args['text'] ) ?>
	<div class="button-icon-wrap">
		<?php \Elementor\Icons_Manager::render_icon( $args['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'button-icon button-icon-one' ] ); ?>
		<?php \Elementor\Icons_Manager::render_icon( $args['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'button-icon button-icon-two' ] ); ?>
	</div>
</a>