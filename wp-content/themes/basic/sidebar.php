<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package citeo
 */

if ( !is_active_sidebar( 'sidebar-1' ) && !get_field('citeo_font_lactualite')) {
	return;
}
?>

<aside class="col-lg-4 col-xs-12" role="complementary">
	<div class="layout-aside widget-area" id="secondary" role="complementary">
		<?php if(get_field('citeo_font_lactualite')): ?>
			<?php get_template_part( 'parts/widget', 'testimonial' ); ?>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		<?php endif; ?>
	</div>
</aside>

