<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package start
 */

?>

<div class="container">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php 
			$thumb = get_the_post_thumbnail();
			echo "<div class='thumb-img'>{$thumb}</div>";
			$content = get_the_content();
			$title = '<h1>' . get_the_title() . '</h1>';
		

			echo "<div class='wrap'>
				{$title}
				{$content}
			</div>";
		?>
	
</article><!-- #post-<?php the_ID(); ?> -->
</div>
