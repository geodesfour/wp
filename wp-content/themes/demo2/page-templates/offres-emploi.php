<?php
/*
Template Name: Offres d'emploi
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
					'post_type'      => 'emploi',
					'posts_per_page' => get_field('opt_directory_nb_per_page', 'option'),
					'paged'          => $paged,
					'orderby'        => get_field('opt_directory_order_display', 'option'),
					'order'          => 'ASC',
                    'meta_query'     => array(
                        'relation' => 'AND',
                            array(
                                'key'     => 'citeo_limit_date',
                                'value'   => date('Ymd', strtotime( 'today' )),
                                'compare' => '>='
                            )
                    )
                );

            	if (isset($_GET['f']) && $_GET['f'] == 1) {

                    // Si le champ theme est présent
                    if ( isset($_GET['categorie']) && !empty($_GET['categorie']) ) {

	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'emploi_category',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['categorie'],
	                            );

                    }

                    if ( isset($_GET['secteur']) && !empty($_GET['secteur']) ) {
	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'emploi_secteur',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['secteur'],
	                            );

                    }

                    if ( isset($_GET['type']) && !empty($_GET['type']) ) {
	                    // On complète la tax_query
	                    $tax_query[] = array(
	                                'taxonomy' => 'emploi_type',
	                                'field'    => 'slug',
	                                'terms'    => $_GET['type'],
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
                $offres_emploi = new WP_Query( $args ); 
                $resultats_count = $offres_emploi->found_posts;

            ?>

				
					
				<div class="layout-content" role="article">

					<div class="page-header">
						<h1 class=" title pull-xs-none pull-left"><?php the_title(); ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h1>
						<div class="pull-xs-none pull-right">
							

							<?php if(get_field('opt_directory_filters_activated', 'option')): ?>
							<button class="btn btn-default" data-toggle="collapse" href="#collapseFilters">
								Filtrer les offres d'emploi &nbsp;<i class="caret"></i>
							</button>
							<?php endif; ?>

						</div>

					</div>

					<?php if(get_field('opt_directory_filters_activated', 'option')): ?>
						<div class="page-filters">

                           <div class="panel-collapse">
                                <div class="panel panel-default">
                                    <form action="<?php the_permalink(); ?>" method="get">
                                    
                                        <input name="utf8" type="hidden" value="&#x2713;" />

                                        <input type="hidden" name="f" value="1">

                                        <div class="panel-body">
                                            
                                            <div class="form-group clearfix">
                                                 <label class=" col-xs-12 control-label" for="search-text">Mots clé(s) </label>
                                                <div class="col-xs-12">
                                                    <input type="text" name="search-text" class="form-control" id="search-text" placeholder="Mots clé(s)" <?php if ( isset($_GET['search-text']) && !empty($_GET['search-text']) ): ?> value="<?php echo $_GET['search-text']; ?>"<?php endif; ?>>
                                                </div>
                                            </div>

                                            <div id="collapseFilters" class="panel-collapse collapse<?php if (isset($_GET['f']) && $_GET['f'] ): ?> in<?php endif; ?>">
                                            
                                            <hr>


                                                <?php 
                                                    $args = array(
                                                        'post_type'  => array('emploi'),
                                                        'orderby'    => 'name',
                                                        'order'      => 'ASC',
                                                        'hide_empty' => false,
                                                    );
                                                    $terms = get_terms('emploi_type', $args);
                                                ?>

                                                <?php if(count($terms) > 0 ): ?>
                                                <div class="form-group clearfix">
                                                    <label class="col-xs-12 control-label" for="type">Types</label>
                                                    <?php foreach ($terms as $term): ?>
                                                        <div class="col-md-6 col-xs-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="type[]" id="<?php echo $term->slug; ?>" <?php if (!empty($_GET['type']) && in_array($term->slug, $_GET['type'])): ?>checked="checked"<?php endif; ?> value="<?php echo $term->slug; ?>">
                                                                    <?php echo $term->name; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <hr>
                                                <?php endif; ?>

                                                <?php 
                                                    $args = array(
                                                        'post_type'  => array('emploi'),
                                                        'orderby'    => 'name',
                                                        'order'      => 'ASC',
                                                        'hide_empty' => false,
                                                    );
                                                    $terms = get_terms('emploi_category', $args);
                                                ?>

                                                <?php if(count($terms) > 0 ): ?>
                                                <div class="form-group clearfix">
                                                    <label class="col-xs-12 control-label" for="categorie">Catégories</label>
                                                    <?php foreach ($terms as $term): ?>
                                                        <div class="col-md-6 col-xs-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="categorie[]" id="<?php echo $term->slug; ?>" <?php if (!empty($_GET['type']) && in_array($term->slug, $_GET['categorie'])): ?>checked="checked"<?php endif; ?> value="<?php echo $term->slug; ?>">
                                                                    <?php echo $term->name; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <hr>
                                                <?php endif; ?>

                                                <?php 
                                                    $args = array(
                                                        'post_type'  => array('emploi'),
                                                        'orderby'    => 'name',
                                                        'order'      => 'ASC',
                                                        'hide_empty' => false,
                                                    );
                                                    $terms = get_terms('emploi_secteur', $args);
                                                ?>

                                                <?php if(count($terms) > 0 ): ?>
                                                <div class="form-group clearfix">
                                                    <label class="col-xs-12 control-label" for="secteur">Secteurs</label>
                                                    <?php foreach ($terms as $term): ?>
                                                        <div class="col-md-6 col-xs-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="secteur[]" id="<?php echo $term->slug; ?>" <?php if (!empty($_GET['secteur']) && in_array($term->slug, $_GET['secteur'])): ?>checked="checked"<?php endif; ?> value="<?php echo $term->slug; ?>">
                                                                    <?php echo $term->name; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php endif; ?>



                                            </div>

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

               			<?php if ($offres_emploi->have_posts()) : ?>

	               			<div class="lines" id="annuaires">
	                            <?php while ( $offres_emploi->have_posts() ) : $offres_emploi->the_post(); ?>

		                        	<?php
		                        		$dateformatstring = "l d F Y";
		                        		$date_limite_unixtimestamp = strtotime(get_field('citeo_limit_date'));
		                            ?> 

	                                <div class="line">
	                                     
	                                    <div class="line-body">
	                                        <h3 class="line-title"><?php the_title(); ?></h3>
											<?php citeo_terms( get_the_id(), 'emploi_type' , array('class' => 'line-info') ); ?>
											<?php citeo_terms( get_the_id(), 'emploi_category' , array('class' => 'line-info'), 'Catégorie : ' ); ?>
	                                        <div class="line-text"><?php the_excerpt(); ?>Date limite de l'offre : <?php echo date_i18n($dateformatstring, $date_limite_unixtimestamp); ?></div>
	                                    </div>

	                                    <div class="line-more">
                                            <button class="btn btn-default collapsed"data-toggle="modal" data-target="#modal-<?php the_id(); ?>">En savoir plus</button>
	                                    </div>

		                            </div>

                                       <div class="modal fade" id="modal-<?php the_id(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPortraitLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                                                        <h4 class="modal-title" id="modalPortraitLabel">Offre d'emploi</h4>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            	<div class="col-md-12">
																	<?php get_template_part( 'content', 'emploi' ); ?>
																</div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

	                            <?php endwhile; ?>
		                    </div>

		                    <div class="row text-center">
		                        <?php citeo_pagination($offres_emploi); ?>
		                    </div>
		                  
		                <?php else: ?>
		                	<p>Aucune offre n'est disponible pour le moment</p>
                    	<?php endif; ?>

		                <?php wp_reset_postdata(); ?>
		                <?php wp_reset_query(); ?>

					</div>
					
				</div>

			</div>

			<?php get_sidebar(); ?>

	    </div>
	</div>
    <?php get_footer(); ?>