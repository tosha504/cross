<?php

/**
 * Popular Now
 *
 * @package  cross
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$title = !empty(get_sub_field('title')) ? '<h3>' . get_sub_field('title') . '</h3>' : '' ?>

<!-- Popular Start -->
<section class="popular">
  <div class="container">
    <?= $title . do_shortcode('[recent_products limit="12"]') ?>
  </div>
</section>
<!-- Popular End -->