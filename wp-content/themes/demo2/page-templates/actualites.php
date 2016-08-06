<?php
/*
Template Name: Actualités
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
                        'post_type'      => 'actualite',
                        'paged'          => $paged,
                        'order'          => 'DESC',
                        'orderby'        => 'published',
                        'posts_per_page' => get_field('opt_news_nb_per_page', 'option')
                    );

                    // Si les filtres sont présent
                    if ( isset($_GET['f']) && $_GET['f'] === "1" ) {

                        $themes = $_GET['themes'];

                        if(isset($themes) && !empty($themes) && is_array($themes)){
                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'thematique',
                                        'field'    => 'slug',
                                        'terms'    => $themes,
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

                    $wp_query = new WP_Query( $args );
                    $resultats_count = $wp_query->found_posts;
                ?>


                <div class="layout-content">

                    <div class="page-header" role="article">
                        <h1 class="title no-pull-xs pull-left"><?php the_title(); ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h1>
                        <?php if(get_field('opt_news_filters_activated', 'option') ): ?>
                            <button class="no-pull-xs pull-right btn btn-default " data-toggle="collapse" href="#collapseFilters">
                                Filtrer les actualités <i class="caret"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                    <?php if(get_field('opt_news_filters_activated', 'option') ): ?>
                        <div class="page-filters">
                            <div id="collapseFilters" class="panel-collapse collapse<?php if (isset($_GET['f']) && $_GET['f'] === "1" ): ?> in<?php endif; ?>">
                                <div class="panel panel-default">
                                    <form action="<?php the_permalink(); ?>" method="get">
                                    
                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="f" value="1">

                                        <div class="panel-body">
                                            <?php if(get_field('opt_news_display_thematic_filter', 'option') ): ?>
                                                <?php 
                                                    $args_terms = array(
                                                        'post_type'  => array('actualite'),
                                                        'orderby'    => 'name',
                                                        'order'      => 'ASC',
                                                        'hide_empty' => true,
                                                        'exclude'    => array(),
                                                    );
                                                    $terms = get_terms('thematique', $args_terms);
                                                    
                                                    if (isset($_GET['f']) && isset($_GET['themes']) && !empty($_GET['themes']) && is_array($_GET['themes'])) {
                                                       $themes = $_GET['themes'];
                                                    }
                                                    else {
                                                        $themes = array();
                                                    }
                                                ?>
                                                <?php foreach ($terms as $term): ?>

                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="themes[]" id="checkbox_<?=$term->slug; ?>" value="<?=$term->slug; ?>"<?php if (!empty($themes) && in_array($term->slug, $themes)): ?> checked="checked"<?php endif; ?>> <?=$term->name; ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
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

                        <div class="section-news">
                            <?php if($wp_query->have_posts()) : ?>
                                <div class="thumbnails">
                                    <div class="row">
                                        <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                                        <?php
                                            // get the event beginning date
                                            $date_format_month  = "F";
                                            $date_format_day    = "d";
                                            $unixtimestamp      = strtotime(get_field('citeo_date_debut'));
                                            $envent_date_day    = date_i18n($date_format_day, $unixtimestamp);
                                            $envent_date_month  = date_i18n($date_format_month, $unixtimestamp);
                                        ?>
                            
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="thumbnail">
                                                <?php if(has_post_thumbnail()): ?>
                                                <a href="<?php the_permalink(); ?>" class="thumbnail-img">
                                                    <?php the_post_thumbnail('citeo-thumbnail', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                                </a>
                                                <?php else: ?>
                                                <a href="<?php the_permalink(); ?>" class="thumbnail-img">
                                                    <img class="img-responsive" src="http://placehold.it/230x172/aaaaaa/&text=230x155" width="230" height="155" alt="">
                                                </a>
                                                <?php endif; ?>
                                                <div class="thumbnail-body">
                                                    <?php if (get_field('opt_general_display_categories', 'option') OR get_field('opt_general_display_publish_date', 'option')): ?>
                                                        <div class="thumbnail-info">
                                                            <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'thumbnail-meta') ); ?>

                                                            <?php if(get_field('opt_general_display_publish_date', 'option')): ?>
                                                                <p class="thumbnail-date" href=""><?php echo get_the_date( 'j F, Y' ); ?></p>
                                                            <?php endif; ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <h3 class="thumbnail-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    <p class="thumbnail-text">
                                                        <?php citeo_excerpt(15); ?> 
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>

                                <?php citeo_pagination(); ?>

                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php wp_reset_query(); ?>
                        </div>

                    </div>

                </div>
            </div>

            <?php get_sidebar(); ?>

        </div>
    </div>

    <?php get_footer(); ?>