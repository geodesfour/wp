<?php
/*
Template Name: Publications
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
            
                <div class="layout-content" role="article">

                    <div class="page-header">
                        <h1 class="title no-pull-xs pull-left"><?php the_title(); ?></h1>
                    </div>

                    <?php if(get_the_content()): ?>
                        <div class="page-intro">
                            <?php echo get_the_content(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="page-content">

                        <div class="section-kiosque">
                            <?php 
                                $args = array(
                                    'post_type'  => array('publication'),
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => true,
                                    'exclude'    => array(),
                                    );
                                $terms = get_terms('type', $args);
                            ?>
                            <?php foreach ($terms as $key => $term): ?>
                                <?php
                                    $args = array(
                                        'post_type'      => 'publication',
                                        'posts_per_page' => -1,
                                        'meta_key'       => 'date_de_publication',
                                        'orderby'        => 'meta_value_num',
                                        'order'          => 'DESC',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'type',
                                                'field' => 'slug',
                                                'terms' => $term->slug
                                            )
                                        )
                                    );

                                    // The Query who get last items event cpt
                                    $publications = new WP_Query( $args );
                                    $resultats_count = $publications->found_posts;
                                ?>
                                <?php if ($publications->have_posts()) : ?>
               
                                    <h2 class="section-title" id="<?=$term->slug ?>"><?php echo $term->name; ?> <small><?=$resultats_count; ?> résultat<?php if($resultats_count > 1): ?>(s)<?php endif; ?></small></h2>

                                    <?php if (get_field('opt_kiosque_display_as_carousel', 'option')): ?>

                                        <div class="clearfix owl-carousel owl-carousel-inline" data-ride="owl-carousel" data-loop="false" data-dots="true" data-nav="false" data-responsive='{"0" : {"items" : 1}, "530" : {"items" : 2}, "800" : {"items" : 4}, "1200" : {"items" : 5, "nav" : true, "dots": false} }'>
                                        
                                            <?php while ( $publications->have_posts() ) : $publications->the_post(); ?>

                                            <?php
                                                $date_format_year      = "Y";
                                                $date_format_month     = "F";
                                                $date_format_day       = "d";
                                                $unixtimestamp         = strtotime(get_field('date_de_publication'));
                                                $envent_date_day       = date_i18n($date_format_day, $unixtimestamp);
                                                $envent_date_month     = date_i18n($date_format_month, $unixtimestamp);
                                                $envent_date_year      = date_i18n($date_format_year, $unixtimestamp);
                                                $citeo_fichier_publication    = get_field('citeo_fichier_publication');
                                                $citeo_lien_publication = get_field('citeo_lien_publication');
                                            ?>
                                               
                                            <div class="owl-content">
                                                <div class="thumbnail" style="height:auto;">
                                                    <div class="thumbnail-img" style="height:auto;">
                                                        <div class="thumbnail-hover">
                                                            <?php if ($citeo_lien_publication != ''): ?>
                                                                <a href="<?=$citeo_lien_publication; ?>" target="_blank" title="Lire la publication en ligne"><i class="fa fa-eye"></i></a>
                                                            <?php endif; ?>
                                                            <?php if ($citeo_fichier_publication != ''): ?>
                                                                <a href="<?=$citeo_fichier_publication['url']; ?>" target="_blank" title="Télécharger la publication"><i class="fa fa-download"></i></a>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if (has_post_thumbnail() ) : ?>
                                                            <?php the_post_thumbnail('citeo-publication', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <h3 class="thumbnail-title"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></h3>
                                                    <?php /*
                                                    <h3 class="thumbnail-title"><?php the_title(); ?></h3>
                                                    <p class="thumbnail-date"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></p>
                                                    */ ?>
                                                </div>
                                            </div>
                                            <?php endwhile; ?>

                                        </div>

                                    <?php else: ?>
                                        <div class="row">
                                            <?php while ( $publications->have_posts() ) : $publications->the_post(); ?>

                                            <?php
                                                $date_format_year      = "Y";
                                                $date_format_month     = "F";
                                                $date_format_day       = "d";
                                                $unixtimestamp         = strtotime(get_field('date_de_publication'));
                                                $envent_date_day       = date_i18n($date_format_day, $unixtimestamp);
                                                $envent_date_month     = date_i18n($date_format_month, $unixtimestamp);
                                                $envent_date_year      = date_i18n($date_format_year, $unixtimestamp);
                                                $citeo_fichier_publication    = get_field('citeo_fichier_publication');
                                                $citeo_lien_publication = get_field('citeo_lien_publication');
                                            ?>
                                               <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="thumbnail">
                                                        <div class="thumbnail-img">
                                                            <div class="thumbnail-hover">
                                                                <?php if ($citeo_lien_publication != ''): ?>
                                                                    <a href="<?=$citeo_lien_publication; ?>" target="_blank" title="Lire la publication en ligne"><i class="fa fa-eye"></i></a>
                                                                <?php endif; ?>
                                                                <?php if ($citeo_fichier_publication != ''): ?>
                                                                    <a href="<?=$citeo_fichier_publication['url']; ?>" target="_blank" title="Télécharger la publication"><i class="fa fa-download"></i></a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if (has_post_thumbnail() ) : ?>
                                                                <?php the_post_thumbnail('citeo-publication', array('style' => 'width:100%;height:auto;', 'class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <h3 class="thumbnail-title"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></h3>
                                                        <?php /*
                                                        <h3 class="thumbnail-title"><?php the_title(); ?></h3>
                                                        <p class="thumbnail-date"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></p>
                                                        */ ?>
                                                    </div>
                                                </div>


                                            <?php endwhile; ?>
                                        </div>

                                    <?php endif; ?>

                                    <hr>

                                <?php endif; ?>

                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php wp_reset_query(); ?>
                            
                        </div>

                    </div>
                    
                </div>
            </div>


        </div>
    </div>
    <?php get_footer(); ?>