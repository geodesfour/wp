<?php
/*
Template Name: Événements
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
                <?php get_template_part( 'parts/template', 'carousel' ); ?>


                <?php wp_reset_query(); ?>
                <?php 
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                    $tax_query = array();
                    $meta_query = array();
                    $type_query = 'AND';

                    $args = array(
                        'post_type'      => 'evenement',
                        'paged'          => $paged,
                        'order'          => 'ASC',
                        'meta_key'       => 'citeo_date_debut',
                        'orderby'        => 'meta_value_num',
                        'posts_per_page' => get_field('opt_event_nb_per_page', 'option'),
                        'meta_query'     => array(
                            'relation' => 'AND',
                                array(
                                    'key'     => 'citeo_date_fin',
                                    'value'   => date('Ymd', strtotime( 'today' )),
                                    'compare' => '>='
                                )
                        )
                    );

                    // Si les filtres sont présent
                    if (isset($_GET['f']) && $_GET['f'] == 1) {

                        // Si le champ theme est présent
                        if ( isset($_GET['theme']) && !empty($_GET['theme']) ) {

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'thematique',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['theme'],
                                    );

                        }

                        // @TODO : transformer en appel de fontion getThisMonth getThisWeekend dans extras.php
                        // Si le champ date est présent
                        if ( isset($_GET['date']) && !empty($_GET['date']) && in_array($_GET['date'], array('aujourdhui', 'semaine', 'weekend', 'mois')) ) {

                            setlocale( LC_ALL, 'fr_FR.UTF-8' );
                            
                            if ( $_GET['date'] == 'aujourdhui' ) {

                                $date_start = strtotime( 'today' );
                                $date_end = strtotime( 'tomorrow -1 second' );

                            } elseif ( $_GET['date'] == 'semaine' ) {

                                $date_start = strtotime( 'last monday' );
                                $date_end = strtotime( 'next monday -1 second' );

                            } elseif ( $_GET['date'] == 'weekend' ) {

                                $date_start = strtotime( 'next saturday', strtotime( 'last monday' ) );
                                $date_end = strtotime( 'next monday -1 second' );

                            } elseif ( $_GET['date'] == 'mois' ) {

                                $date_start = strtotime( 'today' );
                                // $date_start = mktime( 0, 0 ,0, date( 'n' ), 1 );
                                $date_end = mktime( 0, 0 ,-1, date( 'n' ) + 1, 1 );

                            }

                            // On formatte les dates pour correspondre aux custom fields (20150301)
                            $date_start = date('Ymd', $date_start);
                            $date_end = date('Ymd', $date_end);

                             // On complète la query
                            $meta_query[] = array(
                                        'key'     => 'citeo_date_debut',
                                        'value'   => $date_end,
                                        'compare' => '<='
                            );

                            $meta_query[] = array(
                                        'key'     => 'citeo_date_fin',
                                        'value'   => $date_start,
                                        'compare' => '>='
                            );

                        }

                        if ( isset($_GET['lieu']) && !empty($_GET['lieu']) ) {

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'lieu',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['lieu'],
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

                    // The Query who get last items event cpt
                    $wp_query = new WP_Query( $args );
                    $wp_query_map = $wp_query;

                    $resultats_count = $wp_query->found_posts;
                ?>

                <div class="layout-content" role="article">

                    <div class="page-header">
                        <h1 class=" title pull-xs-none pull-left"><?php the_title(); ?>
                            <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small>
                        </h1>
                        <div class="pull-xs-none pull-right">

                            <?php if(get_field('opt_event_display_map', 'option')): ?>

                            <div class="switch" role="tablist" id="view">
                                <a href="#view-list" role="tab" data-toggle="tab" class="active btn btn-default">
                                    <i class="fa fa-navicon"></i><span class="visible-lg-inline visible-md-inline">&nbsp;Afficher la liste</span>
                                </a>
                                <a href="#view-map" role="tab" data-toggle="tab" class="btn btn-default">
                                    <i class="fa fa-map-marker"></i><span class="visible-lg-inline visible-md-inline">&nbsp;Afficher la carte</span>
                                </a>
                            </div>
                            <?php endif; ?>


                            <?php if(get_field('opt_event_filters_activated', 'option') ): ?>
                            <button class="btn btn-default" data-toggle="collapse" href="#collapseFilters">
                                Filtrer les événements &nbsp;<i class="caret"></i>
                            </button>
                            <?php endif; ?>

                        </div>
                    </div>
                    
                    <?php if(get_field('opt_event_filters_activated', 'option') ): ?>
                        <div class="page-filters">
                            <div id="collapseFilters" class="panel-collapse collapse<?php if (isset($_GET['f']) && $_GET['f'] ): ?> in<?php endif; ?>">
                                <div class="panel panel-default">
                                    <form action="<?php the_permalink(); ?>" method="get" class="form-horizontal">
                                    
                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="f" value="1">

                                        <div class="panel-body">
                                            
                                            <?php if(get_field('opt_event_display_thematic_filter', 'option')): ?>
                                                <div class="form-group">
                                                    <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="theme">Quoi ?</label>
                                                    <div class="col-md-5 col-sm-8 col-xs-12">
                                                        <select name="theme" id="theme" class="form-control">

                                                            <?php 
                                                                $args = array(
                                                                    'post_type'  => array('evenement'),
                                                                    'orderby'    => 'name',
                                                                    'order'      => 'ASC',
                                                                    'hide_empty' => true,
                                                                    'exclude'    => array(),
                                                                );
                                                                $terms = get_terms('thematique', $args);

                                                                $get_terms = array();
                                                                if (isset($_GET['f']) && isset($_GET['theme']) && !empty($_GET['theme'])) {
                                                                    $get_terms = $_GET['theme'];
                                                                }
                                                            ?>
                                                            <option value="">Choisissez un thème</option>

                                                            <?php foreach ($terms as $term): ?>
                                                                <option value="<?php echo $term->slug; ?>"<?php if (!empty($_GET['theme']) && $_GET['theme'] == $term->slug): ?> selected="selected"<?php endif; ?>><?php echo $term->name; ?></option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(get_field('opt_event_display_date_filter', 'option')): ?>
                                            <div class="form-group">
                                                <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="date">Quand ?</label>
                                                <div class="col-md-5 col-sm-8 col-xs-12">
                                                    <select name="date" id="date" class="form-control">
                                                        <option value="">Choisissez une date</option>
                                                        <?php /* TODO : add an array */ ?>
                                                        <option value="aujourdhui"<?php if (!empty($_GET['date']) && $_GET['date'] == 'aujourdhui'): ?> selected="selected"<?php endif; ?>>Aujourd'hui</option>
                                                        <option value="semaine"<?php if (!empty($_GET['date']) && $_GET['date'] == 'semaine'): ?> selected="selected"<?php endif; ?>>Cette semaine</option>
                                                        <option value="weekend"<?php if (!empty($_GET['date']) && $_GET['date'] == 'weekend'): ?> selected="selected"<?php endif; ?>>Ce week-end</option>
                                                        <option value="mois"<?php if (!empty($_GET['date']) && $_GET['date'] == 'mois'): ?> selected="selected"<?php endif; ?>>Ce mois-ci</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(get_field('opt_event_display_place_filter', 'option')): ?>
                                            <div class="form-group">
                                                <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="lieu">Où ?</label>
                                                <div class="col-md-5 col-sm-8 col-xs-12">
                                                    <select name="lieu" id="lieu" class="form-control">
                                                        <option value="">Choisissez un lieu</option>

                                                        <?php 
                                                            $args = array(
                                                                'post_type'  => array('evenement'),
                                                                'orderby'    => 'name',
                                                                'order'      => 'ASC',
                                                                'hide_empty' => true,
                                                                'exclude'    => array(),
                                                            );
                                                            $terms = get_terms('lieu', $args);

                                                        ?>

                                                        <?php foreach ($terms as $term): ?>
                                                            <option value="<?php echo $term->slug; ?>"<?php if (!empty($_GET['lieu']) && $_GET['lieu'] == $term->slug): ?> selected="selected"<?php endif; ?>><?php echo $term->name; ?></option>
                                                        <?php endforeach; ?>


                                                    </select>
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
                                
     

                                    <?php if($wp_query->have_posts()) : ?>


                                        <div class="lines" id="events">
                                            <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                                            <?php
                                                // get the event beginning date
                                                $date_format_month  = "F";
                                                $date_format_day    = "d";
                                                $unixtimestampDebut = strtotime(get_field('citeo_date_debut'));
                                                $date_debut_jour    = date_i18n($date_format_day, $unixtimestampDebut);
                                                $date_debut_mois    = date_i18n($date_format_month, $unixtimestampDebut);
                                                $unixtimestampFin   = strtotime(get_field('citeo_date_fin'));
                                                $date_fin_jour      = date_i18n($date_format_day, $unixtimestampFin);
                                                $date_fin_mois      = date_i18n($date_format_month, $unixtimestampFin);
                                                //$content            = the_content();
                                                $compl_inf          = get_field( "citeo_compl_inf" );
                                            ?>
                                               
                                                
                                            <?php //if (!empty($unixtimestampDebut)) : ?>
                                            <div class="line">
                                                <?php if(has_post_thumbnail()): ?>
                                                <div class="line-img">
                                                    <?php the_post_thumbnail('citeo-line', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
                                                </div>
                                                <?php endif; ?>
                                                <div class="line-body">
                                                    
                                                    <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'line-meta') ); ?>

                                                    <h3 class="line-title"><?php the_title(); ?></h3>

                                                    <?php if (!empty($unixtimestampDebut)): ?>
                                                        <div class="line-date">
                                                            <?php echo (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin))? 'Du':'Le';?>
                                                            <strong><?php echo $date_debut_jour; ?></strong> <?php echo $date_debut_mois; ?>
                                                            <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>
                                                            au <strong><?php echo $date_fin_jour; ?></strong> <?php echo $date_fin_mois; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="line-text">                                                          
                                                        <?php the_content(); ?>
                                                    </div>
                                                </div>

                                                <div id="showMore<?php the_id(); ?>" class="line-collapse collapse">
                                                    <?php if(!empty($compl_inf)) : ?>
                                                    <div class="well">
                                                         <?php echo $compl_inf; ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    <!-- <hr> -->
                                                    <?php get_template_part( 'parts/template', 'share' ); ?>
                                                </div>
                                                
                                                <?php //if($content != ''): ?>
                                                <div class="line-more">
                                                    <button class="btn btn-sm collapsed" data-toggle="collapse" data-parent="#events" href="#showMore<?php the_id(); ?>">En savoir plus</button>
                                                </div>
                                                <?php //endif; ?>

                                            </div>

                                            <?php //endif; ?>

                                            <?php endwhile; ?>
                                        </div>

                                        <?php citeo_pagination(); ?>

                                    <?php endif; ?>
                                    <?php wp_reset_postdata(); ?>
                                    <?php wp_reset_query(); ?>

                                </div>

                                <?php // MAP VIEW ?>
                                <?php if(get_field('opt_event_display_map', 'option')): ?>

                                    <div class="tab-pane fade" id="view-map">

                                        <?php 

                                            $args_full = array(
                                                'post_type'      => 'evenement',
                                                'paged'          => $paged,
                                                'order'          => 'ASC',
                                                'meta_key'       => 'citeo_date_debut',
                                                'orderby'        => 'meta_value_num',
                                                'posts_per_page' => -1,
                                                'meta_query'     => array(
                                                    'relation' => 'AND',
                                                        array(
                                                            'key'     => 'citeo_date_fin',
                                                            'value'   => date('Ymd', strtotime( 'today' )),
                                                            'compare' => '>='
                                                        )
                                                )
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
                                                        

                                                        $date_format_month  = "F";
                                                        $date_format_day    = "d";
                                                        $unixtimestampDebut = strtotime(get_field('citeo_date_debut'));
                                                        $date_debut_jour    = date_i18n($date_format_day, $unixtimestampDebut);
                                                        $date_debut_mois    = date_i18n($date_format_month, $unixtimestampDebut);
                                                        $unixtimestampFin   = strtotime(get_field('citeo_date_fin'));
                                                        $date_fin_jour      = date_i18n($date_format_day, $unixtimestampFin);
                                                        $date_fin_mois      = date_i18n($date_format_month, $unixtimestampFin);

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
                                                        <?php if (!empty($unixtimestampDebut)): ?>
                                                            <div class="line-date">
                                                                <?php echo (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin))? 'Du':'Le';?>
                                                                <strong><?php echo $date_debut_jour; ?></strong> <?php echo $date_debut_mois; ?>
                                                                <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>
                                                                au <strong><?php echo $date_fin_jour; ?></strong> <?php echo $date_fin_mois; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if(has_post_thumbnail()): ?>
                                                            <div class="line-img">
                                                                <?php the_post_thumbnail('citeo-line', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="line-text">
                                                            <?php citeo_the_content('15'); ?>
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
                                                // if (typeof map === 'undefined') {
                                                //     map = new GMaps({
                                                //         div: '#event_map',
                                                //         lat: 48.89420,
                                                //         lng: 2.13472,
                                                //         zoom: 12
                                                //     });

                                                //     map.addMarker({
                                                //     lat: 48.89420,
                                                //     lng: 2.13472,
                                                //         title: 'événement',
                                                //         click: function(e) {
                                                //             //alert('You clicked in this marker');
                                                //         },
                                                //         infoWindow: {
                                                //             content: '<p>Description de l\'événement</p>'
                                                //         }
                                                //     });
                                                // }
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