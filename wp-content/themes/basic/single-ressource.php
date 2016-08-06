<?php
/**
 * The template for displaying all evenement single posts.
 *
 * @package citeo
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
				<div class="layout-content">

					<?php while (have_posts()) : the_post(); ?>

		                <?php   
                            $date_format_month  = "F";
                            $date_format_day    = "d";
                            $date_format_year   = "Y";
                            $date_parution      = get_field( "citeo_ressources_date_parution" );
                            $unixtimestampDebut = strtotime($date_parution);
                            $date_debut_jour    = date_i18n($date_format_day, $unixtimestampDebut);
                            $date_debut_mois    = date_i18n($date_format_month, $unixtimestampDebut);
                            $date_debut_annee   = date_i18n($date_format_year, $unixtimestampDebut);
                            $documents          = get_field( "citeo_ressources_documents_lies" );
                            $liens              = get_field( "citeo_ressources_ressources_externes" );
                            $ressources_liees   = get_field( "citeo_ressources_ressources_liees" );
                            $types              = get_the_terms( get_the_id(), 'type_ressource' );
                            $themes             = get_the_terms( get_the_id(), 'thematique_ressource' );
                        ?>    
						
						<div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article"> 

							<div class="article-header">

								<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>

								<div class="article-info">
									<div class="article-date">
										Date de parution : le <?php echo $date_debut_jour; ?> <?php echo $date_debut_mois; ?> <?php echo $date_debut_annee; ?>
									</div>
									<?php if(get_field('opt_general_display_publish_date', 'option') && get_field('opt_general_display_authors', 'option')): ?>
										<div class="article-meta">Dernière mise à jour : le <?php echo get_the_modified_date(); ?> par <?php the_author(); ?></div>
									<?php endif; ?>
									<?php if(get_field('opt_general_display_authors', 'option') && !get_field('opt_general_display_publish_date', 'option')): ?>
										<div class="article-meta">Publié par <?php the_author(); ?></div>
									<?php endif; ?>
									<?php if(get_field('opt_general_display_publish_date', 'option') && !get_field('opt_general_display_authors', 'option')): ?>
										<div class="article-meta">Dernière mise à jour : le <?php echo get_the_modified_date(); ?></div>
									<?php endif; ?>
								</div>

							</div>
 

							<?php if(has_post_thumbnail()): ?>

								<div class="article-image pull-left pull-sm-none">
									<?php the_post_thumbnail('citeo-half', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
								</div>

							<?php endif; ?>


							<div class="article-content">
								<?php the_content(); ?>
							</div>

							<?php if($documents || $liens) : ?>

								<?php if( $documents ) : ?>
									<div class="well well-ressources">
										<h4>Document(s) lié(s)</h4>
										<ul>
											<?php foreach ($documents as $key => $document): ?>

												<?php if (!empty($document['document'])): ?>
													<?php $extension = explode('.', $document['document']['url']); ?>
													<?php $extension = end($extension); ?>
													<li><a href="<?=$document['document']['url'];?>" target="blank"><i class="fa fa-file-o"></i>&nbsp; <?=$document['document']['title'];?></a> <small>(<?php echo $extension; ?>)</small></li>
												<?php endif; ?>

											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>

								<?php if( $liens ): ?>
									<div class="well well-ressources">
										<h4>Ressource(s) externe(s)</h4>
										<ul>
											<?php foreach ($liens as $key => $lien): ?>

												<?php if (!empty($lien['titre_url']) || !empty($lien['url_du_site'])): ?>
													<li><a href="<?=$lien['url_du_site'];?>" target="blank"><?=$lien['titre_url'];?> <small>&nbsp;<i class="fa fa-external-link"></i></small></a></li>
												<?php endif; ?>

											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>


                        	<?php endif; ?>

	    					<?php get_template_part( 'parts/template', 'share' ); ?>

						</div>


					<?php endwhile; ?>
					
				</div>

			</div>

	        <div class="col-lg-4">
	            <div class="layout-aside">
	                <div class="row">
	                    <div class="col-xs-12">

                            <?php if ($types || $themes): ?>
		                        <div class="panel panel-types-themes">
		                            <div class="panel-heading">
		                                <h4 class="panel-title">Informations</h4>
		                            </div>
		                            <div class="panel-body">

										<?php 
										$ressources_page = get_pages(array('meta_key' => '_wp_page_template','meta_value' => 'page-templates/ressources.php'));
										$link_ressources_pages = get_permalink($ressources_page['0']->ID);
										?>
			                            <?php if ($types): ?>
			                            	<div class="mb-lg-1x">
				                                <strong>Type de document</strong>
				                                <ul>
				                                	<?php foreach ($types as $type): ?>
				                                	<li><a href="<?=$link_ressources_pages.'?utf8=✓&f=1&type%5B%5D='.$type->slug ?>"><span class="tag tag-type_ressource tag-type_ressource-<?php echo $type->slug; ?>"><?php echo $type->name; ?></span></a></li>
				                                	<?php endforeach; ?>
				                                </ul>
			                                </div>
			                            <?php endif; ?>



			                            <?php if ($themes): ?>
			                            	<div>
				                                <strong>Thème(s)</strong>
				                                <ul>
				                                	<?php foreach ($themes as $theme): ?>
				                                	<li><a href="<?=$link_ressources_pages.'?utf8=✓&f=1&theme%5B%5D='.$theme->slug ?>"><span class="tag tag-thematique_ressource tag-thematique_ressource-<?php echo $theme->slug; ?>"><?php echo $theme->name; ?></span></a></li>
				                                	<?php endforeach; ?>
				                                </ul>
			                                </div>
			                            <?php endif; ?>

		                            </div> 
		                        </div> 
                            <?php endif; ?>

		                    <?php if ($ressources_liees): ?>
		                        <div class="panel panel-ressources-liees">
		                            <div class="panel-heading">
		                                <h4 class="panel-title">Voir aussi</h4>
		                            </div>
		                            <div class="panel-body">
										<ul>
										    <?php foreach( $ressources_liees as $post): // variable must be called $post (IMPORTANT) ?>
										        <?php setup_postdata($post); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										    <?php endforeach; ?>
										    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
										</ul>
		                            </div> 
		                        </div>
		                    <?php endif; ?>

	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>

	</div>

    <?php get_footer(); ?>