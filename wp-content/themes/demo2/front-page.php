<?php
/**
 * The home template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package citeo
 */
?>

    <?php get_header(); ?>
    
    <?php if ( get_field('citeo_message_texte') ): ?>
		<?php get_template_part( 'parts/home', 'alert' ); ?>
    <?php endif; ?>

    <div class="container mb-lg-2x">
		<div class="box-white">

		    <div class="section-showcase mb-lg-4x mb-sm-3x">
				<?php get_template_part( 'parts/home', 'carousel' ); ?>
		    </div><!-- /.section-showcase -->

		    <div class="section-newscontent">
				<?php get_template_part( 'parts/home', 'newscontent' ); ?>
		    </div><!-- /.section-newscontent -->

		</div>
	</div>

	<?php get_template_part( 'parts/home', 'accesdirect' ); ?>

	<div class="container mb-lg-3x mb-sm-2x">
		<div class="row">

			<?php if ( get_field('citeo_carrousel_kiosque') ): ?>
				<div class="col-lg-5 col-xs-12 mb-md-3x mb-sm-2x">
					<div class="section-kiosque">
						<?php get_template_part( 'parts/home', 'kiosque' ); ?>
				    </div><!-- /.section-kiosque -->
			    </div>
			<?php endif; ?>

			<?php $big_access_1 = get_field('citeo_big_access_1'); ?>
			<?php $big_access_2 = get_field('citeo_big_access_2'); ?>
			<?php if ( $big_access_1 || $big_access_2 ): ?>
				<div class="col-lg-7 col-xs-12">
					<div class="section-big-access">
					    <div class="row">
					    	<div class="col-sm-6 col-xs-12 mb-xs-2x">
					    		<?php if ($big_access_1): ?>
					    			<?php $big_access_1 = $big_access_1[0]; ?>
					    			<a href="<?php echo get_permalink( $big_access_1->ID ); ?>" class="big-access big-access-green">
					    				<h3 class="big-access-title"><?php echo $big_access_1->post_title; ?></h3>
					    				<?php echo get_the_post_thumbnail( $big_access_1->ID, 'citeo-minisite', array('class' => 'img-responsive', ) ); ?>
					    			</a>

					    		<?php endif; ?>
					    	</div>
					    	<div class="col-sm-6 col-xs-12">
					    		<?php if ($big_access_2): ?>
					    			<?php $big_access_2 = $big_access_2[0]; ?>
					    			<a href="<?php echo get_permalink( $big_access_2->ID ); ?>" class="big-access big-access-purple">
					    				<h3 class="big-access-title"><?php echo $big_access_2->post_title; ?></h3>
					    				<?php echo get_the_post_thumbnail( $big_access_2->ID, 'citeo-minisite', array('class' => 'img-responsive',) ); ?>
					    			</a>
					    		<?php endif; ?>
					    	</div>
					    </div>
				    </div><!-- /.section-websites -->
			    </div>
			<?php endif; ?>

		</div>
	</div>
	
	<?php get_template_part( 'parts/home', 'interactive-map' ); ?>

    <?php get_footer(); ?>