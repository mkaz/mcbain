<?php
/**
 * Template Name: Tutorial Page
 *
 * @package mcbain
 *
 */

$parent_id = ( $post->post_parent ) ? $post->post_parent : $post->ID;
$parent = get_post( $parent_id );


add_filter( 'document_title_parts', function( $title ) {
	global $post, $parent;
	$parent_title = ( isset($parent) && ($parent->ID != $post->ID) ) ? $parent->post_title . "-" : "";
	$title['site'] = $parent_title . get_bloginfo( 'name' );;
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
?>

<?php get_header(); ?>
	
	<article <?php post_class(); ?>>
		
		<header class="entry-header">
			<?php if ( $parent->ID != $post->ID ) : ?>
				<h3> <?php echo $parent->post_title; ?> </h3>
			<?php endif; ?>
		</header>

		<div class="entry-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</article>

	<nav class="post-pagination">
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

<?php get_footer(); ?>
