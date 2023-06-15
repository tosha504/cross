<?php

/**
 * Banner new products
 *
 * @package  cross
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$background_image = get_sub_field('background_image');
$image_product_one_ = !empty(get_sub_field('image_product_one')) ? wp_get_attachment_image(get_sub_field('image_product_one'), 'banner-image', false, ['class' => 'back']) : '';
$title = !empty(get_sub_field('title')) ? '<h3>' . get_sub_field('title') . '</h3>' : '';
$description = !empty(get_sub_field('description')) ? '<p>' . get_sub_field('description') . '</p>' : '';
$image_product_two =  !empty(get_sub_field('image_product_two')) ? wp_get_attachment_image(get_sub_field('image_product_two'), 'banner-image') : '';
$link = get_sub_field('link');
if ($link) {
  $link_url = $link['url'];
  $link_title = $link['title'];
  $link_target = $link['target'] ? $link['target'] : '_self';
  $button = '<a class="button button__secondary" href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '">' . esc_html($link_title) . '</a>';
} ?>

<!-- Banner new products Start -->
<section class="new-products" <?php if ($background_image) {
                                echo 'style="background-image: url(' . wp_get_attachment_image_url($background_image, 'full') . ');  background-size: cover;background-repeat: no-repeat;background-position: center center;"';
                              } ?>>
  <div class="container">
    <?php echo  "<div class='new-products__left'>
    {$title}{$description}
    <div class='wrap-button'>
      {$button}    
    </div>
    </div>
    <div class='new-products__right'>
      {$image_product_one_}{$image_product_two}
    </div>";
    ?>
  </div>
  <div class="bottom-section">

  </div>
</section><!-- Banner new products End -->