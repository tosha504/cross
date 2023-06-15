<?php

/**
 * Banner left image
 *
 * @package  cross
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$image = !empty(get_sub_field('image')) ? wp_get_attachment_image_src(get_sub_field('image'), 'full') : '';
$title = !empty(get_sub_field('title')) ? '<h3>' . get_sub_field('title') . '</h3>' : '';
$description = !empty(get_sub_field('description')) ?  get_sub_field('description') : ''; ?>


<!-- Banner left image Start -->
<section class="left-image">
  <?php echo  "<div class='left-image__left' style='background-image: url({$image[0]})'>
    </div>
    <div class='left-image__right'>
      {$title}{$description}
    </div>";
  ?>

</section><!-- Banner left image End -->