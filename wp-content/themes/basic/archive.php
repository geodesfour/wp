<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package citeo
 */
?>

	<?php get_header(); ?>

   <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>
    
		<div class="row">
			<div class="col-lg-8 col-xs-12 col-lg-offset-2">

				<div class="layout-content" role="article">
					
					<?php if ( have_posts() ) : ?>

						<div class="page-header">
							<h1 class="title pull-left">
								<?php
									if ( is_category() ) :
										single_cat_title();

									elseif ( is_tag() ) :
										single_tag_title();

									elseif ( is_post_type_archive() ):
										post_type_archive_title();

									elseif ( is_author() ) :
										printf( __( 'Author: %s', 'citeo' ), '<span class="vcard">' . get_the_author() . '</span>' );

									elseif ( is_day() ) :
										printf( __( 'Day: %s', 'citeo' ), '<span>' . get_the_date() . '</span>' );

									elseif ( is_month() ) :
										printf( __( 'Month: %s', 'citeo' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'citeo' ) ) . '</span>' );

									elseif ( is_year() ) :
										printf( __( 'Year: %s', 'citeo' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'citeo' ) ) . '</span>' );

									elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
										_e( 'Asides', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
										_e( 'Galleries', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
										_e( 'Images', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
										_e( 'Videos', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
										_e( 'Quotes', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
										_e( 'Links', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
										_e( 'Statuses', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
										_e( 'Audios', 'citeo' );

									elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
										_e( 'Chats', 'citeo' );

									else :
										_e( 'Archives', 'citeo' );

									endif;
								?>
							</h1>
							<?php
								// Show an optional term description.
								$term_description = term_description();
								if ( ! empty( $term_description ) ) :
									printf( '<div class="taxonomy-description">%s</div>', $term_description );
								endif;
							?>
						</div><!-- .page-header -->

						<div class="page-content">

							<div class="lines">

								<?php while ( have_posts() ) : the_post(); ?>
									<?php 
										$post_format = get_post_format();
										if( $post_format == ''){
											$post_format = 'search';
										}
									?>
									<?php
										get_template_part( 'content', $post_format);
									?>
								<?php endwhile; ?>
							</div>
							
							<?php citeo_pagination(); ?>

						</div>


					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>


				</div>
			</div>
			
		</div>
	</div>
	<?php get_footer(); ?>