<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package start
 */

$menu_column= get_field('menu', 'options');
$product_column = get_field('product', 'options');
$contact_column = get_field('contact', 'options');
$social_column = get_field('social', 'options');
$reserved = get_field('reserved', 'options');

?>

	<footer id="colophon" class="footer">
		<div class="container">
			<div class="footer__items">
				<?php 
				echo '<div class="footer__items_left">';
					if(!empty($menu_column)) {
						$item_menu = "<div class='footer__items_left-item'><h6>{$menu_column['title_menu']}</h6><div class='footer__items_item-links'>";
						if(!empty($menu_column['menu_items'])) foreach ($menu_column['menu_items'] as $key => $menu) {
							$target = !empty($menu['link']['target']) ? $menu['link']['target'] : '__blank';
							$title = $menu['link']['title'];
							$url = $menu['link']['url'];
							$item_menu .= "<a href='{$url}' target='{$target}'>{$title}</a>";
						}
					}
					$item_menu .= '</div></div>';
					echo $item_menu;

					if(!empty($product_column)) {
						$item_product = "<div class='footer__items_left-item'><h6>{$product_column['title_product']}</h6><div class='footer__items_item-links'>";
						if(!empty($product_column['menu_items_product'])) foreach ($product_column['menu_items_product'] as $key => $product_links) {
							$target = !empty($product_links['link']['target']) ? $product_links['link']['target'] : '__blank';
							$title = $product_links['link']['title'];
							$url = $product_links['link']['url'];
							$item_product .= "<a href='{$url}' target='{$target}'>{$title}</a>";
						}
					}
					$item_product .= '</div></div>';
					echo $item_product;
				echo '</div>';

				$header = get_field('header', 'options');
				$logo = $header['header_logo'];
				if ($logo) {
					$image = wp_get_attachment_image($logo, 'thumbnail');
					$home_url = esc_url(home_url('/'));
					echo "<div class='footer__items_logo'>
						<a href='{$home_url}'>{$image}</a>
					</div>";
				} 

				echo '<div class="footer__items_right">';
					if(!empty($contact_column)) {
						$item_content = "<div class='footer__items_right-item'><h6>{$contact_column['contact_title']}</h6><div class='footer__items_item-contact'>";
						$item_content .= $contact_column['contact_content'];
					}
					$item_content .= '</div></div>';
					echo $item_content;

					if(!empty($social_column)) {
						$item_social = "<div class='footer__items_right-item'><h6>{$social_column['social_product']}</h6><div class='footer__items_item-links'>";
						if(!empty($social_column['menu_items_social'])) foreach ($social_column['menu_items_social'] as $key => $social) {
							$icon = wp_get_attachment_image_src($social["before_icon"], 'full');
							$target = !empty($social['link']['target']) ? $social['link']['target'] : '__blank';
							$title = $social['link']['title'];
							$url = $social['link']['url'];
							$item_social .= "<a href='{$url}' target='{$target}' data-img='$icon[0]'>{$title}</a>";
						}
					}
					$item_social .= '</div></div>';
					echo $item_social;
				echo '</div>';
				?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
