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
	    <div class="section-alert stripe pt-lg-2x pb-lg-none">
			<?php get_template_part( 'parts/home', 'alert' ); ?>
	    </div><!-- /.section-alert -->
    <?php endif; ?>

    <div class="section-showcase stripe pb-lg-2x <?php if ( get_field('citeo_message_texte') ): ?> pt-lg-2x<?php endif; ?>">
		<?php get_template_part( 'parts/home', 'showcase' ); ?>
    </div><!-- /.section-showcase -->

    <div class="section-newscontent stripe pt-lg-2x pb-lg-2x">
		<?php get_template_part( 'parts/home', 'newscontent' ); ?>
    </div><!-- /.section-newscontent -->

	<?php if ( get_field('citeo_minisites') ): ?>
		<div class="section-websites stripe">
			<?php get_template_part( 'parts/home', 'minisites' ); ?>
	    </div><!-- /.section-websites -->
	<?php endif; ?>

	<?php if ( get_field('citeo_carrousel_kiosque') ): ?>
		<div class="section-kiosque stripe">
			<?php get_template_part( 'parts/home', 'kiosque' ); ?>
	    </div><!-- /.section-kiosque -->
	<?php endif; ?>

    <div class="section-contactinfo stripe">
		<?php get_template_part( 'parts/home', 'contactinfo' ); ?>
    </div><!-- /.section-contactinfo -->

    <?php get_footer(); ?>