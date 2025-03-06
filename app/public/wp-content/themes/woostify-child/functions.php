<?php
// add_action('wp_enqueue_scripts', 'override_jquery_version');
// function override_jquery_version() {
//     wp_deregister_script('jquery');
//     wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4');
//     wp_enqueue_script('jquery');
// }

// 显示所有错误信息
// error_reporting(E_ALL);
// // 将错误信息输出到屏幕
// ini_set('display_errors', 1);

// 确保在 WordPress 环境中
if (!defined('ABSPATH')) {
    exit;
}

// 处理前端 AJAX 请求（针对已登录用户）
add_action('wp_ajax_custom_add_to_cart', 'custom_add_to_cart_handler');
// 处理前端 AJAX 请求（针对未登录用户）
add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_add_to_cart_handler');

function custom_add_to_cart_handler() {
    //检查是否有商品 ID 和数量
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);}

        // 获取自定义属性数据
        // $custom_attribute = isset($_POST['custom_attribute']) ? $_POST['custom_attribute'] : array();

        // 初始化额外数据数组
        // $cart_item_data = [];

        // 检查是否有自定义属性
        // if ( ! empty($custom_attribute) && is_array($custom_attribute)) {
        //     // 对自定义数据进行处理和清理
        //     $clean_custom_attr = array();
        //     foreach ($custom_attribute as $key => $attr) {
        //         $clean_custom_attr[$key] = array(
        //             'value' => sanitize_text_field($attr['value']),
        //             'price' => floatval($attr['price'])
        //         );
        //     }

            // $cart_item_data['custom_attribute'] = $clean_custom_attr;
            // 为每个商品项设置唯一的键，确保自定义属性被正确保存
            // $cart_item_data['unique_key'] = md5(microtime(). rand());
        // }

        // 使用 WooCommerce 函数将商品添加到购物车
        $added = WC()->cart->add_to_cart($product_id,$quantity);
        // $added = WC()->cart->add_to_cart($product_id, $quantity, 0, [], $cart_item_data);

    //     if ($added) {
    //         // 商品添加成功
    //         wp_send_json_success(array(
    //             'message' => '商品已成功添加到购物车。',
    //             'cart_count' => WC()->cart->get_cart_contents_count()
    //         ));
    //     } else {
    //         // 商品添加失败
    //         wp_send_json_error(array(
    //             'message' => '添加商品到购物车时出现问题，请稍后再试。'
    //         ));
    //     }
    // } else {
    //     // 缺少必要参数
    //     wp_send_json_error(array(
    //         'message' => '缺少商品 ID 或数量参数。'
    //     ));
    // }

    // 终止脚本执行
    wp_die();
}

// 当商品添加到购物车时保存自定义属性
// add_filter( 'woocommerce_add_cart_item_data', 'save_custom_product_attributes', 10, 2 );
// function save_custom_product_attributes( $cart_item_data, $product_id ) {
//     // 假设自定义属性在表单中以 'custom_attribute' 字段提交
//     if ( isset( $_POST['custom_attribute'] ) ) {
//         $cart_item_data['custom_attribute'] = sanitize_text_field( $_POST['custom_attribute'] );
//         // 为每个商品项设置唯一的键，确保自定义属性被正确保存
//         $cart_item_data['unique_key'] = md5( microtime().rand() );
//     }
//     return $cart_item_data;
// }


// 在购物车中显示自定义属性
// add_filter( 'woocommerce_get_item_data', 'display_custom_product_attributes_in_cart', 10, 2 );
// function display_custom_product_attributes_in_cart( $item_data, $cart_item ) {
//     if ( isset( $cart_item['custom_attribute'] ) ) {
//         foreach ( $cart_item['custom_attribute'] as $attribute_name => $attribute_data ) {
//             $item_data[] = array(
//                 'name' => $attribute_name,
//                 'value' => $attribute_data['value']. ' (+$' . esc_html($attribute_data['price']) . ')',
//             );
//         }
//     }
//     return $item_data;
// }

// 更新购物车项的价格
// add_action( 'woocommerce_before_calculate_totals', 'update_cart_item_price', 10, 1 );
// function update_cart_item_price( $cart ) {
//     if ( is_admin() &&! defined( 'DOING_AJAX' ) ) {
//         return;
//     }

//     foreach ( $cart->get_cart() as $cart_item ) {
//         if ( isset( $cart_item['custom_attribute'] ) ) {
//             $base_price = $cart_item['data']->get_price();
//             $extra_price = 0;
//             // 加所有自定义属性的价格到额外价格中
//             foreach ( $cart_item['custom_attribute'] as $attribute_data ) {
//                 $extra_price += $attribute_data['price'];
//             }
//             $new_price = $base_price + $extra_price;
//             $cart_item['data']->set_price( $new_price );
//         }
//     }
// }

// wp_localize_script('test-form-script', 'my_ajax_object', array(
//     'ajax_url' => admin_url('admin-ajax.php')
// ));

