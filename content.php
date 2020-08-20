<li <?php post_class( 'post-preview' ); ?> id="post-<?php the_ID(); ?>">

	<a href="<?php the_permalink(); ?>">
		<?php
		$sticky = is_sticky() ? '<div class="sticky-arrow"></div>'  : '';
		the_title( '<h2 class="title">' . $sticky . '<span>', '</span></h2>' );


		$date_format = 'M Y';
		$date = date_i18n( $date_format, get_the_time( 'U' ) );

		// Check setting for outputting date in lowercase
		if ( get_theme_mod( 'mcbain_preview_date_lowercase' ) ) {
			$date = strtolower( $date );
		}

		// Output date
		echo '<time class="entry-date published">' . $date . '</time>';

		?>
	</a>

</li>
