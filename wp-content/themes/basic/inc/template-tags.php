<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package citeo
 */

/*
How to
Always prefix with citeo_
And add Doc Block to explain your functions

 */

/*********************************************************************************************
*
*  Citeo Terms
*
*********************************************************************************************/
if ( ! function_exists( 'get_terms_tree' ) ):
function get_terms_tree($array, $id = 0){
    $array_return = array();
    foreach ($array as $key => $value) {
        if($value->parent == $id){
            $array_return[] = $value;
            $array_return = array_merge($array_return, get_terms_tree($array, $value->term_id));
        }
    }
    return $array_return;
}
endif;

if ( ! function_exists( 'citeo_terms' ) ):


	/**
	 * Display terms of a taxonomy
	 * @param  int    $id       	  The id of the specific post
	 * @param  string $taxonomy_name  The name of the taxonomy
	 * @param  Array  $attributes     The html attributes to apply on the wrapper div
	 * @return Dom
	 */

	function citeo_terms($id, $taxonomy_name, $attributes = array('class' => 'tags'), $before = '', $after = '' ) {
		if (get_field('opt_general_display_categories', 'option')) {

			$terms = get_the_terms( $id, $taxonomy_name );



			if( !empty($terms) && count($terms) > 0) {
				$terms = get_terms_tree($terms);
				$tag = '<div';
				foreach ($attributes as $attribute => $value) {
					if($attribute == 'class') {
						$tag .= ' '.$attribute.'="tags '.$value.'"';
					} else {
						$tag .= ' '.$attribute.'="'.$value.'"';
					}
				}
				$tag .= '>';

				echo $tag;
				echo $before;

					$terms_length = count($terms);
					$i = 0;
					foreach ($terms as $term) {

						$category_link =  get_category_link( $term->term_id );
						$comma = ($i + 1 < $terms_length) ? ', ' : '';
						$term_slug = $term->slug;
						$term_name = ($i > 0) ? strtolower($term->name) : $term->name;

						// echo '<a href="'.esc_url( $category_link ).'">';
						echo '<span class="tag tag-'.$taxonomy_name.' tag-'.$taxonomy_name.'-'.$term_slug.'">';
						echo $term_name;
						echo '</span>';
						echo $comma;
						// echo '</a>';

						$i++;
					}

				echo $after;
				echo '</div>';

			}
		}
	}
endif;




/*********************************************************************************************
*
*  Citeo Pagination
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_pagination' ) ) :

	/**
	 * Create a beautifull pagination with number and prev/next links
	 * @param  Array $query [description]
	 * @return Dom        [description]
	 */
	function citeo_pagination($query = false) {

		// No args
		if( is_single() )
			return;

    	global $wp_query;

      if($query){
        $wp_query = $query;
      }
		
		

		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 )
			return;

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );

		/**	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;

		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="clearfix text-center"><nav class="list-pagination"><ul class="pagination">' . "\n";

		/**	Previous Post Link */
		if ( get_previous_posts_link() )
			printf( '<li class="next_prev prev">%s</li>' . "\n", get_previous_posts_link() );

		/**	Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) )
				echo '<li class="disabled"><a href="#">...</a></li>';
		}

		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/**	Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				echo '<li class="disabled"><a href="#">...</a></li>' . "\n";

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/**	Next Post Link */
		if ( get_next_posts_link() )
			printf( '<li class="next_prev next">%s</li>' . "\n", get_next_posts_link() );

		echo '</ul></nav></div>' . "\n";

			

	}


endif;




/*********************************************************************************************
*
*  Citeo Paging Nav
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function citeo_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'citeo' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'citeo' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'citeo' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


/*********************************************************************************************
*
*  Citeo Post Nav
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function citeo_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'citeo' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'citeo' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'citeo' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;



/*********************************************************************************************
*
*  Citeo Posted On
*
*********************************************************************************************/




if ( ! function_exists( 'citeo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function citeo_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		//$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'citeo' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'citeo' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;



/*********************************************************************************************
*
*  Citeo Entry Footer
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function citeo_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'citeo' ) );
		if ( $categories_list && citeo_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'citeo' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'citeo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'citeo' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'citeo' ), __( '1 Comment', 'citeo' ), __( '% Comments', 'citeo' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'citeo' ), '<span class="edit-link">', '</span>' );
}
endif;





/*********************************************************************************************
*
*  Citeo Categorized Blog
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function citeo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'citeo_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'citeo_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so citeo_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so citeo_categorized_blog should return false.
		return false;
	}
}
endif;



/*********************************************************************************************
*
*  Citeo Category Transient Flusher
*
*********************************************************************************************/


if ( ! function_exists( 'citeo_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in citeo_categorized_blog.
 */
function citeo_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'citeo_categories' );
}

add_action( 'edit_category', 'citeo_category_transient_flusher' );
add_action( 'save_post',     'citeo_category_transient_flusher' );
endif;



if ( ! function_exists( 'citeo_excerpt' ) ) :
/**
 * cette fonction sert à raccourcir le ef ede de 
 * @param  int $limit new limit for the excertp
 * @return [type]        [description]
 */
function citeo_excerpt($limit = '100') {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	// 
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	echo $excerpt;
}
endif;

if ( ! function_exists( 'content' ) ) :

/**
 * [citeo_the_content description]
 * @param  [interger] $limit number of words
 * @return [string]   limited text
 */
function citeo_the_content($limit = 30) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	} else {
		$content = implode(" ",$content);
	}
	//$content = preg_replace('/[.+]/','', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	echo $content;
}
endif;





/*********************************************************************************************
*
*  Get Terms by Post Type
*
*********************************************************************************************/
/**
 * Return the terms of a specific post type
 */
// function get_terms_by_post_type($post_type,$taxonomy,$fields='all',$args){
//     $q_args = array(
//         'post_type' => (array)$post_type,
//         'posts_per_page' => -1
//     );
//     $the_query = new WP_Query( $q_args );

//     $terms = array();

//     while ($the_query->have_posts()) { $the_query->the_post();

//         global $post;
//         echo "<pre>";
//         print_r($post->ID);
//         echo "</pre>";
//         $current_terms = get_the_terms( $post->ID, $taxonomy);

//         foreach ($current_terms as $t){
//             //avoid duplicates
//             if (!in_array($t,$terms)){
//                 $t->count = 1;
//                 $terms[] = $t;
//             }else{
//                 $key = array_search($t, $terms);
//                 $terms[$key]->count = $terms[$key]->count + 1;
//             }
//         }
//     }
//     wp_reset_query();

//     //return array of term objects
//     if ($fields == "all")
//         return $terms;
//     //return array of term ID's
//     if ($fields == "ID"){
//         foreach ($terms as $t){
//             $re[] = $t->term_id;
//         }
//         return $re;
//     }
//     //return array of term names
//     if ($fields == "name"){
//         foreach ($terms as $t){
//             $re[] = $t->name;
//         }
//         return $re;
//     }
//     // get terms with get_terms arguments
//     if ($fields == "get_terms"){
//         $terms2 = get_terms( $taxonomy, $args );

//         foreach ($terms as $t){
//             if (in_array($t,$terms2)){
//                 $re[] = $t;
//             }
//         }
//         return $re;
//     }
// }