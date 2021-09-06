<article <?php post_class( 'post-preview' ); ?> id="post-<?php the_ID(); ?>">

	<h3 class="list-title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h3>
	<div class="meta">
	<?php
		$date_format = 'F j, Y';
		$date = date_i18n( $date_format, get_the_time( 'U' ) );
	?>
		<time class="entry-date published"><?php echo $date; ?></time>
	</div>
	<div class="entry-excerpt">
		<?php the_excerpt(); ?>
	</div>
</article>
