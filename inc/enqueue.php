<?php

/**
 * Theme enqueue scripts and styles.
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
if (!function_exists('cross_scripts')) {
	function cross_scripts()
	{

		$theme_uri = get_template_directory_uri();
		// Custom JS
		wp_enqueue_script('cross_functions', $theme_uri . '/src/index.js', ['jquery'], time(), true);

		// wp_localize_script('cross_functions', 'localizedObject', [
		// 	'ajaxurl' => admin_url('admin-ajax.php'),
		// 	'nonce'   => wp_create_nonce('ajax_nonce'),
		// ]);


		if (is_checkout()) {
			wp_enqueue_script('checkout_script', get_template_directory_uri() . ('/src/add_quantity.js'), array(), false, true);
			$localize_script = array(
				'ajax_url' => admin_url('admin-ajax.php')
			);
			wp_localize_script('checkout_script', 'add_quantity', $localize_script);
		}

		// Custom css
		wp_enqueue_style('cross_style', $theme_uri . '/src/index.css', [], time());

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'cross_scripts',);

function load_ajax()
{
	if (!is_user_logged_in()) {
		add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');
	} else {
		add_action('wp_ajax_update_order_review', 'update_order_review');
	}
}
add_action('init', 'load_ajax');

add_action('wp_ajax_update_order_review', 'update_order_review');
add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');

function update_order_review()
{
	$values = array();
	parse_str($_POST['post_data'], $values);
	$cart = $values['cart'];
	foreach ($cart as $cart_key => $cart_value) {

		WC()->cart->set_quantity($cart_key, $cart_value['qty'],);
		WC()->cart->calculate_totals();
		woocommerce_cart_totals();
	}
	wp_die();
}
