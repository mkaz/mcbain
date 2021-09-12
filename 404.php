<?php get_header(); ?>


	<header class="page-header">
		<h4 class="page-subtitle"><?php _e( 'Error 404', 'mcbain' ); ?></h4>
		<h1 class="page-title"><?php _e( 'Page Not Found', 'mcbain' ); ?></h1>
	</header>

	<article class="entry-content" style="min-height:480px;">

		<?php /* Translators: %s = link to the start page */ ?>
		<p class="excerpt"><?php printf( _x( "It might have been renamed, deleted, or didn't exist in the first place. You can return to the %s or search for the content through the form below.", 'Translators: %s = link to the start page', 'mcbain' ), '<a href="' . esc_url( home_url() ) . '">' . __( 'home page', 'mcbain' ) . '</a>' ); ?></p>

		<?php get_search_form(); ?>

	</article>

<?php get_footer(); ?>
