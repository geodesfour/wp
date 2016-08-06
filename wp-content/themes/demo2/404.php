<?php
/**
 * The template for displaying 404 pages (not found).
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
			<div class="col-lg-8 col-lg-offset-2">
				<div class="layout-content error-404 not-found" role="article">

					<?php /*<p class="article-subtitle">Pré-titre</p>*/ ?>
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'citeo' ); ?></h1>
					
					<div class="page-content">
						<p class="lead"><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'citeo' ); ?></p>
						
						<?php get_search_form(); ?>
					</div>

					<?php /*
						<div class="row">
							<div class="col-md-4">
								<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
							</div>
							<?php if ( citeo_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
							<div class="col-md-4">
								<div class="widget widget_categories">
									<h2 class="widget-title"><?php _e( 'Most Used Categories', 'citeo' ); ?></h2>
									<ul>
										<?php
											wp_list_categories( array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 10,
											));
										?>
									</ul>
								</div>
							</div>
							<?php endif; ?>
							<div class="col-md-4">
									translators: %1$s: smiley
									$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'citeo' ), convert_smilies( ':)' ) ) . '</p>';
									the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
							</div>
							<div class="col-md-4">
								<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
							</div>
						</div>
					*/ ?>
				</div>
			</div>
		</div>
    </div>
    <?php get_footer(); ?>