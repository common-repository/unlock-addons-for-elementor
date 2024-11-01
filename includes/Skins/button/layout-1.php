<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>

<a class="common-design-btn ade-btn-global" <?php $this->print_render_attribute_string( 'link' ); $this->print_render_attribute_string( 'btn_id' ); ?>>
	<span class="btn-flip">
		<span data-text="<?php echo esc_html( $args['text'] ) ?>"><?php echo esc_html( $args['text'] ) ?></span>
	</span>
	<span
		class="ade_icon"><?php \Elementor\Icons_Manager::render_icon( $args['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
</a>