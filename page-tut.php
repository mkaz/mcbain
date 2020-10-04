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
					<svg title="mkaz.blog" alt="mkaz.blog logo" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 523.69916 135.49117" version="1.1">
						<g class="letters"
							transform="translate(-250.15042,-314.40502)">
							<path
								d="M 416.09656,-51.12 V 0 h 6.48 v -39.528 l 11.448,20.448 3.456,-5.904 -14.544,-26.136 z m 43.92,0 -18.576,33.192 -3.384,5.904 1.584,2.808 h 3.672 l 16.992,-30.312 V 0 h 6.48 v -51.12 z"
								stroke-width="0"
								stroke-linejoin="miter"
								stroke-miterlimit="2"
								fill="#e36137"
								stroke="#e36137"
								transform="matrix(2.5,0,0,2.5,-790.09098,446.622)"/>
							<path
								d="m 485.43594,-51.048 h -6.48 v 26.784 l 6.48,-6.984 z m 12.816,22.464 20.52,-22.536 h -6.984 l -26.352,28.296 -6.48,6.912 V 0 h 6.48 v -15.624 l 8.856,-9.216 18.576,24.84 h 7.056 z"
								stroke-width="0"
								stroke-linejoin="miter"
								stroke-miterlimit="2"
								fill="#e36137"
								stroke="#e36137"
								transform="matrix(2.5,0,0,2.5,-782.59098,446.622)" />
							<path
								d="m 602.00956,-51.12 h -30.456 v 5.76 h 25.128 z m 6.84,0 -4.968,5.76 -32.976,40.32 V 0 h 2.808 l 5.328,-5.76 32.4,-40.32 v -5.04 z M 580.76956,0 h 30.672 v -5.76 h -25.632 z"
								stroke-width="0"
								stroke-linejoin="miter"
								stroke-miterlimit="2"
								fill="#e36137"
								stroke="#e36137"
								transform="matrix(2.5,0,0,2.5,-754.75432,446.622)" />
						</g>
						<g class="mark">
							<path
								fill="none"
								stroke="#55babd"
								stroke-width="16"
								stroke-miterlimit="4"
								d="M 289.11567,131.91921 344.46865,18.102175 401.26288,131.91921" />
						</g>
					</svg>
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

