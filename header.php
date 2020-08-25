<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}
		?>

		<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'mcbain' ); ?></a>

		<header class="site-header group">

			<?php $site_title_elem = is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h1' : 'p'; ?>

			<<?php echo $site_title_elem; ?> class="site-title"><a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></<?php echo $site_title_elem; ?>>

			<?php if ( get_bloginfo( 'description' ) ) : ?>

				<div class="site-description"><?php echo wpautop( get_bloginfo( 'description' ) ); ?></div>

			<?php endif; ?>

			<input id="nav-toggle" type="checkbox"/>
			<label class="flipper" for="nav-toggle">
				<div class="bar bar1"></div>
				<div class="bar bar2"></div>
			</label>

			<div class="menu-wrapper">
				<ul class="main-menu">
					<?php

					if ( has_nav_menu( 'main-menu' ) ) {

						$main_menu_args = array(
							'container' 		=> '',
							'items_wrap' 		=> '%3$s',
							'theme_location' 	=> 'main-menu',
						);

						wp_nav_menu( $main_menu_args );

					} else {

						$fallback_args = array(
							'container' => '',
							'title_li' 	=> '',
						);

						wp_list_pages( $fallback_args );
					}
					?>
				</ul>

				<div class="widget-section">
					<?php dynamic_sidebar("sidebar"); ?>
				</div>
			</div>

		</header>

		<main class="site-content" id="site-content">
