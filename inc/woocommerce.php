<?php

/**
 * Add WooCommerce support
 *
 * @package Understrap
 */
// Exit if accessed directly.
defined('ABSPATH') || exit;
add_action('after_setup_theme', 'cross_woocommerce_support');
if (!function_exists('cross_woocommerce_support')) {
  /**
   * Declares WooCommerce theme support.
   */
  function cross_woocommerce_support()
  {
    add_theme_support('woocommerce');
    // Add Product Gallery support.
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-slider');
  }
}

function header_add_to_cart_fragment($fragments)
{
  global $woocommerce;
  ob_start();
?>
  <div class="header__menu-shop_count"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></div>
<?php
  $fragments[".header__menu-shop_count"] = ob_get_clean();
  return $fragments;
}
add_filter("woocommerce_add_to_cart_fragments", "header_add_to_cart_fragment");


function custom_modify_add_to_cart_link($link, $product)
{
  // Modify the text of the add to cart button
  $link_text = 'buy';

  // Modify any additional attributes
  $link_attributes = 'class="my-custom-class" data-custom-attribute="value"';
  // Replace the existing link text and attributes with the modified values
  $link = str_replace('Add to cart', $link_text, $link);
  // $link = str_replace('href', $link_attributes . ' href', $link);

  return $link;
}

add_filter('woocommerce_loop_add_to_cart_link', 'custom_modify_add_to_cart_link', 10, 2);

//woocommerce_before_shop_loop_item
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
// remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

//woocommerce_before_shop_loop_item_title
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

//woocommerce_after_shop_loop_item_title
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

//woocommerce_after_shop_loop_item
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10);


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_custom_product_thumbnail', 10);


// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' , 10);
// $add = add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' , 10);

function woocommerce_template_loop_custom_product_thumbnail($permalink = null)
{
  global $product;
  $link_to_product = $permalink == true ? '<a href='  . get_permalink() . ' class="button button__primary">See</a>' : '';
  $image_product = get_the_post_thumbnail(get_the_ID(), 'prduct-image');
  $weight_quantity = !empty(get_field('weight_quantity')) ?  '<p class="product__description_weight-quantity">' . get_field('weight_quantity') . '</p>' : '';
  $link = get_the_permalink();
  $image_product = $product->get_image('prduct-image') ? $product->get_image('prduct-image') : 'nonon';
  $product_name = $product->get_name();
  $regular_price = $product->get_regular_price();
  $sale_price = $product->get_sale_price();
  $symbol = get_woocommerce_currency_symbol();
  $percentage = '';

  if ($product && $product->is_type('variable')) {
    $regular_price = $product->get_variation_regular_price(); // Min regular price
    $sale_price = $product->get_variation_sale_price(); // Min sale price
  }

  if ($regular_price && $sale_price) {
    $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
    $percentage_block = !empty($percentage) ? "<sapn class='percentage'>-{$percentage}%</sapn>" : '';
    $percentage_block_render = "<span class='belt__wrap_regular'>{$symbol}{$sale_price}</span>
    <span class='belt__wrap_sale'>{$symbol}{$regular_price}</span>";
  } else {
    $percentage_block_render = "<span class='belt__wrap_regular regular'>{$symbol}{$regular_price}</span>";
  }
  $new_days = 7;
  $post_date = $product->get_date_created();
  $days_diff = (current_time('timestamp') - strtotime($post_date->date_i18n())) / (60 * 60 * 24);
  $new_badge = '';
  if ($days_diff <= $new_days) {
    $new_badge =  '<span class="new-badge">New</span>';
  }

  echo "
  <div class='product-card'>
    <div class='product-card__image-wrap'>
      <a href='{$link}'>
        {$percentage_block}
        {$new_badge}
        {$image_product}
      </a>
    </div>
    <div class='product-card__description'>
      <a href='{$link}'><h6>{$product_name}</h6></a>
      {$weight_quantity}
    <div class='belt'>
      <div class='belt__wrap'>
       {$percentage_block_render}
      </div>
    {$link_to_product}
    </div>
  </div>";
}

//breadcrumbs
/**
 * Change several of the breadcrumb defaults
 */
