<?php get_header(); ?>

<?php
$archive_title_elem 	= is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h2' : 'h1';
$archive_type 			= mcbain_get_archive_type();
$archive_title 			= get_the_archive_title();
$archive_description 	= get_the_archive_description();
?>

<?php if ( ! is_home() ) : ?>
	<header class="page-header">

		<h4 class="page-subtitle"><?php echo wp_kses_post( $archive_type ); ?></h4>

		<?php if ( $archive_title ) : ?>
			<<?php echo $archive_title_elem; ?> class="page-title"><?php echo wp_kses_post( $archive_title ); ?></<?php echo $archive_title_elem; ?>>
		<?php endif; ?>

		<?php if ( $archive_description ) : ?>
			<div class="page-description">
				<?php echo wpautop( wp_kses_post( $archive_description ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_search() && ! have_posts() ) get_search_form(); ?>

	</header>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<div class="posts" id="posts">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_type() );
		endwhile;
		?>
	</div>
<?php endif; ?>

<?php

get_template_part( 'pagination' );

get_footer(); ?>
