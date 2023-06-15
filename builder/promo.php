<?php

/**
 * Promo
 *
 * @package  cross
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$title = !empty(get_sub_field('title')) ? '<h3>' . get_sub_field('title') . '</h3>' : '';
$args = array(
  'post_type'      => 'product',
  'posts_per_page' => 7,
  'post_status'    => 'publish',
  'meta_query'     => array(
    'relation'       => 'OR',
    array( // On sale products
      'key'           => '_sale_price',
      'value'         => 0,
      'compare'       => '>',
      'type'          => 'NUMERIC'
    ),
    array( // Variable products on sale
      'key'           => '_min_variation_sale_price',
      'value'         => 0,
      'compare'       => '>',
      'type'          => 'NUMERIC'
    )
  )
);

$products_query = new WP_Query($args); ?>
<!-- Promo Start -->
<section class="promo">
  <div class="container">
    <?php echo  $title;
    if ($products_query->have_posts()) {
      echo "<div class='promo__items'>";
      $products_query->the_post();
      $weight_quantity = get_field('weight_quantity');
      $product = wc_get_product();
      $link = get_the_permalink();
      $image_product = $product->get_image('full');
      $product_name = $product->get_name();
      $regular_price = $product->get_regular_price();
      $sale_price = $product->get_sale_price();
      $symbol = get_woocommerce_currency_symbol();
      if ($regular_price && $sale_price) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
      }

      echo "
      <ul class='promo__items_left left'><li>";
      woocommerce_template_loop_custom_product_thumbnail(true);
      echo "</li></ul><ul class='promo__items_right right'>";

      while ($products_query->have_posts()) {
        $products_query->the_post();
        echo '<li>';

        woocommerce_template_loop_custom_product_thumbnail(true);
        echo '</li>';
      }
      echo "</ul></div>";
    }

    wp_reset_postdata(); ?>
  </div>
</section><!-- Promo End -->