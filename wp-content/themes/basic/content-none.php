<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package citeo
 */
?>

<div class="no-results not-found">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<div class="page-intro">
			<?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'citeo' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		</div>

	<?php elseif ( is_search() ) : ?>


        <div class="page-intro">
            <?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'citeo' ); ?>
        </div>
		
		<div class="lines mb-lg-1x">
			<div class="line pb-lg-1x">
				<?php get_search_form(); ?>
			</div>
		</div>
		

	<?php else : ?>

		<div class="page-intro">
			<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'citeo' ); ?>
		</p>

		<div class="lines mb-lg-1x">
			<div class="line pb-lg-1x">
				<?php get_search_form(); ?>
			</div>
		</div>

	<?php endif; ?>
</div><!-- .no-results -->
