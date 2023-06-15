<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package start
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );

			if(get_post_type() !== 'product') {
				echo  '<div class="container">';
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( '<< previous post', 'cross' ) . '</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( '>> next post', 'cross' ) . '</span>',
						)
					);
				echo '</div>';
			}

			if(get_post_type() == 'post') {
				$current_post_id = get_the_ID();  // Get the current post ID

			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'orderby'        => 'date',  // Order by post date
				'order'          => 'DESC'   // Sort in descending order (newest first)
			);

			$other_posts_query = new WP_Query( $args );
			echo "<div class='container'><div class='news'><h5>Check other posts</h5>";

					if ( $other_posts_query->have_posts() ) {
						while ( $other_posts_query->have_posts() ) {
								$other_posts_query->the_post();
								$trim_words = 7;
								$title = wp_trim_words(  get_the_title() , $trim_words );
								$link = esc_url(get_the_permalink());
								// var_dump(get_the_post_thumbnail());
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
						wp_reset_postdata();  // Reset the query to avoid conflicts with other loops
				} else {
						// No other posts found
						echo 'No other posts available.';
				}
				echo "</div></div>";
				}
				
			// If comments are open or we have at least one comment, load up the comment template.
			// if ( comments_open() || get_comments_number() ) :
			// 	comments_template();
			// endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
