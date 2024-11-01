<?php
if (!defined('ABSPATH')) {
    exit;
}

$h_tag = isset($args['slider_heading_tags']) ? $args['slider_heading_tags'] : 'h2';
$query_args = array(
    'post_type'      => 'product',
    'posts_per_page' => isset($args['unlockafe_product_show_length']) ? $args['unlockafe_product_show_length'] : -1,
    'post_status'    => 'publish',
    'orderby'        => isset($args['post_source']) ? $args['post_source'] : 'date',
    'order'          => isset($args['order']) ? $args['order'] : 'DESC',
);

if (!empty($args['selected_products'])) {
    $query_args['post__in'] = $args['selected_products'];

}
$posts = get_posts($query_args);

if (!empty($posts)) : ?>
    <div class="unlockafe-container" style="margin-top: 100px; margin-bottom: 100px">
    <div class="unlockafe-product-slide-wrap" data-product-count="<?php echo esc_attr($args['product_count']); ?>">
            <div class="swiper unlockafe-product-slide">
                <div class="swiper-wrapper">
                    <?php foreach ($posts as $post) :
                        setup_postdata($post);
                        $post_id = $post->ID;
                        $post_link = get_permalink($post_id);
                        $post_thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
                        $product = wc_get_product($post_id);
                        $stock_status = $product->is_in_stock() ? 'In Stock' : 'Out of Stock';
                        $add_to_cart_url = $product->is_in_stock() ? $product->add_to_cart_url() : '#';
                        $add_to_cart_text = $product->is_in_stock() ? $product->add_to_cart_text() : 'Out of Stock';
                        $gallery_image_ids = $product->get_gallery_image_ids();
                        $gallery_images = [];

                        if (!empty($gallery_image_ids)) {
                            foreach ($gallery_image_ids as $gallery_image_id) {
                                $gallery_images[] = wp_get_attachment_url($gallery_image_id);
                            }
                        }
                    ?>
                        <div class="swiper-slide product-slide">
                            <div class="product-wrapper">
                                <div class="thumbnail-wrapper">
                                    <?php if ($args['unlockafe_product_carousel_image_clickable'] === 'yes') : ?>
                                        <a href="<?php echo esc_url($post_link); ?>" class="wd-100">
                                        <?php endif; ?>
                                        <figure class="has-back-image">
                                            <?php if (!empty($gallery_images)) : ?>
                                                <img class="wd-100" src="<?php echo esc_url($gallery_images[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                <?php if (isset($gallery_images[1])) : ?>
                                                    <img class="wd-100" src="<?php echo esc_url($gallery_images[1]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <img class="wd-100" src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                <img class="wd-100" src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                            <?php endif; ?>
                                        </figure>
                                        <?php if ($args['unlockafe_product_carousel_image_clickable'] === 'yes') : ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="product-label on-thumbnail">
                                        <?php if ($product->is_on_sale() && $args['unlockafe_product_carousel_show_sale'] === 'yes') : ?>
                                            <span class="onsale"><?php esc_html_e('Sale', 'unlock-addons-for-elementor'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    
                                </div>
                                <?php if ( $product->is_in_stock() ) { ?>
                                <?php if ($args['unlockafe_product_carousel_show_add_to_cart'] === 'yes') : ?>
                                        <div class="add-to-cart-2">
                                            <a href="<?php echo esc_url($add_to_cart_url); ?>"
                                            class="button add_to_cart_button ajax_add_to_cart"
                                            data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                            data-quantity="1"
                                            aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>"
                                            rel="nofollow">
                                            <img src='<?php echo esc_url( UNLOCKAFE_ASSETS . 'images/cart-plus-fill.svg'); ?>' alt="<?php echo esc_attr('Add to Cart'); ?>" class="add-to-cart-icon">
                                            </a>
                                            
                                        </div>

                                <!-- <div class="add-to-cart-2">
                                    <a href="<?php //echo esc_url($add_to_cart_url); ?>" class="button btn-add-to-cart"><?php //echo esc_html($add_to_cart_text); ?></a>
                                </div> -->
                                <?php endif; ?>
                                <?php } ?>
                                <div class="meta-wrapper">
                                    <?php if ($args['show_slider_title'] === 'yes') :
                                    if($args['unlockafe_product_carousel_title_clickable']==='yes'){
                                        printf(
                                            '<%1$s><a style="text-decoration:none;" href="%3$s">%2$s</a></%1$s>',
                                            esc_html($h_tag),
                                            esc_html(get_the_title($post_id)),
                                            esc_url($post_link)
                                        );
                                     }else{printf('<%1$s>%2$s</%1$s>',
                                            esc_html($h_tag),
                                            esc_html(get_the_title($post_id)),
                                        );
                                     }

                                    endif; ?>

                                    <?php if ($args['unlockafe_product_carousel_price'] === 'yes') : ?>
                                        <div class="unlockafe-product-price">
                                        <?php echo $product ? wp_kses_post($product->get_price_html()) : ""; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($args['unlockafe_product_carousel_excerpt'] === 'yes') : ?>
                                        <div class="excerpt short_description">
                                        <?php 
                                            $excerpt = wp_trim_words(get_the_excerpt($post_id), $args['unlockafe_product_carousel_excerpt_length'], esc_html($args['unlockafe_product_carousel_excerpt_expanison_indicator']));
                                            echo esc_html($excerpt); 
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="unlockafe-product-button-prev slide-btn slide-btn-prev">
            <img src='<?php echo esc_url(UNLOCKAFE_ASSETS . "images/iconmonstr-arrow-left-circle-thin.svg"); ?>' alt="previous" class="icon_size">
            </div>
            <div class="unlockafe-product-button-next slide-btn slide-btn-next ms-3">
            <img src='<?php echo esc_url(UNLOCKAFE_ASSETS . 'images/iconmonstr-arrow-right-circle-thin.svg'); ?>' alt="next" class="icon_size">
            </div>
        </div>
    </div>

<?php else : ?>
    <p class="unlockafe-align-center"><?php echo esc_html($args['unlockafe_product_carousel_not_found_msg']); ?></p>
<?php endif;
wp_reset_postdata(); ?>