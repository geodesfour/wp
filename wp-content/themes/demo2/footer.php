<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package citeo
 */
?>


		</div><!-- /.layout-main -->

		<?php
			if( get_field('opt_general_display_footer_banner', 'option') && !is_front_page() ) {
				$footer_style =' style="';
				if (get_field('opt_general_footer_banner_image', 'option')) {
					$footer_style .= 'background-image:url('.get_field('opt_general_footer_banner_image', 'option')['sizes']['citeo-background'].');';
				}
				if (get_field('opt_general_footer_banner_image_height', 'option')) {
					$footer_style .= 'padding-top:'.get_field('opt_general_footer_banner_image_height', 'option').'px;';
				}
				$footer_style .='"';
			}
		?>

		<div class="layout-footer"<?php if (isset($footer_style)):?><?=$footer_style;?><?php endif; ?>>

			<div class="section-contactus">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-xs-12 mb-md-3x mb-sm-2x">
							<div class="section-header">
								<h2 class="section-title">Restons en contact</h2>
							</div>
							<div class="row">
								<div class="col-md-6 col-xs-12 mb-sm-2x">
									<div class="section-contactus-newsletter">
										<p>Inscrivez-vous à la lettre d'information pour être informé(e) en temps réel</p>
							            <?php $page_nl = get_page_by_title( "newsletter" ); ?>
							            <?php if($page_nl): ?>
							            <a href="<?=get_permalink($page_nl->ID); ?>" class="btn btn-red">S'inscrire à la lettre d'infos</a>
							            <?php endif; ?>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="section-contactus-contact">
										<p>Vous avez une question ? Besoin d'un renseignement ? N'hésitez pas à nous contacter</p>
							            <?php $page_contact = get_page_by_title( "Nous contacter" ); ?>
							            <?php if($page_contact): ?>
							            <a href="<?=get_permalink($page_contact->ID); ?>" class="btn btn-red">Nous contacter</a>
							            <?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-xs-12">
							<div class="section-contactus-networks">
								<div class="row">
									<div class="col-lg-12 col-sm-6 col-xs-12">
										<a href="http://www.facebook.fr" id="section-contactus-networks-facebook" target="_blank" class="section-contactus-networks-facebook">
											<!-- <i class="fa fa-facebook"></i> -->
											<!-- <p>Retrouvez-nous sur <strong>Facebook</strong></p> -->
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-facebook.png" width="322" height="70" class="img-responsive" alt="Retrouvez-nous sur Facebook">
										</a>
									</div>

									<div class="col-lg-12 col-sm-6 col-xs-12">
										<a href="http://www.youtube.fr" id="section-contactus-networks-youtube" target="_blank" class="section-contactus-networks-youtube">
											<!-- <i class="fa fa-youtube-play"></i> -->
											<!-- <p>Suivez-nous sur <strong>Youtube</strong></p> -->
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-youtube.png" width="322" height="70" class="img-responsive" alt="Suivez-nous sur Youtube">
										</a>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>

			<div class="section-contactinfo">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-xs-12 mb-md-4x mb-sm-2x">
							<div class="row">
								<div class="col-md-4 col-sm-3 mb-xs-2x">
									<div class="section-contactinfo-logo">
										<img class="logo-normal img-responsive animated fadeIn" src="http://geoffrey-desfour.com/basica/wp-content/uploads/2015/12/Intel_logo-130x86.png" width="130" alt="GD WP Démo">
									</div>
								</div>
								<div class="col-md-4 col-sm-5 col-xs-12 mb-xs-2x">
									<div class="section-contactinfo-contact">
										<h4 class="title">Pour nous contacter</h4>
										<p>
											<strong>Hôtel de Ville</strong><br>
											11/13, rue Paul Vaillant-Couturier<br>
											75001 Paris Cedex
										</p>

										<p>
											Tél : 01 60 21 61 10<br>
											Fax : 01 60 21 61 48
										</p>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="section-contactinfo-schedule">

										<h4 class="title">Horaires d'ouverture</h4>
										<p>Du lundi au jeudi de 8h30 à 12h et de 13h30 à 17h15</p>

										<p>Le vendredi de 8h30 à 12h et de 13h30 à 17h</p>

									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-lg-offset-0 col-md-6 col-md-offset-3 col-xs-12">

							<?php $page_accueil = get_page_by_title('Accueil'); ?>

							<?php $partners = get_field('citeo_partenaires', $page_accueil->ID ); ?>
							<div class="section-contactinfo-partenaires">
								<div class="section-header">
									<h3 class="section-title">Partenaires</h3>
								</div>
								<div class="owl-carousel owl-carousel-large" data-ride="owl-carousel">

									<?php foreach($partners as $partner): ?>
										<?php if(!empty($partner['citeo_partenaire_link']) && is_array($partner['citeo_partenaire_logo']) ): ?>
										<a href="<?=$partner['citeo_partenaire_link'] ?>" target="_blank" class="owl-content">
										    <img class="img-responsive" src="<?php echo $partner['citeo_partenaire_logo']['sizes']['citeo-partenaire']; ?>" alt="<?php echo $minisite['citeo_partenaire_logo']['alt']; ?>">
										</a>
										<?php endif; ?>
									<?php endforeach; ?>


								</div>
							</div>


						</div>
					</div>
				</div>
			</div>

			<div class="section-contentinfo" role="contentinfo">
			
				<?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
			    <div class="container-fluid">
			    <?php else: ?>
			    <div class="container">
			    <?php endif; ?>

					<div class="row">

						<div class="col-md-8 col-xs-12 text-sm-center links">

							<?php

							$args = array(
								'theme_location'  => 'footer',
								'menu_class'      => 'list-inline',
								'fallback_cb'     => false,
								'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
								);

							wp_nav_menu($args);

							?>
						</div>

						<?php /*
						<div class="col-md-2 mb-xs-1x text-sm-center socials">
							<ul class="list-inline text-sm-center">
								<?php $fbck = get_field( "opt_general_facebook", "options" ); ?>
								<?php if ( isset($fbck) && !empty($fbck)): ?>
									<li><a href="<?=$fbck; ?>"><i class="fa fa-facebook-square fa-2x"></i></a></li>
								<?php endif; ?>

								<?php $twitter = get_field( "opt_general_twitter", "options" ); ?>
								<?php if ( isset($twitter) && !empty($twitter)): ?>
									<li><a href="https://twitter.com/<?=$twitter; ?>"><i class="fa fa-twitter-square fa-2x"></i></a></li>
								<?php endif; ?>
								<?php $gplus = get_field('opt_general_google_plus', 'option'); ?>
								<?php if ( isset($gplus) && !empty($gplus)): ?>
									<li><a href="<?=$gplus; ?>"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
								<?php endif; ?>
							</ul>
						</div>
						*/ ?>



						<div class="col-md-4 col-xs-12 text-sm-center text-right">

							<div class="logo">
								

							</div>
							
						</div>

					</div>
				</div>
			</div>
		</div><!-- /.layout-footer -->

	</div><!-- /.layout-container -->	

<?php wp_footer(); ?>

<?php // @TODO: it is still useful? ?>
<?php if (get_field( "opt_general_google_analytics", "options" )): ?>
	<?php echo get_field( "opt_general_google_analytics", "options" ); ?>
<?php endif; ?>

</body>
</html>