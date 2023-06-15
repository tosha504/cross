<?php

/**
 * Banner
 *
 * @package  ogrud_botamiczny
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;


$background_image = get_sub_field('background_image');
$image = !empty(get_sub_field('image')) ? wp_get_attachment_image(get_sub_field('image'), 'full') : '';
$title = !empty(get_sub_field('title')) ? '<h1>' . get_sub_field('title') . '</h1>' : '';
$banner_products = get_sub_field('banner_products'); ?>
<!-- Banner Start -->
<section class="banner" <?php if ($background_image) {
                          echo 'style="background-image: url(' . wp_get_attachment_image_url($background_image, 'full') . ');  background-size: 50% auto;background-repeat: no-repeat;background-position: right;"';
                        } ?>>
  <div class="container">
    <?php echo $image . $title;
    if ($banner_products) {
      echo "<div class='banner__products'>";
      foreach ($banner_products as $key => $banner_product) {
        // var_dump($banner_product);
        $link = get_permalink($banner_product->ID);
        $card_image = get_the_post_thumbnail($banner_product->ID, 'prduct-image');
        echo "<a href='{$link}'class='banner__products_card'>
          <div class='banner__products_card-image'>
            {$card_image}
          </div>
          <p>{$banner_product->post_title}</p>
          <span class='button button__secondary'>See</span>
        </a>";
      }
      echo "</div>";
    }
    ?>
  </div>
</section><!-- Banner End -->