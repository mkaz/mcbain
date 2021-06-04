<?php
/**
 * Template Name: Tutorial Page
 *
 * @package Miningtown
 *
 */

$parent_id = ( $post->post_parent ) ? $post->post_parent : $post->ID;
$parent = get_post( $parent_id );

add_filter( 'document_title_parts', function( $title ) {
	global $post, $parent;
	$parent_title = ( isset($parent) && ($parent->ID != $post->ID) ) ? $parent->post_title . " - " : "";
	$parent_title .= get_bloginfo( 'name' );
	$title['site'] = $parent_title;
	return $title;
}, 10, 2 );

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

		<div class="site-title">
			<a href="<?php echo esc_url( home_url() ); ?>" class="site-name">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/mkaz.blog-pride.svg" alt="mkaz.blog logo in pride colors"/>
			</a>
		</div>

		<div class="site-description"><?php echo wpautop( get_bloginfo( 'description' ) ); ?></div>

	<input id="nav-toggle" type="checkbox"/>
	<label class="flipper" for="nav-toggle">
		<div class="bar bar1"></div>
		<div class="bar bar2"></div>
	</label>

		<div class="menu-wrapper">
			<?php if ( isset( $parent ) ) : ?>
				<h3 class="section-title">
					<a href="<?php echo esc_attr( get_permalink( $parent->ID ) ); ?>">
						<?php echo esc_html( $parent->post_title ); ?>
					</a>
				</h3>
			<?php endif; ?>
			<ul class="main-menu">
<?php

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $parent_id,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
 );

$parent_pages = new WP_Query( $args );
if ( $parent_pages->have_posts() ) : ?>

    <?php while ( $parent_pages->have_posts() ) : $parent_pages->the_post(); ?>
        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
    <?php endwhile; ?>

<?php endif; ?>
<?php wp_reset_postdata(); ?>

</ul>
</div>

</header>

<main class="site-content" id="site-content">
	<article <?php post_class(); ?>>
		<header class="entry-header">
		</header>

		<div class="entry-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</article>

	<nav class="post-pagination">
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

<?php
get_footer();

