<?php

/**
 * Banners with products
 *
 * @package  ogrud_botamiczny
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$title = !empty(get_sub_field('title')) ? '<h3>' . get_sub_field('title') . '</h3>' : '';
$border =  get_sub_field('border') == true ? "style='border-bottom: 1px solid #ccc'" : '';
$banner =  get_sub_field('bnner') ? wp_get_attachment_image(get_sub_field('bnner'), 'full') : '';
$example_products =  get_sub_field('example_products'); ?>

<section class="banners-products">
  <div class="container" <?= $border ?>>
    <?= $title ?>
    <div class="wrap">
      <div class="wrap-img">
        <?php echo $banner ?>
      </div>
      <?php
      foreach ($example_products as $key => $example_product) {
        $banner_product_id = $example_product->ID;
        $product_name = $example_product->post_name;
        $link = get_permalink($banner_product_id);
        $image_product = get_the_post_thumbnail($banner_product_id);
        $product = wc_get_product($banner_product_id);
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $symbol = get_woocommerce_currency_symbol();
        $percentage = '';
        $weight_quantity = !empty(get_field('weight_quantity', $banner_product_id)) ?  '<p class="product__description_weight-quantity">' . get_field('weight_quantity', $banner_product_id) . '</p>' : '';
        $link_to_product = get_permalink($banner_product_id) ? '<a href='  . get_permalink($banner_product_id) . ' class="button button__primary">See</a>' : '';
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
        </div></div>";
      }
      ?>
    </div>
  </div>
</section>