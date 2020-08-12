<?php
/**
 * Template Name: Tutorial Page
 *
 * @package Miningtown
 *
 */

$parent_id = ( $post->post_parent ) ? $post->post_parent : $post->ID;
$parent = get_post( $parent_id );
$parent_title = ( $parent && ($parent->ID != $post->ID) ) ? $parent->post_title . " - " : "";

// get previous / next pages

$pagelist = get_pages("child_of=".$parent_id."&sort_column=menu_order&sort_order=asc");
$prev = false;
$next = false;
$onemore = false;
foreach ($pagelist as $p) {
    if ( $onemore ) {
        $next = $p;
        break;
    }

    if ( $post->ID === $p->ID  ) {
        $onemore = true;
    } else {
        $prev = $p;
    }

}

// if this is the parent post, hardcode
if ( $post->ID === $parent_id ) {
    $prev = false;
    $next = $pagelist[0];
}

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'mcbain' ); ?></a>

<header class="site-header group">

	<?php $site_title_elem = is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h1' : 'p'; ?>

	<<?php echo $site_title_elem; ?> class="site-title"><a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></<?php echo $site_title_elem; ?>>

	<?php if ( get_bloginfo( 'description' ) ) : ?>

		<div class="site-description"><?php echo wpautop( get_bloginfo( 'description' ) ); ?></div>

	<?php endif; ?>

	<div class="nav-toggle">
		<div class="bar"></div>
		<div class="bar"></div>
	</div>

	<div class="menu-wrapper">

		<ul class="main-menu desktop">
<?php

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $parent_id,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
 );

$parent = new WP_Query( $args );
if ( $parent->have_posts() ) : ?>

    <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>

        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

    <?php endwhile; ?>

<?php endif; ?>
<?php wp_reset_postdata(); ?>

</ul>
</div><!-- .menu-wrapper -->

<?php if ( has_nav_menu( 'social-menu' ) || ( ! get_theme_mod( 'mcbain_hide_social' ) || is_customize_preview() ) ) : ?>

	<div class="social-menu desktop">
		<ul class="social-menu-inner">
			<li class="social-search-wrapper"><a href="<?php echo esc_url( home_url( '?s=' ) ); ?>"></a></li>
			<?php

			$social_args = array(
				'theme_location'	=> 'social-menu',
				'container'			=> '',
				'container_class'	=> 'menu-social group',
				'items_wrap'		=> '%3$s',
				'menu_id'			=> 'menu-social-items',
				'menu_class'		=> 'menu-items',
				'depth'				=> 1,
				'link_before'		=> '<span class="screen-reader-text">',
				'link_after'		=> '</span>',
				'fallback_cb'		=> '',
			);

			wp_nav_menu( $social_args );
			?>
		</ul>
	</div>
<?php endif; ?>

</header>

<div class="mobile-menu-wrapper">
	<ul class="main-menu mobile">
		<?php
			$args = array(
			'post_type'      => 'page',
			'posts_per_page' => -1,
			'post_parent'    => $parent_id,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		$parent = new WP_Query( $args );
		if ( $parent->have_posts() ) : ?>

			<?php while ( $parent->have_posts() ) : $parent->the_post(); ?>

				<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

			<?php endwhile; ?>

		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</ul>
</div>

<?php if ( ! get_theme_mod( 'mcbain_hide_social', false ) ) : ?>

<div class="mobile-search">
	<div class="untoggle-mobile-search"></div>

	<?php get_search_form(); ?>

	<div class="mobile-results">
		<div class="results-wrapper"></div>
	</div>
</div>

<div class="search-overlay">
	<?php get_search_form(); ?>
</div>

<?php endif; ?>

<main class="site-content" id="site-content">
	<article <?php post_class(); ?>>
		<header class="entry-header section-inner">
		</header>

		<div class="entry-content section-inner">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</article>

	<nav class="post-pagination section-inner">
		<?php if ( $prev ) : ?>
			<a href="<?php echo esc_attr( get_permalink( $prev->ID ) ); ?>">
				&#171; <?php echo esc_html( $prev->post_title ); ?>
			</a>
		<?php endif; ?>
		<?php if ( $next ) : ?>
			<a href="<?php echo esc_attr( get_permalink( $next->ID ) ); ?>">
				<?php echo esc_html( $next->post_title ); ?> &#187;
			</a>
		<?php endif; ?>
	</nav>

</main>

<?php
get_footer();

