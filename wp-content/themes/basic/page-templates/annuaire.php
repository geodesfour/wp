<?php
/*
Template Name: Annuaire
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

			<?php wp_reset_query(); ?>

			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


                $tax_query = array();
                $meta_query = array();
                $type_query = 'AND';

                $args = array(
					'post_type'      => 'fiche-annuaire',
					'posts_per_page' => get_field('opt_directory_nb_per_page', 'option'),
					'paged'          => $paged,
					'orderby'        => get_field('opt_directory_order_display', 'option'),
					'order'          => 'ASC',
                );

            	if (isset($_GET['f']) && $_GET['f'] == 1) {

                    // Si le champ theme est présent
                    if ( isset($_GET['categorie']) && !empty($_GET['categorie']) ) {

	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'categorie',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['categorie'],
	                            );

                    }

                    // Si le champ theme est présent
                    if ( isset($_GET['sous-categorie']) && !empty($_GET['sous-categorie']) ) {

	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'categorie',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['sous-categorie'],
	                            );

                    }

                    // Si le champ theme est présent
                    if ( isset($_GET['lieu']) && !empty($_GET['lieu']) ) {
	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'lieu',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['lieu'],
	                            );

                    }

                    if(isset($_GET['search-text']) && !empty($_GET['search-text']) ) {
                        $search_args = array(
                            's' => $_GET['search-text']
                        );
                        $args = array_merge($args, $search_args);
                    }

                    // On construit le tableau des paramètres de filtres
                    $filter_args = array();

                    if(count($tax_query) > 0)
                        $filter_args['tax_query'] = array( 'relation' => $type_query , $tax_query);
                    if(count($meta_query) > 0)
                        $filter_args['meta_query'] = array( 'relation' => $type_query , $meta_query);

                    // On fusionne la requête avec les paramètres de filtres
                    $args = array_merge($args, $filter_args);


            	}

            	//tool_output($args);
                // The Query who get last items event cpt
                $annuaire = new WP_Query( $args ); 
                $resultats_count = $annuaire->found_posts;

            ?>

				
					
				<div class="layout-content" role="article">

					<div class="page-header">
						<h1 class=" title pull-xs-none pull-left"><?php the_title(); ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h1>
						<div class="pull-xs-none pull-right">
							
							<?php if(get_field('opt_directory_display_map', 'option')): ?>
							<div class="switch" role="tablist" id="view">
								<a href="#view-list" role="tab" data-toggle="tab" class="active btn btn-default">
									<i class="fa fa-navicon"></i><span class="visible-lg-inline visible-md-inline">&nbsp;Afficher la liste</span>
								</a>
								<a href="#view-map" role="tab" data-toggle="tab" class="btn btn-default">
									<i class="fa fa-map-marker"></i><span class="visible-lg-inline visible-md-inline">&nbsp;Afficher la carte</span>
								</a>
							</div>
						<?php endif; ?>

							<?php if(get_field('opt_directory_filters_activated', 'option')): ?>
							<button class="btn btn-default" data-toggle="collapse" href="#collapseFilters">
								Filtrer l'annuaire &nbsp;<i class="caret"></i>
							</button>
							<?php endif; ?>
						</div>

					</div>

					<?php if(get_field('opt_directory_filters_activated', 'option')): ?>
						<div class="page-filters">

			                <?php 
			                    $args_cat = array(
			                        'post_type'  => array('fiche-annuaire'),
			                        'orderby'    => 'name',
			                        'order'      => 'ASC',
			                        'hide_empty' => true,
			                        'parent'     => '0',
			                    );
			                    $terms_catgeorie = get_terms('categorie', $args_cat);
			                    // tool_output($terms_catgeorie);

			                    $args_all_cat = array(
									'post_type'  => array('fiche-annuaire'),
									'orderby'    => 'name',
									'order'      => 'ASC',
									'hide_empty' => true,
			                    );
			                    $terms_all_catgeorie = get_terms('categorie', $args_all_cat);

			                    $categories_json = json_encode($terms_all_catgeorie);
		                    ?>
							<script type="text/javascript">

			                    $(function(){

			                 		var categories = <?php echo $categories_json; ?>;

			                    	// console.log(categories);
			                    	function getChildTerms(selectedValue) {
			    						var childTerms = [];
			                    		$('#categorie-lvl-2').removeAttr('disabled').html('<option value="">Choisissez une sous-catégorie</option>');
			                    		// console.log(categories);
			                    		$.each(categories, function(index, val) {
			                    			// console.log(val);
			                    			if (val.parent == selectedValue) {
			                    				$('#categorie-lvl-2').append('<option value="'+val.slug+'">'+val.name+'</option>');
			                    			}
			                    		});
									}

									$('#collapseFilters').on('change', '#categorie-lvl-1', function(){
										var parent_id = $(this).find(":selected").data('parent-id');

										if (typeof parent_id != 'undefined') {
											getChildTerms(parent_id);
										} else {
											$('#categorie-lvl-2').attr('disabled', 'disabled').html('<option value="">Choisissez une sous-catégorie</option>');
										}

									});

									// Au chargement de la page
									if ($('#categorie-lvl-1').val() !== '') {
										$('#categorie-lvl-1').trigger('change');
										$('#categorie-lvl-2').val($('#categorie-lvl-2').data('value'));
									} else {
										$('#categorie-lvl-2').attr('disabled', 'disabled').html('<option value="">Choisissez une sous-catégorie</option>');
									}

			                    });

		                    </script>

							<div id="collapseFilters" class="panel-collapse collapse<?php if (isset($_GET['f']) && $_GET['f'] ): ?> in<?php endif; ?>">
								<div class="panel panel-default">
									<form action="<?php the_permalink(); ?>" method="get" class="form-horizontal">
										<div class="panel-body">

											<input name="utf8" type="hidden" value="&#x2713;" />
											<input type="hidden" name="f" value="1">

											<?php if(get_field('opt_directory_display_category_filter', 'option')): ?>
											<div class="form-group">
												<label class="col-md-5 col-sm-3 control-label" for="">Qui ?</label>
												<div class="col-md-5 col-sm-8">
													<select name="categorie" id="categorie-lvl-1" class="form-control">
	                                                    <option value="">Choisissez une catégorie</option>

	                                                    <?php foreach ($terms_catgeorie as $term_catgeorie): ?>
	                                                    	<option value="<?=$term_catgeorie->slug; ?>" data-parent-id="<?=$term_catgeorie->term_id; ?>"<?php if (!empty($_GET['categorie']) && $_GET['categorie'] == $term_catgeorie->slug): ?> selected="selected"<?php endif; ?>><?=$term_catgeorie->name; ?></option>
	                                                    <?php endforeach; ?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-5 col-sm-3 col-xs-12 control-label" for="">Quoi ?</label>
												<div class="col-md-5 col-sm-8 col-xs-12">

	                                                <select name="sous-categorie" id="categorie-lvl-2" class="form-control"<?php if ( isset($_GET['sous-categorie']) && !empty($_GET['sous-categorie']) ): ?> data-value="<?php echo $_GET['sous-categorie']; ?>"<?php endif; ?>>
	                                                    <option value="">Choisissez une sous-catégorie</option>

	                                                    <?php foreach ($terms_all_catgeorie as $term): ?>
	                                                        <option value="<?=$term->slug; ?>"><?=$term->name; ?></option>
	                                                    <?php endforeach; ?>

	                                                </select>

												</div>
											</div>
											<?php endif; ?>

											<?php if(get_field('opt_directory_display_place_filter', 'option')): ?>
											<div class="form-group">
												<label class="col-md-5 col-sm-3 col-xs-12 control-label" for="">Où ?</label>
												<div class="col-md-5 col-sm-8 col-xs-12">
	                                                <select name="lieu" id="lieu" class="form-control">
	                                                    <option value="">Choisissez un lieu</option>

	                                                    <?php 
	                                                        $args = array(
	                                                			'post_type'  => array('fiche-annuaire'),
	                                                			// 'orderby'    => 'name',
	                                                			'order'      => 'ASC',
	                                                			'hide_empty' => true,
	                                                			'exclude'    => array(),
	                                                        );
	                                                        $terms = get_terms('lieu', $args);

	                                                    ?>

	                                                    <?php foreach ($terms as $term): ?>
	                                                        <option value="<?=$term->slug; ?>"<?php if (!empty($_GET['lieu']) && $_GET['lieu'] == $term->slug): ?> selected="selected"<?php endif; ?>><?=$term->name; ?></option>
	                                                    <?php endforeach; ?>

														
	                                                </select>
												</div>
											</div>
											<?php endif; ?>

											<?php if(get_field('opt_directory_display_search_filter', 'option')): ?>
	                                        <div class="form-group">
	                                            <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="search-text">Mots clé(s) </label>
	                                            <div class="col-md-5 col-sm-8 col-xs-12">
	                                                <input type="text" name="search-text" class="form-control" id="search-text" placeholder="Mots clé(s)" <?php if ( isset($_GET['search-text']) && !empty($_GET['search-text']) ): ?> value="<?php echo $_GET['search-text']; ?>"<?php endif; ?>>
	                                            </div>
	                                        </div>
	                                    	<?php endif; ?>

										</div>
										<div class="panel-footer text-right">
	                                        <a href="<?php the_permalink(); ?>" class="btn btn-default">Réinitialiser</a>
											<input type="submit" class="btn btn-primary" value="Valider">
										</div>
									</form>
								</div>
							</div>
						</div>
					<?php endif; ?>

                    <?php if(get_the_content()): ?>
                        <div class="page-intro">
                            <?php echo get_the_content(); ?>
                        </div>
                    <?php endif; ?>

					<div class="page-content">

						<div class="section-agenda">
							<div class="tab-content">

								<div class="tab-pane fade in active" id="view-list">

		                   			<?php if ($annuaire->have_posts()) : ?>

				               			<div class="lines" id="annuaires">
				                            <?php while ( $annuaire->have_posts() ) : $annuaire->the_post(); ?>

					                        	<?php
					                                $complement_info = get_field( "complement_info" );
					                            ?> 

				                                <div class="line">
				                                    <div class="line-img">
				                                        <?php the_post_thumbnail('citeo-line', array('class' => ' img-responsive', 'alt' => get_the_title())); ?>
				                                    </div> 
				                                     
				                                    <div class="line-body">
														<?php citeo_terms( get_the_id(), 'categorie' , array('class' => 'line-meta') ); ?>
				                                        <h3 class="line-title"><?php the_title(); ?></h3>
														<?php citeo_terms( get_the_id(), 'lieu' , array('class' => 'line-info') ); ?>
				                                        <div class="line-text"><?php the_content(); ?></div>
				                                    </div>

				                                    <div id="showMore<?php the_id(); ?>" class="line-collapse collapse">
				                                        <?php if(!empty($complement_info)): ?>  
				                                            <div class="well">
				                                                <?php echo $complement_info; ?> 
				                                            </div>
				                                        <?php endif; ?>
				                                        <!-- <hr> -->
				                                        <?php get_template_part( 'parts/template', 'share' ); ?>
				                                    </div>

				                                    <?php //if($content != ''): ?>
					                                    <div class="line-more">
					                                        <button class="btn btn-default collapsed" data-toggle="collapse" data-parent="#events" href="#showMore<?php the_id(); ?>">En savoir plus</button>
					                                    </div>
				                                    <?php // endif; ?>

					                            </div>
				                            <?php endwhile; ?>
					                    </div>

					                    <div class="row text-center">
					                        <?php citeo_pagination($annuaire); ?>
					                    </div>
					                  
					                <?php else: ?>
					                	<p>Aucun résultat n'a été trouvé</p>
		                        	<?php endif; ?>

					                <?php wp_reset_postdata(); ?>
					                <?php wp_reset_query(); ?>


								</div>
								<?php if(get_field('opt_directory_display_map', 'option')): ?>

								<div class="tab-pane fade" id="view-map">


	                        <?php 
				                $args_full = array(
									'post_type'      => 'fiche-annuaire',
									'posts_per_page' =>  -1,
									'paged'          => $paged,
									'orderby'        => get_field('opt_directory_order_display', 'option'),
									'order'          => 'ASC',
				                );

	                            // Si les filtres sont présent
	                            if (isset($_GET['f']) && $_GET['f'] == 1) {

	                                if(count($tax_query) > 0)
	                                    $filter_args['tax_query'] = array( 'relation' => $type_query , $tax_query);
	                                if(count($meta_query) > 0)
	                                    $filter_args['meta_query'] = array( 'relation' => $type_query , $meta_query);

	                                // On fusionne la requête avec les paramètres de filtres
	                                $args_full = array_merge($args_full, $filter_args);

	                            }

	                            $wp_query = new WP_Query( $args_full );
	                            $resultats_count = $wp_query->found_posts;
	                            ?>

		                       <?php if($wp_query->have_posts()) : ?>

		                            <div class="google-map">
		                                <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		                                <?php
		                                    $location = get_field('address');
		                                    //tool_output($location);
		                                    if($location):
		                                        $lat = $location['lat'];
		                                        $lng = $location['lng'];
		                                        $address = $location['address'];
		                                    

		                                    // $kml = get_field('kml');
		                                    // if($kml)
		                                    //         $kml = $kml['url'];
		                                    // //$terms = get_the_terms(get_the_ID(), 'category_map');
		                                    // $icon = '';
		                                ?>
		                                <?php 
		                                // if(count($terms) > 0){
		                                //     foreach($terms as $term){
		                                //         // pattern "{$term->taxonomy}_{$term->term_id}" 
		                                //         // @SEE: http://www.advancedcustomfields.com/resources/get-values-from-a-taxonomy-term/
		                                //         $pattern = $term->taxonomy.'_'.$term->term_id;
		                                //         $icon = get_field('icone', $pattern);
		                                //         if($icon)
		                                //             $icon = $icon['url'];
		                                //         break;
		                                //     }
		                                // }
		                                ?>
		                                <div class="marker hidden" data-lat="<?=$lat ?>" data-lng="<?=$lng ?>">
	                                		<div class="infowindow">
	                                			<h3><?php the_title(); ?></h3>
	                                			<?php if(has_post_thumbnail()): ?>
	                                				<div class="line-img">
	                                					<?php the_post_thumbnail('citeo-line', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
	                                				</div>
	                                			<?php endif; ?>
	                                			<div class="line-text">
	                                				<?php the_content(); ?>
	                                			</div>
	                                			<hr>
	                                			<?php if ($address): ?>
	                                				<p><?=$address; ?></p>
	                                			<?php endif; ?>
	                                			<a href="<?=the_permalink(); ?>" class="pull-right btn btn-primary btn-sm">En savoir plus</a>
                                                <?php /*
                                                    @TODO:
                                                    <p class="itineraire-bulle">Itinéraire : <a class="itineraire itineraire-aller" data-address="47.539386914287626,-2.3237772552947717">Partir de ce lieu</a> - <a class="itineraire itineraire-retour" data-address="47.539386914287626,-2.3237772552947717">Aller vers ce lieu</a></p>

                                                    @SEE: http://www.marzan.fr/plan-interactif/
                                                */ ?>
											</div>
		                                </div>
		                            	<?php endif; ?>
		                                <?php endwhile; ?>
		                            </div><!-- /.google-map -->


		                        <?php endif; ?>

								</div>
								<script>
									$(function(){
										$('#view a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
											$('#view a[data-toggle="tab"]').removeClass('active')
											$(e.target).addClass('active');
										});
									});
								</script>
							
								<?php endif; ?>

							</div>
						</div>
						
					</div>
					
				</div>

			</div>

			<?php get_sidebar(); ?>

	    </div>
	</div>
    <?php get_footer(); ?>