 <?php
    $args = array(
        'post_type'      => 'evenement',
        'posts_per_page' => 4,
        'order'          => 'ASC',
        'meta_key'       => 'citeo_date_debut',
        'orderby'        => 'meta_value_num',
        'meta_query'    => array(
            'relation' => 'AND',
            array(
                'key'     => 'citeo_date_fin',
                'value'   => date('Ymd', strtotime( 'today' )),
                'compare' => '>='
            )
        )
    );
    $last_posts = new WP_Query( $args );
?>
<?php if ($last_posts->have_posts()) : ?>   
    <div class="section-events">
        <h2 class="section-title">L'agenda</h2>
        <div class="shortlines">
            <div class="row">

                <?php while ( $last_posts->have_posts() ) : $last_posts->the_post(); ?>
                <?php
                    // get the event beginning date
                    $date_format_month = "F";
                    $date_format_day   = "d";

                    $unixtimestampDebut = strtotime(get_field('citeo_date_debut'));
                    $date_debut_jour   = date_i18n($date_format_day, $unixtimestampDebut);
                    $date_debut_mois = date_i18n($date_format_month, $unixtimestampDebut);

                    $unixtimestampFin = strtotime(get_field('citeo_date_fin'));
                    $date_fin_jour   = date_i18n($date_format_day, $unixtimestampFin);
                    $date_fin_mois = date_i18n($date_format_month, $unixtimestampFin);
                ?>
                    <div class="col-lg-12 col-md-6 col-xs-12">
                        <div class="shortline">
                        
                            <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'shortline-meta') ); ?>

                            <?php if ($date_debut_mois && $date_debut_jour): ?>
                                
                                <div class="shortline-date">
                                    <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>Du<?php else: ?>Le<?php endif; ?> 
                                    <strong><?php echo $date_debut_jour; ?></strong> <?php echo $date_debut_mois; ?>
                                    <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>
                                        au <strong><?php echo $date_fin_jour; ?></strong> <?php echo $date_fin_mois; ?>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>
                            <h3 class="shortline-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="shortline-text"><?php citeo_excerpt('20'); ?></p>

                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>
    </div><!-- /.section-events -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>