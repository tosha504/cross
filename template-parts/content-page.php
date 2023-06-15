<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package start
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<?php //the_title('<h1 class="title">', '</h1>'); 
		?>
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'start'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .container -->
</article><!-- #post-<?php the_ID(); ?> -->