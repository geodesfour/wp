<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package citeo
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if (get_field('opt_general_favicon', 'option')): ?>
		<link rel="shortcut icon" href="<?=get_field('opt_general_favicon', 'option'); ?>" />
	<?php endif; ?>

	<?php if (get_field('opt_general_icon_mobile', 'option')): ?>
		<link rel="apple-touch-icon-precomposed" href="<?=get_field('opt_general_icon_mobile', 'option'); ?>" />
	<?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php if (get_field('opt_general_google_webmaster_tools', 'option')): ?>
		<?=get_field('opt_general_google_webmaster_tools', 'option'); ?>
	<?php endif; ?>
	
	<?php wp_head(); ?>
</head>

<?php

	$opt_display_header_banner = get_field('opt_general_display_header_banner', 'option');
	$opt_header_banner_image_height = get_field('opt_general_header_banner_image_height', 'option');
	$opt_header_banner_image = get_field('opt_general_header_banner_image', 'option');
	$opt_background_image = get_field('opt_general_background_image', 'option');
	$logo = get_field( 'opt_general_logo', 'options' );
	$logo_retina = get_field( 'opt_general_logo_retina', 'options' );
	$opt_menu_location = get_field('opt_general_menu_location', 'option');
	$opt_display_top_bar = get_field('opt_general_display_top_bar', 'option');
	$opt_boxed_mode = get_field('opt_general_boxed_mode', 'options');
	$opt_container_fluid = get_field('opt_general_container_fluid', 'options');
	$opt_logo_location = get_field('opt_general_logo_location', 'option');
	$opt_display_breadcrumb = get_field('opt_general_display_breadcrumb', 'option');

	if( $opt_background_image && $opt_boxed_mode ) {
		$body_style =' style="background:url('.get_field('opt_general_background_image', 'option')['sizes']['citeo-background'].') no-repeat center top;background-size:cover;"';
	} else {
		$body_style = '';
	}

	if( $opt_display_header_banner && $opt_logo_location == 'menu' ) {
		$header_style =' style="';
		if ( $opt_header_banner_image ) {
			$header_style .= 'background-image:url('.get_field('opt_general_header_banner_image', 'option')['sizes']['citeo-background'].');';
		}
		$header_style .= 'padding-bottom:'.$opt_header_banner_image_height.'px;';
		$header_style .= '"';
	} else {
		$header_style = '';
	}


	if( $opt_display_header_banner && $opt_logo_location == 'bandeau-image' ) {

		$banner_style =' style="';
		if ( $opt_header_banner_image ) {
			$banner_style .= 'background-image:url('.get_field('opt_general_header_banner_image', 'option')['sizes']['citeo-background'].');';
		}
		if ($opt_header_banner_image_height) {
			$banner_style .= 'min-height:'.$opt_header_banner_image_height.'px;';
		}
		$banner_style .= '"';
	} else {
		$banner_style = '';
	}



?>


<body <?php if ( $opt_boxed_mode ) { body_class( 'boxed' ); } else { body_class(); } ?><?=$body_style;?>>

	<div class="layout-container">

		<div class="layout-header"<?=$header_style;?>>
			
			<?php if( $opt_menu_location == 'top'): ?>

				<?php get_template_part( 'parts/header', 'menu' ); ?>

			<?php endif; ?>

			<div class="container">
				
				<div class="row">
					<div class="col-lg-2 col-sm-3 col-xs-12 text-xs-center">
						<div class="logo">
							<?php if (!is_front_page()): ?>
						    	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php endif; ?>
							<?php if (!empty($logo) && isset($logo['sizes']['citeo-logo'])) : ?>
					            	<img class="logo-normal img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo']; ?>" width="130" alt="<?php echo get_bloginfo('name'); ?>">
					            	<img class="logo-retina img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo-retina']; ?>" width="130" alt="<?php echo get_bloginfo('name'); ?>">
							<?php endif; ?>
							<?php if (!is_front_page()): ?>
						    	</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="col-lg-10 col-sm-9 col-xs-12">

						<?php if($opt_display_top_bar): ?>

							<div class="section-headinfo clearfix text-xs-center">
								<?php get_template_part( 'parts/header', 'headinfo' ); ?>
							</div><!-- /.section-headinfo -->

						<?php endif; ?>

						<div class="section-headtools text-xs-center">
							<ul class="section-headtools-networks">
							    <?php $page_contact = get_page_by_title( 'Nous contacter' ); ?>
        						<?php if($page_contact): ?>
						        <li><a href="<?=get_permalink($page_contact->ID); ?>" target="_blank" class="mail visible-xs visible-sm"><i class="fa fa-envelope-o fa-lg"></i></a></li>
						        <?php endif; ?>
						        <li><a href="http://www.facebook.fr" target="_blank" class="facebook"><i class="fa fa-facebook fa-lg"></i></a></li>
						        <li><a href="http://www.youtube.fr" target="_blank" class="youtube"><i class="fa fa-youtube fa-lg"></i></a></li>
						        <li><a href="/actualite/feed/" target="_blank" class="rss"><i class="fa fa-rss fa-lg"></i></a></li>
							</ul>
							
							<?php get_search_form(); ?>

							<div class="citoyen-account hidden-xs">
								<a href="">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/espace-citoyen.png" width="206" height="76" alt="">
								</a>
							</div>
						</div>

					</div>

				</div>
			</div>

			<?php if( $opt_display_header_banner && $opt_logo_location == 'bandeau-image' ): ?>

				<div class="section-banner pt-lg-2x pb-lg-2x" <?=$banner_style; ?> role="banner">
						<?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
							<div class="container-fluid text-center">
						<?php else: ?>
							<div class="container text-center">
						<?php endif; ?>
						<h1 class="logo pull-md-none">
							<?php if (!is_front_page()): ?>
						    	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php endif; ?>

								<?php if ($opt_logo_location == 'bandeau-image' && !empty($logo) && isset($logo['sizes']['citeo-logo'])) : ?>
						            <img class="logo-normal img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo']; ?>" alt="<?php echo get_bloginfo('name'); ?>">
						            <img class="logo-retina img-responsive animated fadeIn" src="<?php echo $logo['sizes']['citeo-logo']; ?>" alt="<?php echo get_bloginfo('name'); ?>">
								<?php endif; ?>
							
							<?php if (!is_front_page()): ?>
								</a>
							<?php endif; ?>
						</h1>
					</div>
				</div><!-- /.section-banner -->

			<?php endif; ?>




			<?php if( $opt_menu_location == 'content-top'): ?>
				<?php get_template_part( 'parts/header', 'menu' ); ?>
			<?php endif; ?>

		</div><!-- /.layout-header -->





		<?php if( $opt_display_breadcrumb && !is_front_page()): ?>
			
			<div class="layout-main pb-lg-3x pt-sm-2x pb-sm-2x">

				<div class="section-breadcrumb mb-lg-3x hidden-sm hidden-xs">
					<?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
					<div class="container-fluid">
					<?php else: ?>
					<div class="container">
					<?php endif; ?>
						<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
							<?php if(function_exists('bcn_display'))
							{
								bcn_display();
							}?>
						</div>
					</div>
				</div>

		<?php elseif(!is_front_page()): ?>
			<div class="layout-main pb-lg-4x pb-sm-2x">
		<?php else: ?>
			<div class="layout-main pt-lg-4x pt-sm-2x pb-lg-4x pb-sm-2x">
		<?php endif; ?>