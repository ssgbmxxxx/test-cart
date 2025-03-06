<?php

/*
plugin name: Russpay Gateway
description: A payment gateway for Russpay
version: 1.0
author: Luan Di
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add the gateway to WooCommerce
add_filter('woocommerce_payment_gateways', 'add_russpay_gw_gateway');
function add_russpay_gw_gateway($gateways)
{
    $gateways[] = 'WC_Russpay_gw_Gateway';
    return $gateways;
}

// Init Russpay Gateway
add_action('plugins_loaded', 'init_russpay_gw_gateway');

function init_russpay_gw_gateway()
{
    // Check if WooCommerce is active
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    class WC_Russpay_gw_Gateway extends WC_Payment_Gateway
    {

        /**
         * Constructor for the gateway.
         */
        public function __construct()
        {
            $this->id = 'russpay_gw';
            $this->icon = apply_filters('woocommerce_russpay_icon', plugins_url('assets/images/russpay_icon.jpg', __FILE__));
            $this->has_fields = false;
            $this->method_title = __('Russpay', 'russpay_gw');
            $this->method_description = __('Pay using Russpay', 'russpay_gw');

            // Supports
            $this->supports = array(
                'products'
            );

            // Init form fields
            $this->init_form_fields();

            // Load settings
            $this->init_settings();

            $this->enabled = $this->get_option('enabled');
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        }

        /**
         * Initialize form fields
         */
        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Enable/Disable', 'russpay_gw'),
                    'type' => 'checkbox',
                    'label' => __('Enable Russpay Gateway', 'russpay_gw'),
                    'default' => 'no'
                ),
                'title' => array(
                    'title' => __('Title', 'russpay_gw'),
                    'type' => 'text',
                    'description' => __('This controls the title which the user sees during checkout.', 'russpay_gw'),
                    'default' => __('Russpay Gateway', 'russpay_gw'),
                    'desc_tip' => true
                ),
                'description' => array(
                    'title' => __('Description', 'russpay_gw'),
                    'type' => 'textarea',
                    'description' => __('This controls the description which the user sees during checkout.', 'russpay_gw'),
                    'default' => __('Pay via Russpay Gateway', 'russpay_gw')
                )
            );
        }

        /**
         * Process the payment
         */
        public function process_payment($order_id)
        {
            // Process payment
            $order = wc_get_order($order_id);
            $order->update_status('completed');

            error_log(print_r([
                'payment_methods_config' => $this->settings['payment_methods'],
                'selected_method' => $_POST['russpay_method'] ?? 'none'
            ], true));
        }

    }
}

