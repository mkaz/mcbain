<?php
/**
 * The template for displaying archive pages
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package miningtown
 * @since 1.0.0
 */

global $wp_the_query;
$wp_the_query->posts = array_reverse($wp_the_query->posts);

get_header();
?>

<div class="section-inner">
	<header class="page-header">
		<h2 class="page-title">Build a Block Series</h2>
		<p> A set of posts walking through the entire process fo creating a Gutenberg block for the WordPress block editor.</p>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="posts" id="posts">
			<ul>
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_type() );
				endwhile;
				?>
			</ul>
		</div>
	<?php endif; ?>
</div>
<?php

get_template_part( 'pagination' );

get_footer();
