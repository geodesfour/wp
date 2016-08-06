 <?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				<div class="layout-content" role="article">
					<?php while (have_posts()) : the_post(); ?>

						<div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<div class="article-header">

								<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
								
								<?php get_template_part( 'parts/template', 'meta' ); ?>

							</div>

							<div class="article-content">
								<?php the_content(); ?>
							</div>

							<?php 
								wp_nav_menu(array(
									'theme_location' => 'main')
								);
							?>

							<?php get_template_part( 'parts/template', 'share' ); ?>
							
						</div>

					<?php endwhile; ?>
				</div>

			</div>

			<?php get_sidebar(); ?>
			
	    </div>
    </div>
    <?php get_footer(); ?>
