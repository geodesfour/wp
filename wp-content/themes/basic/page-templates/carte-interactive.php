<?php
/*
Template Name: Plan de la ville
*/
?>

    <?php get_header(); ?>


   <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>

        <div class="row">

            <div class="col-xs-12">


            <?php wp_reset_query(); ?>
            <?php 
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                $tax_query = array();
                $meta_query = array();
                $type_query = 'AND';

                $args = array(
                    'post_type'      => 'map_marker',
                    'paged'          => $paged,
                    'posts_per_page' => -1
                );

                // Si les filtres sont présent
                if ( isset($_GET['f']) && $_GET['f'] === "1" ) {

                    if(isset($_GET['categories']) && !empty($_GET['categories']) && is_array($_GET['categories'])){
                        // On complète la tax_query
                        $tax_query[] = array(
                                    'taxonomy' => 'category_map',
                                    'field'    => 'slug',
                                    'terms'    => $_GET['categories'],
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
                //tool_output($args);
                $wp_query = new WP_Query( $args );
                $resultats_count = $wp_query->found_posts;
            ?>
     
                <div class="layout-content" role="article">

                    <div class="page-header">
                        <h1 class="title no-pull-xs pull-left"><?php the_title(); ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h1>
                    </div>

                    <?php if(get_the_content()): ?>
                        <div class="page-intro">
                            <?php echo get_the_content(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="section-interactive-map">
                        <div class="row">
                            <?php //if(get_field('opt_news_filters_activated', 'option') ): ?>
                            <?php // @TODO : rename it ?>

                            <div class="col-md-3 col-xs-12">
                                <div class="page-filters">

                                        <div class="panel panel-default">
                                            <form action="<?php the_permalink(); ?>" method="get">
                                            
                                                <input name="utf8" type="hidden" value="&#x2713;" />
                                                <input type="hidden" name="f" value="1">

                                                <div class="panel-body">
                                                        <?php 
                                                            $args_terms = array(
                                                                'post_type'  => array('map_marker'),
                                                                'orderby'    => 'name',
                                                                'order'      => 'ASC',
                                                                'hide_empty' => true,
                                                                'exclude'    => array(),
                                                            );
                                                            $terms = get_terms('category_map', $args_terms);

                                                            $categories = array();
                                                            if (isset($_GET['f']) && $_GET['f'] === "1" && isset($_GET['categories']) && !empty($_GET['categories']) && is_array($_GET['categories'])) {
                                                               $categories = $_GET['categories'];
                                                            }
                                                        ?>
                                                        <?php foreach ($terms as $term): ?>

                                                            <?php 
                                                                $pattern = $term->taxonomy.'_'.$term->term_id;
                                                                $icon = get_field('icone', $pattern);
                                                                if($icon)
                                                                    $icon = $icon['url'];

                                                             ?>
                                                            <div class="col-xs-12">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="categories[]" id="checkbox_<?=$term->slug; ?>" value="<?=$term->slug; ?>"<?php if (!empty($categories) && in_array($term->slug, $categories)): ?> checked="checked"<?php endif; ?>> <?=$term->name; ?>
                                                                        <?php if(!empty($icon)): ?>
                                                                            <img src="<?=$icon?>" alt="" height="24" width="" />
                                                                        <?php endif; ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                </div>
                                                <div class="panel-footer text-right">
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-default">Réinitialiser</a>
                                                    <input type="submit" class="btn btn-primary" value="Valider">
                                                </div>
                                            </form>
                                        </div>
                                </div>
                            </div>
                            <?php //endif; ?>

                            <div class="col-md-9">
                                <div class="section-map-interactive">
                            
                                <?php if($wp_query->have_posts()) : ?>

                                    <div class="google-map">
                                        <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                                        <?php
                                            $location = get_field('location');
                                            //tool_output($location);
                                            if($location){
                                                $lat = $location['lat'];
                                                $lng = $location['lng'];
                                                $address = $location['address'];
                                            }

                                            $kml = get_field('kml');
                                            if($kml)
                                                    $kml = $kml['url'];
                                            $terms = get_the_terms(get_the_ID(), 'category_map');
                                            $icon = '';
                                        ?>
                                        <?php 
                                        if(!empty($terms) && count($terms) > 0){
                                            foreach($terms as $term){
                                                // pattern "{$term->taxonomy}_{$term->term_id}" 
                                                // @SEE: http://www.advancedcustomfields.com/resources/get-values-from-a-taxonomy-term/
                                                $pattern = $term->taxonomy.'_'.$term->term_id;
                                                $icon = get_field('icone', $pattern);
                                                if($icon)
                                                    $icon = $icon['url'];
                                                break;
                                            }
                                        }
                                        ?>

                                        <div class="marker hidden" data-kml="<?=$kml ?>" data-icon-marker="<?=$icon ?>" data-lat="<?=$lat ?>" data-lng="<?=$lng ?>">
                                            <div class="infowindow">
                                                <h3><?php the_title(); ?></h3>
                                                <?php citeo_terms( get_the_id(), 'category_map' , array('class' => 'thumbnail-meta') ); ?>

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
                                                <?php /*
                                                    @TODO:
                                                    <p class="itineraire-bulle">Itinéraire : <a class="itineraire itineraire-aller" data-address="47.539386914287626,-2.3237772552947717">Partir de ce lieu</a> - <a class="itineraire itineraire-retour" data-address="47.539386914287626,-2.3237772552947717">Aller vers ce lieu</a></p>

                                                    @SEE: http://www.marzan.fr/plan-interactif/
                                                */ ?>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    </div><!-- /.google-map -->


                                <?php endif; ?>

                                <?php wp_reset_postdata(); ?>
                                <?php wp_reset_query(); ?>

                                </div>
                            </div>
                        </div>
                </div>

            </div>


        </div>
    </div>


    <?php get_footer(); ?>