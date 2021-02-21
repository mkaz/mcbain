<?php

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$filter = get_query_var( 'filter' );

	$args = array(
		'posts_per_page' => 25,
		'paged' => $paged
	);

	if ( !empty( $filter ) ) {
		$args['category_name'] = $filter;
	}

	$the_query = new WP_Query( $args );

	get_header();
?>

<header class="page-header">
	<h2 class="page-title"> Articles </h2>

	<div class="filter-list">
		Filter:
		<?php
		$categories = get_categories();
		foreach ( $categories as $category ) :
			if ( $filter && $category->name === $filter ) : ?>
				<span class="selected"><?php echo esc_html($category->name);?></span>
			<?php else : ?>
				<span><a href="/?filter=<?php echo esc_attr($category->name);?>"><?php echo esc_html($category->name);?></a></span>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</header>

<?php
if ( $the_query->have_posts() ) : ?>
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

<?php

get_template_part( 'pagination' );

get_footer();
