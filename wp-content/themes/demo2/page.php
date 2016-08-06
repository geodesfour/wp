<?php 
/**
 * OVERRIDE : not needed, testimonial bugfix waiting for 1.1.4
 */
?>
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

						<?php if (get_the_content()): ?>

							<?php
								get_template_part( 'content', 'page');

								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>
							
						<?php else: ?>

							<?php
								$args = array(
									'post_type'      => 'page', 
									'post_parent'    => $post->ID,
									'posts_per_page' => 100,
									'order'          => 'ASC',
									// 'orderby'        => 'menu_order',
								);
								$childpages = new WP_Query($args); 
							?>

							<div class="page-header">
								<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
							</div>
							
							<div class="page-content">
								<div class="lines">
									<?php while( $childpages->have_posts() ) : $childpages->the_post(); ?>
										<?php get_template_part( 'content', 'search'); ?>
									<?php endwhile; wp_reset_query(); ?>
								</div>
							</div>
							<?php wp_reset_postdata(); wp_reset_query(); ?>
						<?php endif; ?>
						
					<?php endwhile; ?>

				</div>

			</div>
	        
	        <?php get_sidebar(); ?>
	        
	    </div>
    </div>
    <?php get_footer(); ?>