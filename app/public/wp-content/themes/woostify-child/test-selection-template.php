<?php
/*
Template Name: test-form
*/
get_header();

// 引入 HTML 内容
include(get_stylesheet_directory() . '/templates/test-form.php');

// 引入 CSS 文件
wp_enqueue_style('test-form-style', get_stylesheet_directory_uri() . '/assets/css/test-form-style.css');


// 引入 JavaScript 文件
wp_enqueue_script('test-form-script', get_stylesheet_directory_uri() . '/assets/js/test-form-script.js', array('jquery'), '1.0', true);
// function enqueue_custom_scripts() {
//     // 确保 jQuery 被加载
//     wp_enqueue_script('jquery');
//     // 加载自定义的 JavaScript 文件
//     wp_enqueue_script(
//         'custom-script',
//         get_stylesheet_directory_uri() . '/assets/js/test-form-script.js',
//         array('jquery'),
//         '1.0',
//         true
//     );
// }
// add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


get_footer();
?>