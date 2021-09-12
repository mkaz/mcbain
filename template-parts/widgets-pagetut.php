<?php
    $parent_id = ( $post->post_parent ) ? $post->post_parent : $post->ID;
?>
<aside id="widgets">
    <div class="widget-section">
        <h3>Contents</h3>
        <ul>
        <?php
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => $parent_id,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
             );

            $parent_pages = new WP_Query( $args );
            if ( $parent_pages->have_posts() ) :
        ?>
                <?php while ( $parent_pages->have_posts() ) : $parent_pages->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>

            <?php endif; ?>
            <?php wp_reset_postdata(); ?>

        </ul>
    </div>
</aside>
