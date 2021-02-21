<?php

get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$post_type = get_post_type();
		?>

		<article <?php post_class(); ?>>
			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="featured-image">
					<?php the_post_thumbnail( 'mcbain_fullscreen-image' ); ?>
				</div>
			<?php endif; ?>

			<header class="entry-header">
				<?php
				the_title( '<h1 class="entry-title">', '</h2>' );

				// Make sure we have a custom excerpt
				if ( has_excerpt() ) {
					echo '<p class="excerpt">' . get_the_excerpt() . '</p>';
				}

				// Only output post meta data on single
				if ( is_single() || is_attachment() ) : ?>

					<div class="meta">
						<?php
							if ( get_the_time( 'Ymd' ) !== get_the_modified_time( 'Ymd' ) ) {
								$label = "Updated: ";
								$time_string = sprintf(
									'<time class="entry-date updated" datetime="%1$s">%2$s</time>',
									esc_attr( get_the_modified_date( DATE_W3C ) ),
									esc_html( get_the_modified_date() )
								);
							} else {
								$label = "Created: ";
								$time_string = sprintf(
									'<time class="entry-date published" datetime="%1$s">%2$s</time>',
									esc_attr( get_the_date( DATE_W3C ) ),
									esc_html( get_the_date() )
								);
							}

							printf(
								'<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
								$label,
								esc_url( get_permalink() ),
								$time_string
							);
						?>

						<?php if ( ! is_attachment() ) : ?>
							<span>
								<?php
								echo __( 'In', 'mcbain' ) . ' ';
								the_category( ', ' );
								?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php

			wp_link_pages( array(
				'before' => '<p class="linked-pages">' . __( 'Pages', 'mcbain' ) . ':',
			) );

			if ( $post_type == 'post' && get_the_tags() ) : ?>

				<div class="meta bottom">
					<p class="tags"><?php the_tags( ' #', ' #', ' ' ); ?></p>
				</div> <!-- .meta -->

				<?php
			endif;

			// Check for single post pagination
			if ( is_single() && ! is_attachment() && ( get_previous_post_link() || get_next_post_link() ) ) : ?>

				<div class="post-pagination">

					<div class="previous-post">
						<?php if ( get_previous_post_link() ) : ?>
							<?php echo get_previous_post_link( '%link', '<span>%title</span>' ); ?>
						<?php endif; ?>
					</div>

					<div class="next-post">
						<?php if ( get_next_post_link() ) : ?>
							<?php echo get_next_post_link( '%link', '<span>%title</span>' ); ?>
						<?php endif; ?>
					</div>

				</div><!-- .post-pagination -->

			<?php endif;

			// Output comments wrapper if comments are open, or if there's a comment number – and check for password
			if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) : ?>

				<?php comments_template(); ?>

			<?php endif; ?>

		</div>

		<?php

	endwhile;

endif;

get_footer(); ?>
