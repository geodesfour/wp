<?php
/**
 * The template for displaying all evenement single posts.
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
					<?php while (have_posts()) : the_post(); ?>

		                <?php
		                    $location        = get_field( "address" );
		                    $complement_info  = get_field( "complement_info" );
		                ?>

		                <div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

		                	<div class="article-header">
								<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>

		                		<?php get_template_part( 'parts/template', 'meta' ); ?>

		                	</div>

							<?php if(has_post_thumbnail()): ?>

								<?php
									global $content_width;
									$thumbnail_id = get_post_thumbnail_id( $post->ID );									
									$thumbnail_object = wp_get_attachment_image_src( $thumbnail_id, 'full' );
									$thumbnail_width = $thumbnail_object[1];
									$min_width = $content_width * (75/100);
								?>
								
								<?php if ($thumbnail_width > $min_width): ?>
									<div class="article-image">
										<?php the_post_thumbnail('citeo-full', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
									</div>
								<?php else: ?>
									<div class="article-image pull-left pull-sm-none">
										<?php the_post_thumbnail('citeo-half', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
									</div>
								<?php endif; ?>

							<?php endif; ?>


		                	<div class="article-content">
		                		<?php the_content(); ?>
		                	</div>

	                		<?php if(!empty($complement_info)): ?>  
	                			<div class="well">
	                				<?php echo $complement_info; ?> 
	                			</div>
	                		<?php endif; ?>

		                	<?php if( !empty($location) ): ?>
		                		<div class="google-map">
		                			<div class="marker hidden" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
		                		</div>
							<?php endif; ?>

							<?php get_template_part( 'parts/template', 'share' ); ?>

						</div>

					<?php endwhile; ?>

				</div>

			</div>

			<?php get_sidebar(); ?>
			
	    </div>
	</div>

    <?php get_footer(); ?>
