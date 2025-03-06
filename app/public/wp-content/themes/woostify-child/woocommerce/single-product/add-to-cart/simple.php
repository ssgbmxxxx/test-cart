<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (! $product->is_purchasable()) {
	return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<?php
		do_action('woocommerce_before_add_to_cart_quantity');

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
				'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
				'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action('woocommerce_after_add_to_cart_quantity');
		?>

		<!-- <button type="submit" name="select-lens" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt">
		<?php echo esc_html__('Select Lenses', 'woostify-child'); ?></button> -->

		<a href="#" id="select-lens-button" data-product-name="<?php echo esc_attr($product->get_name()); ?>" data-product-price="<?php echo esc_attr($product->get_price()); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>" data-product-image = "<?php echo esc_attr($product->get_image_id()); ?>" data-currency-symbol = "<?php echo get_woocommerce_currency_symbol(); ?>" class="custom-select-lens-button button alt">
			<?php echo esc_html__('Select Lenses', 'woostify-child'); ?>
		</a>
		<script>
			jQuery(document).ready(function($) {
				// 移除默认的加购事件绑定
				// $('#select-lens-button').off('click'); 

				$('#select-lens-button').on('click', function(e) {
					e.preventDefault();
					var productName = $(this).data('product-name');
					var productPrice = $(this).data('product-price');
					var productId = $(this).data('product-id');
					var currencySymbol = $(this).data('currency-symbol');
					var productImage = $(this).data('product-image');
					// 构建跳转 URL 并携带参数
					var redirectUrl = '<?php 
										$select_lenses_page = get_posts(array(
											'post_type'   => 'page',
											'title'       => 'Test Form',
											'numberposts' => 1
										));
										if (!empty($select_lenses_page)) {
											echo get_permalink($select_lenses_page[0]->ID);
										}
									?>?product_name=' + encodeURIComponent(productName) + '&product_price=' + encodeURIComponent(productPrice) + '&product_id=' + encodeURIComponent(productId)+ '&product_image=' + encodeURIComponent(productImage) + '&currency_symbol=' + encodeURIComponent(currencySymbol);
					window.location.href = redirectUrl;
				});
			});
		</script>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>