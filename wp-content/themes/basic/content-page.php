<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package citeo
 */
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

		<?php if( $post->post_excerpt ): ?>
			<p class="lead"><?php echo get_the_excerpt(); ?></p>
		<?php endif; ?>
	
		<?php the_content(); ?>

	</div>

	<?php get_template_part( 'parts/template', 'share' ); ?>
	
</div>