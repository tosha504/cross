<?php

/**
 * Custom functions
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

function breadcrumb_block($title)
{
  $bread = '';
  if (function_exists('yoast_breadcrumb')) {
    $bread = yoast_breadcrumb('<nav class="breadcrumbs-nav"><p id="breadcrumbs">', '</p></nav>', false);
  }
  return <<<HTML
    <section class="breadcrumbs">
    <div class="container">
      <div class="breadcrumbs__content">
        {$bread}
        <div class="breadcrumbs__content_wrap">
          <h1>{$title}</h1>
        </div>
      </div>
    </div>
  </section>
  HTML;
}

function builder_template()
{
  if (class_exists('ACF') && have_rows('builder')) {
    if (have_rows('builder')) {
      while (have_rows('builder')) {
        the_row();
        if (get_row_layout() == 'banner') {
          get_template_part('builder/banner');
        } else if (get_row_layout() == 'bestsellers') {
          get_template_part('builder/bestsellers');
        } else if (get_row_layout() == 'banner_new_products') {
          get_template_part('builder/banner-new-products');
        } else if (get_row_layout() == 'banner_left_image') {
          get_template_part('builder/banner-left-image');
        } else if (get_row_layout() == 'promo') {
          get_template_part('builder/promo');
        } else if (get_row_layout() == 'popular') {
          get_template_part('builder/popular');
        } else if (get_row_layout() == 'banners_with_products') {
          get_template_part('builder/banners-products');
        }
      }
    }
  }
}
