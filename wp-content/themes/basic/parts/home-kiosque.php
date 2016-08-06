    <?php $kiosques = get_field('citeo_carrousel_kiosque'); ?>
    <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid ">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>   
        <div class="row">
            <div class="col-lg-2 col-xs-12">
                <div class="section-heading">
                    <img src="<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/icon-kiosque.png" alt="">
                    <h3 class="section-title">Kiosque</h3>
                </div>
            </div>
            <div class="col-lg-10 col-xs-12">
                <div class="owl-carousel owl-carousel-inline" data-ride="owl-carousel" data-dots="true" data-nav="false" data-responsive='{"0" : {"items" : 1}, "530" : {"items" : 2}, "800" : {"items" : 4}, "1200" : {"items" : 5, "nav" : true, "dots": false} }'>
                    
                    <?php foreach ($kiosques as $post) : setup_postdata($post); ?>
                        <?php
                            // Link acf fields : links
                            $citeo_fichier_publication    = get_field('citeo_fichier_publication');
                            $citeo_lien_publication = get_field('citeo_lien_publication');

                            $date_format_year      = "Y";
                            $date_format_month     = "F";
                            $date_format_day       = "d";
                            $unixtimestamp         = strtotime(get_field('date_de_publication'));
                            $envent_date_day       = date_i18n($date_format_day, $unixtimestamp);
                            $envent_date_month     = date_i18n($date_format_month, $unixtimestamp);
                            $envent_date_year      = date_i18n($date_format_year, $unixtimestamp);
                        ?>
                        <?php if( $citeo_fichier_publication ||  $citeo_lien_publication): ?>
                        <div class="owl-content">
                            <div class="thumbnail">
                                <div class="thumbnail-img">

                                    <div class="thumbnail-hover">
                                        <?php if ($citeo_lien_publication != ''): ?>
                                            <a href="<?=$citeo_lien_publication; ?>" target="_blank" title="Lire la publication en ligne"><i class="fa fa-eye"></i></a>
                                        <?php endif; ?>
                                        <?php if ($citeo_fichier_publication['url'] != ''): ?>
                                            <a href="<?=$citeo_fichier_publication['url']; ?>" target="_blank" title="Télécharger la publication"><i class="fa fa-download"></i></a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ( has_post_thumbnail() ): ?>
                                        <?php the_post_thumbnail('citeo-publication', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                                    <?php else: ?>
                                        <img class="img-responsive" data-src="holder.js/169x220/auto/sky/" width="169" height="220" alt="">
                                    <?php endif; ?>

                                </div>

                                <h3 class="thumbnail-title"><?php the_title(); ?></h3>
                                <p class="thumbnail-date"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></p>

                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

    <?php wp_reset_postdata(); ?>