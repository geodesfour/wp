<?php
/**
 * The template for displaying search results pages.
 *
 * @package citeo-child
 */
?>
	<?php get_header(); ?>
	
   <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>
    
		<div class="row">
			<div class="col-lg-8 col-xs-12 col-lg-offset-2 col-md-12">

				<div class="layout-content">

					<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$args = array(
							'paged'   => $paged,
							'order'   => 'date',
							'orderby' => 'DESC',
							's'       => $_GET['s']
						);

						$results = new WP_Query( $args );

						$resultats_count = $results->found_posts;
					?>
					<div class="page-header">
						<h1 class="title pull-left"><?php printf( __( 'Recherche  %s', 'citeo' ), '' ); ?>
						<small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>s<?php endif; ?></small></h1>
					</div>

					<div class="page-content">
						
						<?php if ( $results->have_posts() ): ?>

							<div class="lines mb-lg-1x">
								<div class="line pb-lg-1x">
									<?php get_search_form(); ?>
								</div>
							</div>

							<div class="lines">
								<?php while( $results->have_posts() ) : $results->the_post(); ?>
									<?php get_template_part( 'content', 'search' ); ?>
								<?php endwhile; ?>
                        	</div>
                        
							<?php citeo_pagination(); ?>

						<?php else : ?>

							<?php get_template_part( 'content', 'none' ); ?>

						<?php endif; ?>

					</div>
				</div>
			</div>

		</div>
	</div>

	<?php get_footer(); ?>