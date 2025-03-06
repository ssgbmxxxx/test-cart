<?php

/*
 * Plugin Name:       Russpay
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Deals with payment gateway for Russpay.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Luan Di
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       russpay
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 */


//exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

//init russpay gateway
add_action('plugins_loaded', 'init_russpay_gateway');

function init_russpay_gateway()
{
    // check if woocommerce is active
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    class WC_Russpay_Gateway extends WC_Payment_Gateway
    {
        public $app_key;
        public $secret_key;
        // public $payment_methods;

        /**
         * Constructor for the gateway.
         */
        public function __construct()
        {
            $this->id = 'russpay';
            $this->icon = apply_filters('woocommerce_russpay_icon', plugins_url('assets/images/russpay_icon.jpg', __FILE__));
            $this->has_fields = false;
            $this->method_title = __('Russpay', 'russpay'); //__() 是WP提供的用于实现多语言支持的函数
            $this->method_description = __('Pay via Russpay', 'russpay');

            //先实现支付，后续再实现退款
            $this->supports = array(
                'products'
              );

            // 初始化表单字段
            $this->init_form_fields();

            // 加载设置
            $this->init_settings();

            // 读取设置
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->app_key = $this->get_option('app_key');
            $this->secret_key = $this->get_option('secret_key');
            // $this->payment_methods = $this->get_option('payment_methods');
            
            // 这个动作钩子保存上面的设置
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

        }

        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Enable/Disable', 'russpay'),
                    'type' => 'checkbox',
                    'label' => __('Enable Russpay Payment Gateway', 'russpay'),
                    'default' => 'no'
                ),
                'title' => array(
                    'title' => __('Title', 'russpay'),
                    'type' => 'text',
                    'description' => __('This controls the title which the user sees during checkout.', 'russpay'),
                    'default' => __('Russpay', 'russpay'),
                    'desc_tip' => true
                ),
                'description' => array(
                    'title' => __('Description', 'russpay'),
                    'type' => 'textarea',
                    'description' => __('This controls the description which the user sees during checkout.', 'russpay'),
                    'default' => __('Pay via Russpay', 'russpay'),
                    'desc_tip' => true
                ),
                'app_key' => array(
                    'title' => __('APP Key', 'russpay'),
                    'type' => 'text',
                    'description' => __('This is the API key provided by Russpay.', 'russpay'),
                    'default' => '',
                    'desc_tip' => true
                ),
                'secret_key' => array(
                    'title' => __('Secret Key', 'russpay'),
                    'type' => 'text',
                    'description' => __('This is the secret key provided by Russpay.', 'russpay'),
                    'default' => '',
                    'desc_tip' => true
                )
                // ,
                // 'payment_methods' => array(
                //     'title' => __('Payment Methods', 'russpay'),
                //     'type' => 'multiselect',
                //     'description' => __('This is the payment method provided by Russpay.', 'russpay'),
                //     'default' => '',
                //     'desc_tip' => true,
                //     'options' => array(
                //         'card_wallet' => __('Bank Card, E-wallet', 'russpay'),
                //         'sbp' => __('Sbp', 'russpay'),
                //         'sber' => __('Sber', 'russpay')
                //     )
                // )
            );
        }

        //handling payment and processing the order
        public function process_payment($order_id)
        {
            error_log(print_r([
                'payment_methods_config' => $this->settings['payment_methods'],
                'selected_method' => $_POST['russpay_method'] ?? 'none'
            ], true));
            // //get order info and update status
            // $order = wc_get_order($order_id);

            // $order->update_status('on-hold', __('Payment has been received', 'russpay'));
            // //update stock
            // if ($order) {
            //     foreach ($order->get_items() as $item) {
            //         if ($item instanceof WC_Order_Item_Product) {
            //             $product = $item->get_product();
            //             $qty = $item->get_quantity();
            //             wc_update_product_stock($product, $qty, 'decrease');
            //         }
            //     }
            // }

            // WC()->cart->empty_cart();
            // return array(
            //     'result' => 'success',
            //     'redirect' => $this->get_return_url($order)
            // );
        }
    }
}

//register russpay gateway to woocommerce
add_filter('woocommerce_payment_gateways', 'add_russpay_gateway');

function add_russpay_gateway($gateways)
{
    $gateways[] = 'WC_Russpay_Gateway';
    return $gateways;
}
