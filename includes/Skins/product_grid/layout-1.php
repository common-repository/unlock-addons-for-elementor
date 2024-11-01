<?php
if (!defined('ABSPATH')) {
    exit;
}

$product_id = get_the_ID();
$product    = wc_get_product( $product_id );

$ade_product_container=esc_attr($args['product_in_a_row']);

?>
<body>
	<!-- Product Start -->
	<div class="product prodict-<?php echo esc_attr($ade_product_container); ?> product-sm-<?php echo esc_attr($ade_product_container); ?> product-md-<?php echo esc_attr($ade_product_container); ?> product-lg-<?php echo esc_attr($ade_product_container); ?> product-xl-<?php echo esc_attr($ade_product_container); ?>">
	<div class="product-wrapper">
			<div class="product-inner">
				<!-- thumbnail-wrapper -->
				<div class="thumbnail-wrapper">
					<div class="thumbnail-badges">
						<?php 
						if ( 'yes' === $args['show_badge'] ){						
						if($product->is_on_sale()){ 
							$regular_price = (float) $product->get_regular_price();
							$sale_price = (float) $product->get_sale_price(); if($regular_price>$sale_price){?>
						<span class="badge sale"><?php 
							if ( $regular_price && $sale_price ) {
								$discount_percentage = esc_attr(round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ));
								echo esc_html($discount_percentage) . '%';
							}

								}
							}
						}
						?></span>
					</div>
					
					<?php $image_clickable = isset($args['image_clickable']) ? $args['image_clickable'] : 'yes';
						if ('yes' === $image_clickable) {
							echo '<a href="' . esc_url( get_the_permalink( $product_id ) ) . '" class="product-thumbnail">';
						} else {
								echo '<div class="product-thumbnail">';
							}
						?>
						<div class="product-main-image">
							<?php
							$image_size = isset($args['image_size']) ? $args['image_size'] : 'full';
							// Product Image
							if ( has_post_thumbnail() ) {
								echo get_the_post_thumbnail( $product_id ,$image_size);
							}
							?>
						</div>
						<div class="product-thumbnail-gallery">
							<?php
							// Product Gallery
							if ( 'yes' === $args['show_gallery'] ) :
							$gallery_image_ids = $product->get_gallery_image_ids();
							if ( ! empty( $gallery_image_ids ) ) {
								foreach ( $gallery_image_ids as $image_id ) { ?>
									<div class="gallery-item gallery-image">
										<?php
										// Display the image with wp_get_attachment_image()
										echo wp_get_attachment_image($image_id, $image_size, false, array('alt' => 'Product Image')); ?>
									</div>
								<?php }
							} endif; ?>

						</div>
						<?php if ( 'yes' === $args['show_gallery'] ) :?>
						<div class="hover-gallery-dots"></div>
						<?php endif;?>
						<?php
							if ('yes' === $image_clickable) {
								echo '</a>';
							} else {
								echo '</div>';
							}?>
				</div>
				<!-- content-wrapper -->
				<div class="content-wrapper">
					<div class="product-title">
					<a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>" class="title-style">
					<<?php echo esc_attr($args['title_tag']); ?>><?php echo esc_html( get_the_title( $product_id ) ); ?></<?php echo esc_attr($args['title_tag']); ?>>
					</a>
						</div>
					<div class="product-rating">
						<?php
						if ( 'yes' ===$args['show_reviews'] ) :
						if ( $product->get_average_rating() ) {
							echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) );
						} else {
							echo wp_kses_post( wc_get_rating_html( 0 ) );
						} ?>
						<span class="rating-count">
							<?php
							if ( $product->get_average_rating() != 0 ) {
								echo '<b>' . esc_html( $product->get_average_rating() ) . '</b>';
								echo '<b>(' . esc_html( $product->get_review_count() ) . ')</b>';
							} endif; ?>
						</span>
					</div>
					<div class="product-cart-wrapper">
						<div class="pricing">
							<?php if ( 'yes' === $args['all_price'] ) :?>
							<div class="amount">
								<span class="price">
									<?php
									if ( 'yes' === $args['show_sale_price'] ) :
									if ( $product->get_sale_price() ) {
										echo '<span class="sale_price">' . wp_kses_post( wc_price( $product->get_sale_price(), array( 'html' => false ) ) ) . '</span>';
									} endif;
									?>
								</span>&nbsp;
								<span class="price">
									<?php 
									if ( 'yes' === $args['show_regular_price'] ) :
										if ( $product->get_regular_price() ) {
											if ( $product->get_sale_price() ) {
												echo '<span class="regular_price_line_through">' . esc_html( wp_strip_all_tags( wc_price( $product->get_regular_price() ) ) ) . '</span>';
											}else{
												if ( $product->is_on_sale() ) {
													echo '<span class="sale_price">' . esc_html( wc_price( $product->get_regular_price(), array( 'html' => false ) ) ) . '</span>';
												}										
										}} 
									endif; 
									?>

								</span>
								<?php
								if ( $product->is_type( 'variable' ) ) {
									if ( 'yes' === $args['show_variable_price'] ) :
										// Get the price range
										$min_price = $product->get_variation_price( 'min', true );
										$max_price = $product->get_variation_price( 'max', true );

								
										// Display price range
										if ( $min_price !== $max_price ) {
											?> 
											<span class="variable_price">
												<?php 
											echo '<span class="variable_price">'.wp_kses_post( wc_price( $min_price ) ). ' - ' . wp_kses_post( wc_price( $max_price ) ) . '</span>';												
												?>
											</span>
											<?php
										} else {
											echo '<span class="variable_price">' . wp_kses_post( wc_price( $min_price ) ) . '</span>';
										}
									endif;
								}
								?>
							</div>
							<?php endif;?>
						</div>
						<?php if ( $product->is_in_stock() ) { ?>
							<?php if ( 'yes' === $args['show_add_to_cart'] ) :?>
							<div class="product-cart-buttons">
								<a href="?add-to-cart=<?php echo esc_html($product_id); ?>" 
								class="add_to_cart_button ajax_add_to_cart" 
								data-product_id="<?php echo esc_html($product_id); ?>" 
								aria-label="Add to cart" 
								rel="nofollow">
								<img src="<?php echo esc_url(UNLOCKAFE_ASSETS . 'images/cart-plus-fill.svg'); ?>" alt="<?php echo esc_attr('Add to Cart'); ?>" class="add-to-cart-icon">
								</a>
								<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="added_to_cart hidden">
								<img src='<?php echo esc_url(UNLOCKAFE_ASSETS . 'images/check-circle-fill.svg'); ?>' alt="<?php echo esc_attr('Added to Cart');?>" class="add-to-cart-icon">
								</a>
							</div>

						<?php endif; } ?>
					</div>
					<div class="product-inventory in-stock">
						<?php
						if ( 'yes' === $args['show_in_stock'] ) :
						if ( $product->is_in_stock() ) {
							echo "In stock";
						} else {
							echo '<span class="out_of_stock_color">'."Out of stock".'</span>';
						}endif;?>
					</div>
				</div>
				<!-- product-footer -->
				 <?php if ( 'yes' === $args['show_description'] ) :?>
				<div class="product-footer">
					<div class="product-footer-details">
						<ul class="a-unordered-list">
							<li class="product-footer-list">
								<?php
				$this->print_paragraph(esc_html( wp_trim_words(get_the_excerpt(get_the_ID()), $args['description_length'], '...' )) );?>
							</li>
						</ul>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="product-content-fade"></div>
	</div>
</body>