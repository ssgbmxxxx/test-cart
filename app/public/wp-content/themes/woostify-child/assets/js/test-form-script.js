jQuery(document).ready(function ($) {
    console.log("Ready");
    var $product_id = $('#product-id');

    $('#addToCardButton').on('click', function (e) {
        e.preventDefault(); // 防止默认跳转

        // var $lens_value = $('input[name="custom_attribute1"]').val();
        // var $coat_value = $('input[name="custom_attribute2"]').val();
        // console.log($lens_value);
        // console.log($coat_value);
        //send ajax request
        console.log('准备发起 AJAX 请求');
        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            action:"custom_add_to_cart_handler",
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: $product_id,
                quanty: 1
                // ,
                // custom_attribute:{
                //     "Lens Type":{
                //         "value":$lens_value,
                //         "price":10
                //     },
                //     "Coating":{
                //         "value":$coat_value,
                //         "price":30
                //     }
                // }
            },
            success: function (response) {
                if (response.success) {
                    // $(document.body).trigger('added_to_cart', [
                    //     response.fragments, 
                    //     response.cart_hash, 
                    //     this
                    // ]);
                    alert('Product added to cart');
                    // 更新购物车显示
                    // updateCartDisplay();
                } else {
                    alert('Error adding product to cart');
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

    function updateCartDisplay() {
        // cartItemsList.empty();
        // cart.forEach(item => {
        //     const listItem = $('<li></li>');
        //     listItem.text(`${item.name} x ${item.quantity} - 总价: ${item.price * item.quantity} 元`);
        //     cartItemsList.append(listItem);
        // });
    }
});