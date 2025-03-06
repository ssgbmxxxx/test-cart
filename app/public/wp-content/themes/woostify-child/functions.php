<?php
// add_action('wp_enqueue_scripts', 'override_jquery_version');
// function override_jquery_version() {
//     wp_deregister_script('jquery');
//     wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4');
//     wp_enqueue_script('jquery');
// }
// 获取当前日期和时间，格式为 Y-m-d H:i:s（年-月-日 时:分:秒）
// $currentDate = date('Y-m-d H:i:s');
// $file_name = "fucntions.php";
// $message = "[" . $currentDate . "]". $file_name;

//显示所有错误信息
error_reporting(E_ALL);
// 将错误信息输出到屏幕
ini_set('display_errors', 1);


//不可直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 处理前端 AJAX 请求（针对已登录用户）
add_action('wp_ajax_custom_add_to_cart', 'custom_add_to_cart_handler');
// 处理前端 AJAX 请求（针对未登录用户）
add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_add_to_cart_handler');

function custom_add_to_cart_handler() {

    // 检查是否有自定义属性
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        // 获取商品 ID
        $product_id = intval($_POST['product_id']);
        //获取商品数量
        $quantity = intval($_POST['quantity']);

        // 获取自定义属性数据
        $custom_attribute = isset($_POST['custom_attribute']) ? $_POST['custom_attribute'] : array();

        // 初始化额外信息数组
        $cart_item_data = [];

        // 计算当前商品的总价
        // 检查是否有自定义属性
        if(! empty($custom_attribute) && is_array($custom_attribute)){
            $total_custom_price = 0;
            // 对自定义数据进行处理和清理
            $clean_custom_attr = array();
            foreach ($custom_attribute as $n => $attr_info) {
                $clean_custom_attr[$n] = array(
                    'name' => sanitize_text_field($attr_info['name']),
                    'value' => sanitize_text_field($attr_info['value']),
                    'price' => floatval($attr_info['price'])
                );
                // 计算自定义属性的总价
                $total_custom_price += floatval($attr_info['price']);
            }

            $cart_item_data['custom_attribute'] = $clean_custom_attr;
            $cart_item_data['total_custome_price'] = $total_custom_price;
            // 为每个商品项设置唯一的键，确保自定义属性被正确保存
            $cart_item_data['unique_key'] = md5(microtime(). rand());
        }

        // 使用 WooCommerce 函数将商品添加到购物车
        // $added = WC()->cart->add_to_cart($product_id,$quantity);
        $added = WC()->cart->add_to_cart($product_id, $quantity, 0, [], $cart_item_data);


        if ($added) {
            // 商品添加成功
            // 获取购物车数量和总价
            $cart_count = WC()->cart->get_cart_contents_count();

            // 更新购物车中商品的价格
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                if (isset($cart_item['total_custom_price'])) {
                    $product = $cart_item['data'];
                    $original_price = $product->get_price();
                    $new_price = $original_price + $cart_item['total_custom_price'];
                    $product->set_price($new_price);
                }
            }

            // 重新计算购物车总价
            WC()->cart->calculate_totals();
            $cart_total = WC()->cart->get_cart_total();
        
            // 获取购物车小部件 HTML 片段
            ob_start();//开启缓冲
            woocommerce_mini_cart();
            $mini_cart = ob_get_clean();//// 获取缓冲区的内容
            $fragments = apply_filters('woocommerce_add_to_cart_fragments', array(
                '.widget_shopping_cart_content' => $mini_cart
            ));


            // 返回成功响应
            wp_send_json_success(array(
                "message"=>"SUCCESS",
                "message_type"=>"success",
                "Cart Count"=>$cart_count,
                "Cart Total"=>$cart_total,
                "fragments"=>$fragments               
            ));
        } else {
            // 商品添加失败
            wp_send_json_error(array(
                'message' => '添加商品到购物车时出现问题，请稍后再试。',
                "message_type"=>"error"
            ));
        }
    } else {
        // 缺少必要参数
        wp_send_json_error(array(
            'message' => '缺少商品 ID 或数量参数。',
            "message_type"=>"error"
        ));
    }
    // 终止脚本执行
    // wp_die();
}

//当商品添加到购物车时保存自定义属性
// add_filter( 'woocommerce_add_cart_item_data', 'save_custom_product_attributes', 10, 2 );
// function save_custom_product_attributes( $cart_item_data, $product_id ) {
//     // Assuming $message is defined globally
//     if ( isset( $_POST['custom_attribute'] ) ) {
//         $cart_item_data['custom_attribute'] = sanitize_text_field( $_POST['custom_attribute'] );
//         $cart_item_data['unique_key'] = md5( microtime().rand() );
//     }
//     global $message;
//     error_log($message . "$cart_item_data: " . print_r($cart_item_data, true));

//     return $cart_item_data;
// }


// 在购物车中显示自定义属性和价格
add_filter( 'woocommerce_get_item_data', 'display_custom_product_attributes_in_cart', 10, 2 );
function display_custom_product_attributes_in_cart( $item_data, $cart_item ) {
    if ( isset( $cart_item['custom_attribute'] ) ) {
        foreach( $cart_item['custom_attribute'] as $attr ) {
            $item_data[] = array(
                'name' => $attr['name'].": ".$attr['value'],
                'value' => wc_price($attr['price']),
            );
        }
    }
    return $item_data;
}

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

