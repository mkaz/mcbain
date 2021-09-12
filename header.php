<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php wp_body_open(); ?>

		<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'mcbain' ); ?></a>

		<header class="site-header">

			<div class="site-branding">
				<div class="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-name">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/mkaz-logo.svg" title="mkaz.blog logo" class="site-logo"/>
					</a>
				</div>

				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<div class="site-description"><?php echo get_bloginfo( 'description' ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( has_nav_menu( 'main-menu' ) ) : ?>
				<ul class="main-menu">
					<?php
						$main_menu_args = array(
							'container' 		=> '',
							'items_wrap' 		=> '%3$s',
							'theme_location' 	=> 'main-menu',
						);

						wp_nav_menu( $main_menu_args );
					?>
				</ul>
			<?php endif; ?>

			<div class="toggle-group">
				<input id="nav-toggle" type="checkbox" />
				<label class="flipper" for="nav-toggle">
					<div class="bar bar1"></div>
					<div class="bar bar2"></div>
				</label>
			</div>

		</header>
		
		<?php 
			$pagetemp = ( is_page_template() ) ? 'pagetut' : '';
			get_template_part( 'template-parts/widgets', $pagetemp );
		?>

		<main class="site-content" id="site-content">
