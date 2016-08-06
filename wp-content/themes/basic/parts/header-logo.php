<?php $logo = get_field( 'opt_general_logo', 'options' ); ?>
<?php if (!empty($logo) && isset($logo['sizes']['citeo-logo'])) : ?>
    <h1 class="logo pull-md-none" role="banner">
    	<?php if (!is_front_page()): ?>
        	<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php else: ?>
            <span class="navbar-brand">
        <?php endif; ?>
        	<img class="logo-normal img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo']; ?>" height="36" alt="<?php echo get_bloginfo('name'); ?>">
        	<img class="logo-retina img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo']; ?>" height="36" alt="<?php echo get_bloginfo('name'); ?>">
        <?php if (!is_front_page()): ?>
        	</a>
        <?php else: ?>
            </span>
    	<?php endif; ?>
    </h1>
<?php endif; ?>