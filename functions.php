<?php

add_action( 'after_setup_theme', function() {

	// Automatic feed
	add_theme_support( 'automatic-feed-links' );

	// Set content-width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 560;
	}

	// Post thumbnail support
	add_theme_support( 'post-thumbnails' );

	// Post thumbnail size
	set_post_thumbnail_size( 1200, 9999 );

	// Custom image sizes
	add_image_size( 'mcbain_preview-image', 600, 9999 );

	// Title tag support
	add_theme_support( 'title-tag' );

	// Add nav menu
	register_nav_menu( 'main-menu', __( 'Main menu', 'mcbain' ) );
	register_nav_menu( 'social-menu', __( 'Social links', 'mcbain' ) );

	// Add excerpts to pages
	add_post_type_support( 'page', array( 'excerpt' ) );

	// HTML5 semantic markup
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Make the theme translation ready
	load_theme_textdomain( 'mcbain', get_template_directory() . '/languages' );

} );

// need to add filter for homepage
add_filter( 'query_vars', function( $vars ) {
	$vars[] = "filter";
	return $vars;
} );


/*	-----------------------------------------------------------------------------------------------
	ENQUEUE STYLES
--------------------------------------------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', function() {

	$dependencies = array();
	$theme_version = wp_get_theme( 'mcbain' )->get( 'Version' );

	wp_enqueue_style(
		'mcbain-font-style',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;700&display=swap'
	);

	wp_enqueue_style( 'mcbain-style', get_template_directory_uri() . '/style.css', $dependencies, $theme_version );
} );


add_action( 'wp_enqueue_scripts', function() {

	$theme_version = wp_get_theme( 'mcbain' )->get( 'Version' );

	// Enqueue comment reply
	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	global $wp_query;

	// AJAX PAGINATION
	wp_localize_script( 'mcbain_global', 'mcbain_ajaxpagination', array(
		'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
		'query_vars'	=> wp_json_encode( $wp_query->query ),
	) );

} );


add_action( 'body_class', function( $classes ) {
	// Check whether we're in the customizer preview
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}

	// Add short class for full width page template
	if ( is_page_template( 'full-width-page-template.php' ) ) {
		$classes[] = 'full-width-template';
	}

	return $classes;
} );

/*	-----------------------------------------------------------------------------------------------
	WIDGETS
--------------------------------------------------------------------------------------------------- */

add_action( 'widgets_init', function() {
	register_sidebar( array(
		'name'          => 'Sidebar Widgets',
		'id'            => 'sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
} );


/*	-----------------------------------------------------------------------------------------------
	GET AND OUTPUT ARCHIVE TYPE
--------------------------------------------------------------------------------------------------- */

/* GET THE TYPE */

if ( ! function_exists( 'mcbain_get_archive_type' ) ) {
	function mcbain_get_archive_type() {
		if ( is_category() ) {
			$type = __( 'Category', 'mcbain' );
		} elseif ( is_tag() ) {
			$type = __( 'Tag', 'mcbain' );
		} elseif ( is_author() ) {
			$type = __( 'Author', 'mcbain' );
		} elseif ( is_year() ) {
			$type = __( 'Year', 'mcbain' );
		} elseif ( is_month() ) {
			$type = __( 'Month', 'mcbain' );
		} elseif ( is_day() ) {
			$type = __( 'Date', 'mcbain' );
		} elseif ( is_post_type_archive() ) {
			$type = __( 'Post Type', 'mcbain' );
		} elseif ( is_tax() ) {
			$term = get_queried_object();
			$taxonomy = $term->taxonomy;
			$taxonomy_labels = get_taxonomy_labels( get_taxonomy( $taxonomy ) );
			$type = $taxonomy_labels->name;
		} else if ( is_search() ) {
			$type = __( 'Search Results', 'mcbain' );
		} else if ( is_home() && get_theme_mod( 'mcbain_home_title' ) ) {
			$type = __( 'Introduction', 'mcbain' );
		} else {
			$type = __( 'Archives', 'mcbain' );
		}

		return $type;
	}
}

/* OUTPUT THE TYPE */

if ( ! function_exists( 'mcbain_the_archive_type' ) ) {
	function mcbain_the_archive_type() {
		$type = mcbain_get_archive_type();

		echo $type;
	}
}


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE TITLE

	@param	$title string		The initial title.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'mcbain_remove_archive_title_prefix' ) ) :
	function mcbain_remove_archive_title_prefix( $title ) {

		// A duplicate of the core archive title conditional, but without the prefix.
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '#', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
		} elseif ( is_day() ) {
			$title = get_the_date( get_option( 'date_format' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Aside', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'mcbain' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'mcbain' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_home() ) {
			if ( get_theme_mod( 'mcbain_home_title' ) ) {
				$title = get_theme_mod( 'mcbain_home_title' );
			} elseif ( get_option( 'page_for_posts' ) ) {
				$title = get_the_title( get_option( 'page_for_posts' ) );
			} else {
				$title = '';
			}
		} elseif ( is_search() ) {
			$title = '&ldquo;' . get_search_query() . '&rdquo;';
		} else {
			$title = __( 'Archives', 'mcbain' );
		}

		return $title;

	}
	add_filter( 'get_the_archive_title', 'mcbain_remove_archive_title_prefix' );
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE DESCRIPTION

	@param	$description string		The initial description.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'mcbain_filter_archive_description' ) ) :
	function mcbain_filter_archive_description( $description ) {

		// On search, show a string describing the results of the search.
		if ( is_search() ) {
			global $wp_query;
			if ( $wp_query->found_posts ) {
				/* Translators: %s = Number of results */
				$description = sprintf( _x( 'We found %s matching your search query.', 'Translators: %s = the number of search results', 'mcbain' ), $wp_query->found_posts . ' ' . ( 1 == $wp_query->found_posts ? __( 'result', 'mcbain' ) : __( 'results', 'mcbain' ) ) );
			} else {
				/* Translators: %s = the search query */
				$description = sprintf( _x( 'We could not find any results for the search query "%s". You can try again through the form below.', 'Translators: %s = the search query', 'mcbain' ), get_search_query() );
			}
		}

		return $description;

	}
	add_filter( 'get_the_archive_description', 'mcbain_filter_archive_description' );
