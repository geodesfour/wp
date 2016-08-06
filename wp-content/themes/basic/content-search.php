<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package citeo
 */
?>

	<div class="line">
		<div class="line-body">

        	<?php $post_type = get_post_type_object( get_post_type() ); ?>
        	
        	<?php if($post_type->labels->singular_name != 'Page'): ?>
			<p class="line-meta"><?=$post_type->labels->singular_name; ?></p>
			<?php endif; ?>

			<?php the_title( sprintf( '<h3 class="line-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
			<p><?php citeo_excerpt(); ?></p>

		</div>
	</div>