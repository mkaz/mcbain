<?php

	$categories = array(
		array(
			'name' => 'WordPress',
			'slug' => 'wordpress',
		),
		array(
			'name' => 'Code',
			'slug' => 'code',
		),
		array(
			'name' => 'Misc',
			'slug' => 'misc',
		),
		array(
			'name' => 'Life',
			'slug' => 'life',
		),
		array(
			'name' => 'Dataviz',
			'slug' => 'dataviz',
		),
		array(
			'name' => 'Sports',
			'slug' => 'sports',
		),
	);

	get_header();
?>

<header class="page-header">
	<h2 class="page-title"> Articles </h2>
</header>

<?php
	foreach ( $categories as $category ) :
		$args = array(
			'category_name' => $category['slug'],
			'posts_per_page' => 10,
		);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) : ?>
			<h3 class="posts-category-title">
				<a href="/category/<?php echo $category['slug']; ?>">
					<?php echo $category['name']; ?>
				</a>
			</h3>
			<div class="posts" id="posts">
				<ul>
					<?php
					while ( $the_query->have_posts() ) : $the_query->the_post();
						get_template_part( 'content', get_post_type() );
					endwhile;
					?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php

get_footer();
