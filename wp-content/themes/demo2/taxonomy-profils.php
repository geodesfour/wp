<?php
/**
 * The template for displaying all single posts.
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
			<div class="col-lg-8 col-xs-12 mb-md-2x">

				<div class="layout-content">
				
				<?php if ( have_posts() ) : ?>

					<div class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</div><!-- .page-header -->

					<div class="page-content">
						<div class="lines">
						<?php 

							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'content',  'search');

							// End the loop.
							endwhile;

							citeo_pagination();

						?>
						</div>
					</div>
				<?php 
				else :
					get_template_part( 'content', 'none' );

				endif;
				?>
				</div>

			</div>
	        <?php //get_sidebar(); ?>
	    </div>
    </div>

    <?php get_footer(); ?>