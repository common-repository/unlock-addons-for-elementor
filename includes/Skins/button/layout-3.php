<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<a class="blog-btn ade-btn-global" <?php $this->print_render_attribute_string( 'link' );
$this->print_render_attribute_string( 'btn_id' ); ?>>
	<?php echo esc_html( $args['text'] ) ?>
	<?php \Elementor\Icons_Manager::render_icon( $args['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
</a>