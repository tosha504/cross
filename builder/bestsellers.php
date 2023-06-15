<?php
/**
 * Bestsellers
 *
 * @package  cross
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$background_image = get_sub_field('background_image');
$image_product_one_ = !empty(get_sub_field('image_product_one_')) ? wp_get_attachment_image( get_sub_field('image_product_one_'), 'full', false, ['class' => 'back']) : '';
$title = !empty(get_sub_field('title')) ? '<h2>' . get_sub_field('title') . '</h2>' : '';
$description = !empty(get_sub_field('description')) ? '<p>' . get_sub_field('description') . '</p>' : '';
$image_product_two =  !empty(get_sub_field('image_product_two')) ? wp_get_attachment_image( get_sub_field('image_product_two'), 'full') : '';
$link = get_sub_field('link'); 
if ($link) {
	$link_url = $link['url'];
	$link_title = $link['title'];
	$link_target = $link['target'] ? $link['target'] : '_self';

	$button = '<a class="button button__secondary" href="' . esc_url( $link_url ) . '" target="' . esc_attr( $link_target ) . '">' . esc_html( $link_title ) . '</a>';
}?>
<!-- Bestsellers Start -->
<section class="bestsellers" >
  <div class="container">
  <?php if( $background_image){ echo  wp_get_attachment_image( $background_image, 'full', false, ['class' => 'anim']) ; } ?>
    <?php echo  "<div class='bestsellers__left'>
    {$title}{$description}
    <div class='wrap-button'>
      {$button}    
    </div>
    </div>
    <div class='bestsellers__right'>
      {$image_product_one_}{$image_product_two}
    </div>
    ";

   ?>
  </div>
</section><!-- Bestsellers End -->