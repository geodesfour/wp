    <?php $kiosques = get_field('citeo_carrousel_kiosque'); ?>
    
    <div class="section-header">
        <h2 class="section-title">Le kiosque</h2>
            <?php $page_kiosque = get_page_by_title( "Les publications" ); ?>
            <?php if($page_kiosque): ?>
            <a href="<?=get_permalink($page_kiosque->ID); ?>" class="btn btn-sm btn-yellow">Toutes les publications</a>
            <?php endif; ?>
    </div>
    <div id="js-publication-carousel" class="owl-carousel owl-carousel-inline">
        
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
                <div class="publication">
                    <div class="publication-img">

                        <div class="publication-hover">
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

                    <h3 class="publication-title"><?php the_title(); ?></h3>
                    <p class="publication-date"><?=ucfirst($envent_date_month); ?> <?=$envent_date_year; ?></p>

                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php wp_reset_postdata(); ?>