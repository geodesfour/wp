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
					<?php while (have_posts()) : the_post(); ?>

						<div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

							<div class="article-header">

								<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
								
								<?php get_template_part( 'parts/template', 'meta' ); ?>

							</div>
							
							<?php if(has_post_thumbnail()): ?>

								<div class="article-image pull-left pull-sm-none">
									<?php the_post_thumbnail('citeo-publication', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
								</div>

							<?php endif; ?>


							<div class="article-content">

								<?php
									$fichier_publication = get_field('citeo_fichier_publication');
									$lien_publication    = get_field('citeo_lien_publication');
								?>
								<?php if ( $fichier_publication || $lien_publication ): ?>
									<p>
										<?php if ( $fichier_publication ): ?>
											<a href="<?php echo $fichier_publication['url']; ?>" class="btn btn-default">Télécharger la publication</a>
										<?php endif; ?>
										<?php if ( $fichier_publication && $lien_publication ): ?>
											 &nbsp; 
										<?php endif; ?>
										<?php if ( $lien_publication ): ?>
											<a href="<?php echo $lien_publication; ?>" target="_blank" class="btn btn-default">Lire la publication</a>
										<?php endif; ?>
									</p>
								<?php endif; ?>

								<?php the_content(); ?>
							</div>

							<?php get_template_part( 'parts/template', 'share' ); ?>
							
						</div>


					<?php endwhile; ?>

				</div>

			</div>

	        <?php get_sidebar(); ?>
	    </div>
    </div>

    <?php get_footer(); ?>