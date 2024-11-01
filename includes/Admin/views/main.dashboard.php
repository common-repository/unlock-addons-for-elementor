<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<hr class="wp-header-end" />
<div class="wrap">
	<div class="unlockafe_addons-admin">
		<noscript>
			<p class="unlockafe_addons-disabled-javascript-notice">
				<?php
				echo
					// translators: html tags
					esc_html__( 'To manage <strong><em>Unlockafe Addon</em></strong> Dashboard properly you need to <strong>Enable JavaScript</strong> in your browser or make sure you have installed updated browser in your device.', 'unlock-addons-for-elementor' );
				?>
			</p>
		</noscript>
		<div id="unlockafe_addon" class="unlockafe_addon">
			<!-- need to add a loader -->
		</div>
	</div>
</div>