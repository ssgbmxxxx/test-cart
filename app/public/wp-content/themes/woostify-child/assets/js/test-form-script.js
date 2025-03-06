jQuery(document).ready(function ($) {
    // console.log("Ready");
    var $product_id = $('#product_info').data('id');
    // console.log("Product_id: " + $product_id)

    $('#addToCardButton').on('click', function (e) {
        e.preventDefault(); // 防止默认跳转

        var $lens_value = $('input[name="custom_attribute1"]').val();
        var $coat_value = $('input[name="custom_attribute2"]').val();
        console.log($lens_value);
        console.log($coat_value);
        //send ajax request
        console.log('准备发起 AJAX 请求');
        $.ajax({
            url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            action: "custom_add_to_cart_handler",
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: $product_id,
                quanty: 1,
                custom_attribute: [{
                    name: "Lens Type",
                    value: $lens_value,
                    price: 10
                }, {
                    name: "Coating",
                    value: $coat_value,
                    price: 30
                }]
            },
            success: function (response) {
                // 检查响应中是否有 fragments 对象
                if (response.fragments) {
                    // 更新购物车小部件内容
                    if (response.fragments['div.widget_shopping_cart_content']) {
                        $('div.widget_shopping_cart_content').html(response.fragments['div.widget_shopping_cart_content']);
                    }

                    // 更新购物车总价显示区域
                    if (response.fragments['div.woostify-header-total-price']) {
                        $('div.woostify-header-total-price').html(response.fragments['div.woostify-header-total-price']);
                    }

                    // 更新购物车商品数量显示
                    if (response.fragments['span.shop-cart-count']) {
                        $('span.shop-cart-count').html(response.fragments['span.shop-cart-count']);
                    }

                    // 更新侧边栏购物车内容
                    if (response.fragments['div.cart-sidebar-content']) {
                        $('div.cart-sidebar-content').html(response.fragments['div.cart-sidebar-content']);
                    }

                    // 更新通知区域
                    if (response.fragments.notices_html) {
                        // 假设通知显示在类名为 .woocommerce-notices-wrapper 的元素中
                        $('.woocommerce-notices-wrapper').html(response.fragments.notices_html);
                    }
                }
            },
            error: function (xhr, status, error) {
                alert('Error adding product to cart');
            },
            complete: function (xhr, status) {
                console.log('AJAX 请求已完成');
            }

        });
    });
});