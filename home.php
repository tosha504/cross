<?php

/**
 * The template for displaying home(archive)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
get_header(); ?>
<main id="primary" class="site-main">
  <?php
  $page_queries = get_queried_object();
  echo breadcrumb_block($page_queries->post_title);
  ?>
  <div class="container">
    <?php if (have_posts()) { ?>
      <div class="news">
      <?php
      while (have_posts()) {
        the_post();
        $trim_words = 7;
        $title = wp_trim_words(get_the_title(), $trim_words);
        $link = esc_url(get_the_permalink());
        $post_thumnbnail = get_the_post_thumbnail();
        $image = !empty(get_the_post_thumbnail()) ? "<a href='{$link}'><div class='wrap-img'>{$post_thumnbnail}</div></a>" : "";
        $date_publication = date("F jS, Y", strtotime(get_the_date()));
        echo "<article>
              {$image}
              <div class='content'>
                <a href='{$link}'><h4>{$title}</h4></a>
                <div class='dates'>
                  <p>{$date_publication}</p>
                  <a href='{$link}' class='button button__primary'>Read more</a>
                </div>
              </div>
            </article>";
      }
    } else {
      get_template_part('template-parts/content', 'none');
    } ?>
      </div>
      <?php the_posts_navigation(); ?>
  </div>
</main><!-- #main -->

<?php
get_footer();
