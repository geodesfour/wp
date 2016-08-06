<?php
/**
 * Template for displaying Category Archive pages
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
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
					
					<div class="page-header">
						<h1 class="title">
							<?php
								printf( __( 'Category Archives: %s', 'citeo' ), '<span>' . single_cat_title( '', false ) . '</span>' );
							?>
						</h1>
					</div>

					<div class="page-content">

						<div class="lines">
							<?php
								$category_description = category_description();
								if ( ! empty( $category_description ) )
									echo '<div class="archive-meta">' . $category_description . '</div>';

								get_template_part( 'content', 'search' );
							?>
						</div>
					</div>


				</div>
			</div>

			<?php get_sidebar(); ?>
			
		</div>
	</div>
	<?php get_footer(); ?>