add_filter('woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs');
function jk_woocommerce_breadcrumbs()
{
  return array(
    'delimiter'   => ' / ',
    'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
    'wrap_after'  => '</nav>',
    'before'      => '',
    'after'       => '',
    'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
  );
}


//SIngle [products]
//woocommerce_before_main_content
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

//woocommerce_sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

//Content single product
//woocommerce_before_single_product_summary
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 10);

//woocommerce_single_product_summary
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1);

// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_custom_rating', 9);

// add_action('woocommerce_before_single_product', 'check_type_of_product');
// function check_type_of_product()
// {
//   global $product;
//   // var_dump($product);
//   if( $product->get_type( ) === 'variable'){
//     remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
//   }

// }

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);


// Remove the Product SKU from Product Single Page
add_filter('wc_product_sku_enabled', 'woocustomizer_remove_product_sku');

function woocustomizer_remove_product_sku($sku)
{
  // Remove only if NOT admin and is product single page
  if (!is_admin() && is_product()) {
    return false;
  }

  return $sku;
}


function woocommerce_template_single_custom_rating()
{
  $weight_quantity = !empty(get_field('weight_quantity')) ?  '<p class="singl-product-quantity">' . get_field('weight_quantity') . '</p>' : '';
  echo $weight_quantity;
}

//woocommerce_after_single_product_summary
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products');

/**
 * Remove "On Sale" badge from WooCommerce single product page
 */
function remove_onsale_badge()
{
  remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
  // add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_custom_product_sale_flash', 10 );
  // function woocommerce_show_custom_product_sale_flash() {
  //   echo '<span class="new-badge">Sale!</span>';
  // }
}
add_action('init', 'remove_onsale_badge');



// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40);

/**
 * Remove product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs');

function woo_remove_product_tabs($tabs)
{
  unset($tabs['description']);
  unset($tabs['reviews']);       // Remove the reviews tab
  unset($tabs['additional_information']);    // Remove the additional information tab

  return $tabs;
}

add_action('woocommerce_after_single_product_summary', 'group', 98);
function group()
{
  echo '<style>.group:before {
    content: "";
    display: table;
    clear: both;
  }</style><div class="group">' . apply_filters('the_content', get_the_content()) . '</div>';
}



function custom_cart_button_Shop_Page($text, $product)
{
  if ($product->is_type('variable')) {
    $text = __('Buy', 'woocommerce');
  }
  return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'custom_cart_button_Shop_Page', 9, 2);




add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
  return __('Buy', 'woocommerce');
}
// put this in functions.php, it will produce code before the form
// add_action('woocommerce_review_order_before_payment', 'show_cart_summary', 9);

// // gets the cart template and outputs it before the form
// function show_cart_summary()
// {
//   wc_get_template_part('cart/cart');
//   // var_dump(wc_get_template_part());
//   wc_get_template_part('cart/cart-totals');
// }


add_action('woocommerce_before_quantity_input_field', function () {
  echo '<button class="cart-qty minus">-</button>';
});

add_action('woocommerce_after_quantity_input_field', function () {
  echo '<button class="cart-qty plus">+</button>';
});

remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);

// remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);

add_action('woocommerce_payment_complete', 'so_payment_complete');
function so_payment_complete($order_id)
{
  $order = wc_get_order($order_id);
  $order->update_status('pending');
  $user = $order->get_user();
  if ($user) {
    // do something with the user
  }
}

// Remove the default variation form
// remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);

// Add custom variation form with buttons
add_action('woocommerce_after_variations_table', 'custom_variation_buttons');
function custom_variation_buttons()
{
  global $product;

  if ($product->is_type('variable')) {

    $attributes = $product->get_variation_attributes();

    if (!empty($attributes)) {
      foreach ($attributes as $attribute_name => $options) {
        echo '<div class="selects woocommerce-variation-' . sanitize_title($attribute_name) . '">';
        echo '<h4>' . wc_attribute_label($attribute_name) . '</h4><div class="selects__buttons">';
        foreach ($options as $option) {
          echo '<span class=" button variation-button" data-attribute="' . sanitize_title($attribute_name) . '" data-value="' . esc_attr($option) . '">' . esc_html($option) . '</span>';
        }

        echo '</div></div>';
      }
      echo '<span class="reset_variations button variation-button" data-attribute="" data-value="">Clear</span>';
    }
  }
}
