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
							$date_format_month  = "F";
							$date_format_day    = "d";
							$unixtimestampDebut = strtotime(get_field('citeo_date_debut'));
							$date_debut_jour    = date_i18n($date_format_day, $unixtimestampDebut);
							$date_debut_mois    = date_i18n($date_format_month, $unixtimestampDebut);
							$unixtimestampFin   = strtotime(get_field('citeo_date_fin'));
							$date_fin_jour      = date_i18n($date_format_day, $unixtimestampFin);
							$date_fin_mois      = date_i18n($date_format_month, $unixtimestampFin);
							$content            = get_the_content();
							$complement_info    = get_field( "citeo_compl_inf" );
							$location           = get_field( "citeo_address" );
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

								<?php if (!empty($unixtimestampDebut)): ?>
									<div class="article-date">
										<?php if (!empty($unixtimestampDebut)): ?>
											<?=(($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin))? 'Du':'Le';?>
											<strong><?=$date_debut_jour; ?></strong> <?=$date_debut_mois; ?>
											<?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>
												au <strong><?php echo $date_fin_jour; ?></strong> <?php echo $date_fin_mois; ?>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							
								<?php the_content(); ?>

							</div>

							<?php if(!empty($complement_info)) : ?>
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