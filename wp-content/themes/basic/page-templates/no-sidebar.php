<?php
/*
Template Name: Sans colonne de droite
*/
?>
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
			<div class="col-lg-8 col-xs-12 col-lg-offset-2">
				<div class="layout-content" role="article">
					<?php while (have_posts()) : the_post(); ?>

						<?php get_template_part( 'content', 'page'); ?>

					<?php endwhile; ?>
				</div>
			</div>			
		</div>
	</div>
	<?php get_footer(); ?>

