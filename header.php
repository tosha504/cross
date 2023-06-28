<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cross
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="wrapper">

		<header id="masthead" class="header">
			<div class="container">

				<nav id="mobile-navigation" class="header__mobile">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'mobile',
							'container' 			=> false,
							'menu_id'        => 'mobile',
							// 'menu_class'      => 'header__mobile',
							'walker' => new AWP_Menu_Walker()
						)
					);
					?>
				</nav><!-- #right-navigation -->

				<nav id="left-navigation" class="header__left-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'left-header',
							'container' 			=> false,
							'menu_id'        => 'primary-menu',
							'menu_class'      => 'header__nav',
						)
					);
					?>
				</nav><!-- #left-navigation -->

				<?php
				$header = get_field('header', 'options');
				$logo = $header['header_logo'];
				$logo_sticky = $header['header_logo_sticky'];
				if ($logo) { ?>
					<div class="header__logo">
						<a href="<?php echo esc_url(home_url('/')) ?>">
							<?php
							echo wp_get_attachment_image($logo, 'thumbnail', false, array('class' => 'normal active'));
							echo wp_get_attachment_image($logo_sticky, 'thumbnail', false, array('class' => 'sticky'));
							?>
						</a>
					</div>
				<?php } ?>

				<nav id="right-navigation" class="header__right-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'right-header',
							'container' 			=> false,
							'menu_id'        => 'primary-menu',
							'menu_class'      => 'header__nav',
						)
					);
					?>
				</nav><!-- #right-navigation -->
				<ul class="header__assets">
					<li><a href='#'><?= '<img src="' . get_template_directory_uri() . '/assets/search.svg" alt="search"/>' ?></a></li>
					<li class="header__menu-shop">
						<?php
						$login_registration = get_site_url() . '/my-account/';
						$reg = '<img src="' . get_template_directory_uri() . '/assets/log.svg" alt="registration"/>';
						echo "<a href='{$login_registration}'>{$reg}</a>";
						?>
					</li>

					<li class="header__menu-shop">
						<?php
						$cart_link = get_site_url() . '/cart';
						$shop_cart = '<img src="' . get_template_directory_uri() . '/assets/cart.svg" alt="shopping-cart"/>';
						echo "<a href='{$cart_link}' class='cartsfsd'>{$shop_cart}</a>";
						?>
						<div class="header__menu-shop_count" <?php echo wc_get_cart_url(); ?>>
							<?php
							global $woocommerce;
							echo sprintf($woocommerce->cart->cart_contents_count); ?>
						</div>
					</li>
				</ul>

				<div class="header__burger"><span></span></div>
			</div>
		</header><!-- #masthead -->