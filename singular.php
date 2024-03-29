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

					<table class="meta">
						<tr>
							<td width="35%"> Published on: </td>
							<td><?php
								$time_string = sprintf(
									'<time class="entry-date published" datetime="%1$s">%2$s</time>',
									esc_attr( get_the_date( DATE_W3C ) ),
									esc_html( get_the_date() )
								);
								printf(
									'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
									esc_url( get_permalink() ),
									$time_string
								);
								?>
							</td>
						</tr>
						<?php
						/* I only want to show the updated date if it is beyond 14 days
						 * from the published date. So minor typo fixes and issues soon
						 * after published don't trigger an updated.
						 * date format 'z' => day of year (0-365)
						 **/
						$published_days = get_the_time('Y') * 365 + get_the_time('z');
						$updated_days = get_the_modified_time('Y') * 365 + get_the_modified_time('z');
						if ( ( $updated_days - $published_days ) > 14  ) : ?>
						<tr>
							<td> Last Updated: </td>
							<td><?php
								$time_string = sprintf(
									'<time class="entry-date updated" datetime="%1$s">%2$s</time>',
									esc_attr( get_the_modified_date( DATE_W3C ) ),
									esc_html( get_the_modified_date() )
								);
								printf(
									'<span class="updated-on">%1$s</span>',
									$time_string
								);
								?>
							</td>
						</tr>
						<?php endif; ?>
						<?php if ( ! is_attachment() ) : ?>
						<tr>
							<td>Category: </td>
							<td><?php the_category( ', ' ); ?></td>
						</tr>
						<?php endif; ?>
					</table>
				<?php endif; ?>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>


			<footer class="entry-footer">
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

				<?php endif; ?>
			</footer>
		</article>

		<?php
		// Output comments wrapper if comments are open, or if there's a comment number – and check for password
		if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) :
			comments_template();
		endif;


	endwhile;

endif;

get_footer(); ?>
