<?php
/*
Template Name: Ressources documentaires
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

                <?php /* No carousel needed here */ ?>
                <?php //get_template_part( 'parts/template', 'carousel' ); ?>

                <?php wp_reset_query(); ?>

                <?php 
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                    $tax_query = array();
                    $meta_query = array();
                    $type_query = 'AND';

                    // Generic query
                    $args = array(
                        'post_type'      => 'ressource',
                        'paged'          => $paged,
                        'order'          => 'DESC',
                        'meta_key'       => 'citeo_ressources_date_parution',
                        'orderby'        => 'meta_value_num',
                        'posts_per_page' => get_field('opt_ressources_nb_per_page', 'option')
                    );

                    // Si les filtres sont présent
                    if (isset($_GET['f']) && $_GET['f'] === '1') {


                        // On set toutes les variables en fonction des params
                        // $theme = $_GET['theme'];
                        // $type = $_GET['type'];

                        // $debut_mois_select = $_GET['date_debut_mois'];
                        // $debut_annee_select = $_GET['date_debut_annee'];
                        // $fin_mois_select = $_GET['date_fin_mois'];
                        // $fin_annee_select = $_GET['date_fin_annee'];

                        if(isset($_GET['search-text']) && !empty($_GET['search-text']) ) {
                            $search_args = array(
                                's' => $_GET['search-text']
                            );
                            $args = array_merge($args, $search_args);
                        }

                        // Filtre sur le thème
                        if ( isset($_GET['theme']) && !empty($_GET['theme']) ) {                                       

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'thematique_ressource',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['theme'],
                                    );

                        }                                   

                        // Filtre sur le type
                        if ( isset($_GET['type']) && !empty($_GET['type']) ) {

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'type_ressource',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['type'],
                                    );
                        }

                        // Filtre sur la date début
                        if ( isset($_GET['date_debut_mois']) && !empty($_GET['date_debut_annee']) ) {

                            $date_start = strtotime('01-'.$_GET['date_debut_mois'].'-'.$_GET['date_debut_annee']);
                            $date_start = date('Ymd', $date_start);

                            $meta_query[] = array(
                                'key'     => 'citeo_ressources_date_parution',
                                'value'   => $date_start,
                                'compare' => '>='
                            );

                        }

                        // Filtre sur la date de fin
                        if ( isset($_GET['date_fin_mois']) && !empty($_GET['date_fin_annee']) ) {
                            $date_end = strtotime('01-'.$_GET['date_fin_mois'].'-'.$_GET['date_fin_annee']);
                            $date_end = date('Ymt', $date_end); // t permet de récupérer le dernier jour du mois

                            $meta_query[] = array(
                                'key'     => 'citeo_ressources_date_parution',
                                'value'   => $date_end,
                                'compare' => '<='
                            );

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
                   
                    // The Query who get last items ressource cpt
                    // tool_output($args);
                    $wp_query = new WP_Query( $args );

                    $resultats_count = $wp_query->found_posts;

                ?>       

                <div class="layout-content" role="article">

                    <div class="page-header">
                        <h1 class=" title pull-xs-none pull-left"><?php the_title(); ?>
                            <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small>
                        </h1>

                        <div class="pull-xs-none pull-right">

                            <?php if(get_field('opt_ressources_filters_activated', 'option') ): ?>
                            <button class="btn btn-default" data-toggle="collapse" href="#collapseFilters">
                                Recherche avancée &nbsp;<i class="caret"></i>
                            </button>
                            <?php endif; ?>

                        </div>
                    </div>
                    
                    <?php if(get_field('opt_ressources_filters_activated', 'option') ): ?>
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

                                            <?php if(get_field('opt_ressources_display_thematic_filter', 'option')): ?>

                                                <?php 
                                                    $args = array(
                                                        'post_type'  => array('ressource'),
                                                        'orderby'    => 'name',
                                                        'order'      => 'ASC',
                                                        'hide_empty' => true,
                                                        'exclude'    => array(),
                                                    );
                                                    $terms = get_terms('thematique_ressource', $args);

                                                    $get_terms = array();
                                                    if (isset($_GET['f']) && isset($_GET['theme']) && !empty($_GET['theme'])) {
                                                        $get_terms = $_GET['theme'];
                                                    }
                                                ?>


                                                <?php if(count($terms) > 0 ): ?>
                                                <div class="form-group clearfix">
                                                    <label class="col-xs-12 control-label" for="theme">Thèmes</label>
                                                    <?php foreach ($terms as $term): ?>
                                                        <div class="col-md-6 col-xs-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="theme[]" id="<?php echo $term->slug; ?>" <?php if (!empty($_GET['theme']) && in_array($term->slug, $_GET['theme'])): ?>checked="checked"<?php endif; ?> value="<?php echo $term->slug; ?>">
                                                                    <?php echo $term->name; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <hr>
                                                <?php endif; ?>

                                            <?php endif; ?>


                                            <?php if(get_field('opt_ressources_display_date_filter', 'option')): ?>   

                                                <?php 

                                                    $current_month = date('m', strtotime( 'today' ));
                                                    /* @TODO: make it as an option? */
                                                    $starting_year = '1980';
                                                    $current_year = date('Y', strtotime( 'today' )); 

                                                ?>                                    

                                                <div class="form-group form-inline clearfix">
                                                    <label class="col-md-3 col-xs-12 control-label">Date de parution</label>

                                                    <?php 

                                                    $months = array(
                                                            '01' => 'Janvier',
                                                            '02' => 'Février',
                                                            '03' => 'Mars',
                                                            '04' => 'Avril',
                                                            '05' => 'Mai',
                                                            '06' => 'Juin',
                                                            '07' => 'Juillet',
                                                            '08' => 'Août',
                                                            '09' => 'Septembre',
                                                            '10' => 'Octobre',
                                                            '11' => 'Novembre',
                                                            '12' => 'Décembre',
                                                    );

                                                    ?>
                                                    <div class="col-md-9 col-xs-12 inline-selects">
                                                        <span class="particule">De &nbsp;</span> 
                                                        <select name="date_debut_mois" id="date_debut_mois" class="form-control">
                                                            <option value=""> mois</option>
                                                            <?php foreach($months as $key => $month): ?>
                                                                <option value="<?= $key; ?>" <?php if (!empty($_GET['date_debut_mois']) && $_GET['date_debut_mois'] == $key): ?> selected="selected"<?php endif; ?>><?=$month ?></option>  
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <select name="date_debut_annee" id="date_debut_annee" class="form-control">
                                                            <option value="">année</option>
                                                            <?php for ($i=$current_year; $i >= $starting_year; $i--): ?>
                                                                <option value="<?=$i ?>" <?php if (!empty($_GET['date_debut_annee']) && $_GET['date_debut_annee'] == $i): ?> selected="selected"<?php endif; ?>><?=$i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <span class="particule">&nbsp; à &nbsp;</span>
                                                        <select name="date_fin_mois" id="date_fin_mois" class="form-control">
                                                            <option value="">mois</option>
                                                            <?php foreach($months as $key => $month): ?>
                                                                <option value="<?= $key; ?>" <?php if (!empty($_GET['date_fin_mois']) && $_GET['date_fin_mois'] == $key): ?> selected="selected"<?php endif; ?>><?=$month ?></option>  
                                                            <?php endforeach; ?>
                                                        </select>

                                                        <?php /* @TODO: rendre dynamique les années */ ?>
                                                        <select name="date_fin_annee" id="date_fin_annee" class="form-control">
                                                            <option value="">année</option>
                                                            <?php for ($i=$current_year; $i >= $starting_year; $i--): ?>
                                                                <option value="<?=$i ?>" <?php if (!empty($_GET['date_fin_annee']) && $_GET['date_fin_annee'] == $i): ?> selected="selected"<?php endif; ?>><?=$i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                       
                                                    </div>
                                                </div>
                                                <hr>

                                            <?php endif; ?>

                                            <?php if(get_field('opt_ressources_display_types_filter', 'option')): ?>

                                                <?php 
                                                        $args = array(
                                                            'post_type'  => array('ressource'),
                                                            'orderby'    => 'name',
                                                            'order'      => 'ASC',
                                                            'hide_empty' => true,
                                                            'exclude'    => array(),
                                                        );
                                                        $terms = get_terms('type_ressource', $args);

                                                ?>
                                                <?php if(count($terms) > 0): ?>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label" for="type_ressource">Type de document</label>

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
                                                <?php endif; ?>

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

                        <div class="section-ressources">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="view-list">
                                
                                <?php if($wp_query->have_posts()) : ?>

                                         <div class="lines" id="ressources">
                                            <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                                            <?php
                                                // get the ressource beginning date    
                                                $date_format_month   = "F";
                                                $date_format_day     = "d";     
                                                $date_format_year    = "Y";                                                                                                 
                                                $date_parution       = get_field( "citeo_ressources_date_parution" );   
                                                $unixtimestampDebut  = strtotime(get_field('citeo_ressources_date_parution'));
                                                $date_parution_jour     = date_i18n($date_format_day, $unixtimestampDebut);
                                                $date_parution_mois     = date_i18n($date_format_month, $unixtimestampDebut);
                                                $date_parution_annee    = date_i18n($date_format_year, $unixtimestampDebut);                                                                                   
                                                //$content            = the_content();               
                                                $documents           = get_field( "citeo_ressources_documents_lies" );
                                                $liens               = get_field( "citeo_ressources_ressources_externes" );
                                              
                                            ?>   

                                            <div class="line">
                                                <?php if(has_post_thumbnail()): ?>
                                                <div class="line-img">
                                                    <?php the_post_thumbnail('citeo-line', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
                                                </div>
                                                <?php endif; ?>
                                                <div class="line-body">                                                    
                                                    
                                                    <h3 class="line-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    
                                                    <div class="line-date">
                                                        <?php /* @TODO: pas besoin de l'exploser, autant sortir la string directement */ ?>
                                                       Date de parution : <strong><?php echo $date_parution_jour; ?></strong> <?php echo $date_parution_mois; ?> <?php echo $date_parution_annee; ?>
                                                    </div>                                                                                                          
                                                    
                                                    <div class="line-text">                                                          
                                                        <?php citeo_the_content(20); ?>
                                                    </div>

                                                    <div class="line-meta">
                                                        <?php citeo_terms( get_the_id(), 'thematique_ressource', array('class' => 'line-meta'), '<strong>Thèmes : </strong>'); ?>
                                                    </div> 

                                                    <div class="line-meta">
                                                        <?php citeo_terms( get_the_id(), 'type_ressource', array('class' => 'line-meta'), '<strong>Type de document : </strong>'); ?>
                                                    </div> 
                                                </div>

                                                <div class="line-more">
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm">En savoir plus</a>
                                                </div>
                                            </div>                              

                                            <?php endwhile; ?>
                                        </div>

                                        <?php citeo_pagination(); ?>

                                    <?php endif; ?>
                                    <?php wp_reset_postdata(); ?>
                                    <?php wp_reset_query(); ?>

                                </div>
                               
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <?php get_sidebar(); ?>

        </div>
    </div>
    <?php get_footer(); ?>