endif;


/*	-----------------------------------------------------------------------------------------------
	PRE_GET_POSTS
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'mcbain_sort_search_posts_by_date' ) ) {
	function mcbain_sort_search_posts_by_date( $query ) {

		// In search, order results by date
		if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
			$query->set( 'orderby', 'date' );
		}

	}
}
add_action( 'pre_get_posts', 'mcbain_sort_search_posts_by_date' );


/*	-----------------------------------------------------------------------------------------------
	CUSTOM COMMENT OUTPUT
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'mcbain_comment' ) ) :
	function mcbain_comment( $comment, $args, $depth ) {

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				global $post;
				?>

				<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<?php _e( 'Pingback:', 'mcbain' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'mcbain' ) ); ?>

				<?php

				break;

			default :
				global $post;
				?>
				<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

					<div id="comment-<?php comment_ID(); ?>">

						<header class="comment-meta">

							<span class="comment-author">
								<cite>
									<?php echo get_comment_author_link(); ?>
								</cite>

								<?php
								if ( $comment->user_id === $post->post_author ) {
									echo '<span class="comment-by-post-author"> (' . __( 'Author', 'mcbain' ) . ')</span>';
								}
								?>
							</span>

							<span class="comment-date">
								<a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>" title="<?php echo get_comment_date() . ' ' . __( 'at', 'mcbain' ) . ' ' . get_comment_time(); ?>"><?php echo get_comment_date( get_option( 'date_format' ) ); ?></a>
							</span>

							<?php
							comment_reply_link( array(
								'after'			=> '</span>',
								'before'		=> '<span class="comment-reply">',
								'depth'			=> $depth,
								'max_depth' 	=> $args['max_depth'],
								'reply_text' 	=> __( 'Reply', 'mcbain' ),
							) );
							?>

						</header>

						<div class="comment-content entry-content">

							<?php comment_text(); ?>

						</div><!-- .comment-content -->

						<div class="comment-actions">
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mcbain' ); ?></p>
							<?php endif; ?>
						</div><!-- .comment-actions -->

					</div><!-- .comment -->

			<?php
			break;
		endswitch;

	}
endif; // End if().



/* Block Editor Features ------------- */
add_action( 'after_setup_theme', function() {
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor.css' );

} );


// Simplify code syntax list to ones I use
add_filter( 'mkaz_code_syntax_language_list', function() {
	return array(
		"bash" => "Bash/Shell",
		"css" => "CSS",
		"go" => "Go",
		"html" => "HTML",
		"javascript" => "JavaScript",
		"json" => "JSON",
		"markdown" => "Markdown",
		"php" => "PHP",
		"python" => "Python",
		"jsx" => "React JSX",
		"rust" => "Rust",
		"sass" => "Sass",
		"sql" => "SQL",
		"svg" => "SVG",
		"toml" => "TOML",
		"vim" => "vim",
		"xml" => "XML",
		"yaml" => "YAML",
	);
} );

