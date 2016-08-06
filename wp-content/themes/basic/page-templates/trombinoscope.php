<?php
/*
Template Name: Trombinoscope
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
                <?php $elu = get_field('elus_mis_en_avant'); ?>
                <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                    $tax_query = array();
                    $meta_query = array();
                    $type_query = 'AND';

                    // $exclude_id = $elu->ID;
                    if (isset($elu->ID) && !empty($elu->ID) && !isset($_GET['f'])) {
                        $args = array(
                            'post_type'      => 'fiche-trombinoscope',
                            'paged'          => $paged,
                            'posts_per_page' => get_field('opt_trombinoscope_nb_per_page', 'option'),
                            'order'          => 'ASC',
                            'orderby'        => 'menu_order',
                            'post__not_in'   => array($elu->ID)
                        );
                    } else {
                        $args = array(
                            'post_type'      => 'fiche-trombinoscope',
                            'paged'          => $paged,
                            'posts_per_page' => get_field('opt_trombinoscope_nb_per_page', 'option'),
                            'order'          => 'ASC',
                            'orderby'        => 'menu_order'
                        );
                    }

                    // Si les filtres sont présent
                    if (isset($_GET['f']) && $_GET['f'] == 1) {

                        // Si le champ delegation est présent
                        if ( isset($_GET['delegation']) && !empty($_GET['delegation']) ) {

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'delegation',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['delegation'],
                                    );

                        }

                        // Si le champ parti-politique est présent
                        if ( isset($_GET['parti-politique']) && !empty($_GET['parti-politique']) ) {

                            // On complète la tax_query
                            $tax_query[] = array(
                                        'taxonomy' => 'parti-politique',
                                        'field'    => 'slug',
                                        'terms'    => $_GET['parti-politique'],
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

                    $wp_query = new WP_Query( $args );
                    $resultats_count = $wp_query->found_posts;
                ?>

                <div class="layout-content" role="article"> 

                    <div class="page-header">
                        <h1 class=" title pull-xs-none pull-left"><?php the_title(); ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h1>
                        <?php if(get_field('opt_trombinoscope_filters_activated', 'option') ): ?>
                            <div class="pull-xs-none pull-right">
                                <button class="btn btn-default" data-toggle="collapse" href="#collapseFilters">
                                    Filtrer les élus &nbsp;<i class="caret"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if(get_field('opt_trombinoscope_filters_activated', 'option') ): ?>
                        <div class="page-filters">
                            <div id="collapseFilters" class="panel-collapse collapse<?php if (isset($_GET['f']) && $_GET['f'] ): ?> in<?php endif; ?>">
                                <div class="panel panel-default">
                                    <form action="<?php the_permalink(); ?>" class="form-horizontal">

                                        <input name="utf8" type="hidden" value="&#x2713;" />
                                        <input type="hidden" name="f" value="1">

                                        <div class="panel-body">
                                            
                                            <?php if(get_field('opt_trombinoscope_display_search_filter', 'option') ): ?>
                                                <div class="form-group">
                                                    <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="">Rechercher :</label>
                                                    <div class="col-md-5 col-sm-8 col-xs-12">
                                                        <input type="text" name="search-text" class="form-control" id="search-text" placeholder="Entrez un nom" <?php if ( isset($_GET['search-text']) && !empty($_GET['search-text']) ): ?> value="<?php echo $_GET['search-text']; ?>"<?php endif; ?>>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <?php if(get_field('opt_trombinoscope_display_delegation_filter', 'option') ): ?>
                                                <div class="form-group">
                                                    <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="">Par commission :</label>
                                                    <div class="col-md-5 col-sm-8 col-xs-12">
                                                         <select name="delegation" id="delegation" class="form-control">
                                                        
                                                            <?php 
                                                                $args = array(
                                                                    'post_type'  => array('fiche-trombinoscope'),
                                                                    'orderby'    => 'name',
                                                                    'order'      => 'ASC',
                                                                    'hide_empty' => true,
                                                                    'exclude'    => array(),
                                                                );
                                                                $terms = get_terms('delegation', $args);

                                                                $get_terms = array();
                                                                if (isset($_GET['f']) && isset($_GET['delegation']) && !empty($_GET['delegation'])) {
                                                                    $get_terms = $_GET['delegation'];
                                                                }
                                                            ?>
                                                            <option value="">Choisissez une commission</option>

                                                            <?php foreach ($terms as $term): ?>
                                                                <option value="<?=$term->slug; ?>"<?php if (!empty($_GET['delegation']) && $_GET['delegation'] == $term->slug): ?> selected="selected"<?php endif; ?>><?=$term->name; ?></option>
                                                            <?php endforeach; ?>

                                                        </select>

                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <?php if(get_field('opt_trombinoscope_display_party_filter', 'option') ): ?>
                                                <div class="form-group">
                                                    <label class="col-md-5 col-sm-3 col-xs-12 control-label" for="">Par parti politique :</label>
                                                    <div class="col-md-5 col-sm-8 col-xs-12">
                                                         <select name="parti-politique" id="parti-politique" class="form-control">
                                                        
                                                            <?php 
                                                                $args = array(
                                                                    'post_type'  => array('fiche-trombinoscope'),
                                                                    'orderby'    => 'name',
                                                                    'order'      => 'ASC',
                                                                    'hide_empty' => true,
                                                                    'exclude'    => array(),
                                                                );
                                                                $terms = get_terms('parti-politique', $args);

                                                                $get_terms = array();
                                                                if (isset($_GET['f']) && isset($_GET['parti-politique']) && !empty($_GET['parti-politique'])) {
                                                                    $get_terms = $_GET['parti-politique'];
                                                                }
                                                            ?>
                                                            <option value="">Choisissez un parti politique</option>

                                                            <?php foreach ($terms as $term): ?>
                                                                <option value="<?=$term->slug; ?>"<?php if (!empty($_GET['parti-politique']) && $_GET['parti-politique'] == $term->slug): ?> selected="selected"<?php endif; ?>><?=$term->name; ?></option>
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

                        <div class="section-elus">
                            
                            <?php if (isset($elu) && !empty($elu) && !isset($_GET['f'])): ?>
                                <?php
                                    $args = array(
                                        'post_type' => 'fiche-trombinoscope',
                                        'p'         => $elu->ID
                                    );

                                    $elus = new WP_Query( $args );
                                ?>
                                <?php if ($elus->have_posts()) : ?>
                                    
                                    <div class="row">

                                        <?php while ( $elus->have_posts() ) : $elus->the_post(); ?>
                                            <?php
                                                $elu_birthday = '';
                                                if( get_field('citeo_date_trombi')){
                                                    $elu_birthday = date( 'd/m/Y',strtotime(get_field('citeo_date_trombi')));
                                                }
                                               
                                                $elu_fonction = get_field('citeo_fonction_trombi');

                                                $elu_groupe = get_field('citeo_groupe_trombi');
                                                if ($elu_groupe == 'majorite') {
                                                    $elu_groupe = 'Majorité';
                                                } elseif($elu_groupe == 'opposition') {
                                                    $elu_groupe = 'Opposition';
                                                } else {
                                                    $elu_groupe = '';
                                                }
                                                $elu_profession = get_field('citeo_profession_trombi');
                                                $elu_accroche = get_field('citeo_accroche_trombi');
                                                $elu_tel = get_field('citeo_tel_trombi');
                                                $elu_mail = get_field('citeo_mail_trombi');
                                                $elu_site = get_field('citeo_site_trombi');
                                                $elu_twitter = get_field('citeo_twitter_trombi');
                                                $elu_fbck = get_field('citeo_fbck_trombi');
                                                $elu_google = get_field('citeo_google_trombi');
                                                $thumbnail_format = get_field('opt_trombinoscope_thumbnail_format', 'option');
                                            ?>

                                            <div class="col-lg-12">
                                                <div class="portrait portrait-lg">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <?php if (has_post_thumbnail() ) : ?> 
                                                                <a href="" class="portrait-img" data-toggle="modal" data-target="#modalPortrait<?php the_id(); ?>">
                                                                    <?php if($thumbnail_format == 'rectangular'): ?>
                                                                        <?php the_post_thumbnail('citeo-portrait', array('class' => 'img-responsive', 'alt' => get_the_title()) ); ?>
                                                                    <?php elseif($thumbnail_format == 'square'): ?>
                                                                        <?php the_post_thumbnail('citeo-portrait-square', array('class' => 'img-responsive', 'alt' => get_the_title()) ); ?>
                                                                    <?php else: ?>
                                                                        <?php the_post_thumbnail('citeo-portrait-square', array('class' => 'img-responsive img-circle', 'alt' => get_the_title()) ); ?>
                                                                    <?php endif; ?>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                        <!-- Peut-être ajouter le bloc pour la photo  -->
                                                        <div class="col-md-8">
                                                            <h3 class="portrait-title"><a href="" data-toggle="modal" data-target="#modalPortrait<?php the_id(); ?>"><?php the_title(); ?></a></h3>
                                                            <p class="portrait-info"><?php echo $elu_fonction; ?></p>
                                                            <?php if ($elu_accroche): ?>
                                                                <blockquote>
                                                                    <?php echo $elu_accroche; ?>
                                                                </blockquote>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="modalPortrait<?php the_id(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPortraitLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                                                            <h4 class="modal-title" id="modalPortraitLabel"><?php the_title(); ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <?php if (has_post_thumbnail() ) : ?> 
                                                                    <div class="col-md-3">
                                                                        <?php the_post_thumbnail('citeo-portrait', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                <?php else: ?>
                                                                    <div class="col-md-12">
                                                                <?php endif; ?>
                                                                <?php the_content(); ?>

                                                                <?php if(!empty($elu_fonction) OR !empty($elu_groupe) OR !empty($elu_birthday) OR !empty($elu_profession)): ?>
                                                                    <h3 class="hidden">Biographie :</h3>
                                                                    <p>
                                                                    <?php if(!empty($elu_fonction)): ?>
                                                                        <strong>Fonction/Mandat :</strong> <?php echo $elu_fonction; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_groupe)): ?>
                                                                        <strong>Groupe politique :</strong> <?php echo $elu_groupe; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_birthday) && $elu_birthday != '01/01/1970'): ?>
                                                                        <strong>Date de naissance :</strong> <?php echo $elu_birthday; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_profession)): ?>
                                                                        <strong>Profession :</strong> <?php echo $elu_profession; ?><br>
                                                                    <?php endif; ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                
                                                                <?php if(!empty($elu_tel) OR !empty($elu_mail) OR !empty($elu_site) OR !empty($elu_twitter) OR !empty($elu_fbck) OR !empty($elu_google)): ?>
                                                                    <h3 class="hidden">Contact :</h3>
                                                                    <p>
                                                                    <?php if(!empty($elu_tel)): ?>
                                                                        <strong>Téléphone :</strong> <?php echo $elu_tel; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_mail)): ?>
                                                                        <strong>Email :</strong> <a href="mailto:<?php echo $elu_mail; ?>"><?php echo $elu_mail; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_site)): ?>
                                                                        <strong>Site internet :</strong> <a href="<?php echo $elu_site; ?>" target="_blank"><?php echo $elu_site; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_twitter)): ?>
                                                                        <strong>Compte Twitter :</strong> <a href="https://twitter.com/<?php echo $elu_twitter; ?>" target="_blank"><?php echo $elu_twitter; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_fbck)): ?>
                                                                        <strong>Compte Facebook :</strong> <a href="https://www.facebook.com/<?php echo $elu_fbck; ?>" target="_blank"><?php echo $elu_fbck; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_google)): ?>
                                                                        <strong>Compte Google+ :</strong> <a href="https://plus.google.com/+<?php echo $elu_google; ?>" target="_blank"><?php echo $elu_google; ?></a><br>
                                                                    <?php endif; ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        <?php endwhile; ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>


                            
                            <?php if ($wp_query->have_posts()) : ?>

                                <div class="row">
                                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                                        <?php

                                            $elu_birthday = '';
                                            if( get_field('citeo_date_trombi')){
                                                $elu_birthday = date( 'd/m/Y',strtotime(get_field('citeo_date_trombi')));
                                            }
                                            $elu_fonction = get_field('citeo_fonction_trombi');
                                            $elu_groupe = get_field('citeo_groupe_trombi');
                                            if ($elu_groupe == 'majorite') {
                                                $elu_groupe = 'Majorité';
                                            } elseif($elu_groupe == 'opposition') {
                                                $elu_groupe = 'Opposition';
                                            } else {
                                                $elu_groupe = '';
                                            }
                                            $elu_profession = get_field('citeo_profession_trombi');
                                            $elu_accroche = get_field('citeo_accroche_trombi');
                                            $elu_tel = get_field('citeo_tel_trombi');
                                            $elu_mail = get_field('citeo_mail_trombi');
                                            $elu_site = get_field('citeo_site_trombi');
                                            $elu_twitter = get_field('citeo_twitter_trombi');
                                            $elu_fbck = get_field('citeo_fbck_trombi');
                                            $elu_google = get_field('citeo_google_trombi');
                                            $thumbnail_format = get_field('opt_trombinoscope_thumbnail_format', 'option');
                                        ?>

                                        <div class="col-lg-4 col-md-4 col-sm-6">
                                            <div class="portrait">
                                                <?php if (has_post_thumbnail() ) : ?>
                                                    <a href="" class="portrait-img" data-toggle="modal" data-target="#modalPortrait<?php the_id(); ?>">
                                                        <?php if($thumbnail_format == 'rectangular'): ?>
                                                            <?php the_post_thumbnail('citeo-portrait', array('class' => 'img-responsive', 'alt' => get_the_title()) ); ?>
                                                        <?php elseif($thumbnail_format == 'square'): ?>
                                                            <?php the_post_thumbnail('citeo-portrait-square', array('class' => 'img-responsive', 'alt' => get_the_title()) ); ?>
                                                        <?php else: ?>
                                                            <?php the_post_thumbnail('citeo-portrait-square', array('class' => 'img-responsive img-circle', 'alt' => get_the_title()) ); ?>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>

                                                <h3 class="portrait-title"><a href="#" data-toggle="modal" data-target="#modalPortrait<?php the_id(); ?>"><?php the_title(); ?></a></h3>
                                                <p class="portrait-info"><?php echo $elu_fonction; ?></p>
                                                <?php if ($elu_accroche): ?>
                                                    <blockquote>
                                                        <?php echo $elu_accroche; ?>
                                                    </blockquote>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalPortrait<?php the_id(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPortraitLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                                                        <h4 class="modal-title" id="modalPortraitLabel"><?php the_title(); ?></h4>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <?php if (has_post_thumbnail() ) : ?> 
                                                                    <div class="col-md-3">
                                                                        <?php the_post_thumbnail('citeo-portrait', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                <?php else: ?>
                                                                    <div class="col-md-12">
                                                                <?php endif; ?>
                                                                <?php the_content(); ?>

                                                                <?php if(!empty($elu_fonction) OR !empty($elu_groupe) OR !empty($elu_birthday) OR !empty($elu_profession)): ?>
                                                                    <h3 class="hidden">Biographie :</h3>
                                                                    <p>
                                                                    <?php if(!empty($elu_fonction)): ?>
                                                                        <strong>Fonction/Mandat :</strong> <?php echo $elu_fonction; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_groupe)): ?>
                                                                        <strong>Groupe politique :</strong> <?php echo $elu_groupe; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_birthday)): ?>
                                                                        <strong>Date de naissance :</strong> <?php echo $elu_birthday; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_profession)): ?>
                                                                        <strong>Profession :</strong> <?php echo $elu_profession; ?><br>
                                                                    <?php endif; ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                
                                                                <?php if(!empty($elu_tel) OR !empty($elu_mail) OR !empty($elu_site) OR !empty($elu_twitter) OR !empty($elu_fbck) OR !empty($elu_google)): ?>
                                                                    <h3 class="hidden">Contact :</h3>
                                                                    <p>
                                                                    <?php if(!empty($elu_tel)): ?>
                                                                        <strong>Téléphone :</strong> <?php echo $elu_tel; ?><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_mail)): ?>
                                                                        <strong>Email :</strong> <a href="mailto:<?php echo $elu_mail; ?>"><?php echo $elu_mail; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_site)): ?>
                                                                        <strong>Site internet :</strong> <a href="<?php echo $elu_site; ?>" target="_blank"><?php echo $elu_site; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_twitter)): ?>
                                                                        <strong>Compte Twitter :</strong> <a href="https://twitter.com/<?php echo $elu_twitter; ?>" target="_blank"><?php echo $elu_twitter; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_fbck)): ?>
                                                                        <strong>Compte Facebook :</strong> <a href="https://www.facebook.com/<?php echo $elu_fbck; ?>" target="_blank"><?php echo $elu_fbck; ?></a><br>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($elu_google)): ?>
                                                                        <strong>Compte Google+ :</strong> <a href="https://plus.google.com/+<?php echo $elu_google; ?>" target="_blank"><?php echo $elu_google; ?></a><br>
                                                                    <?php endif; ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
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

            <?php get_sidebar(); ?>

        </div>
    </div>
    <?php get_footer(); ?>