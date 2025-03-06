<?php
// 获取传递过来的商品信息
$product_name = isset($_GET['product_name']) ? sanitize_text_field($_GET['product_name']) : '';
$product_price = isset($_GET['product_price']) ? sanitize_text_field($_GET['product_price']) : '';
$currency_symbol = isset($_GET['currency_symbol']) ? sanitize_text_field($_GET['currency_symbol']) : '';
$product_id = isset($_GET['product_id']) ? sanitize_text_field($_GET['product_id']) : '';
$product_image = isset($_GET['product_image']) ? wp_get_attachment_url($_GET['product_image']) : '';
?>


<!-- 显示商品图片 -->
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div id="product_info" data-id="<?php echo $product_id; ?>"></div>
        <div>
            <h3 id="product-name"><?php echo $product_name; ?></h3>
            <p id="product-id"><?php echo $product_id; ?></h3>
        </div>
        <?php if (!empty($product_image)): ?>
            <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>" style="height:100px; width:100px">
        <?php endif; ?>
        <div id="cus_form" class="form">

            <input type="text" name="custom_attribute1" placeholder="输入自定义属性值">
            <label for="custom_attribute1">lens type 10$</label>


            <input type="text" name="custom_attribute2" placeholder="输入自定义属性值">
            <label for="custom_attribute2">coat 30$</label>

            <button name="add-to-cart" id="addToCardButton">加购</button>
        </div>
    </main>
</div>