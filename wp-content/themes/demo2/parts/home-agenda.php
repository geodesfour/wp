 <?php
    $args = array(
        'post_type'      => 'evenement',
        'posts_per_page' => 3,
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
        <div class="section-header">
            <h2 class="section-title">L'agenda</h2>
            <?php $page_agenda = get_page_by_title( "L'agenda" ); ?>
            <?php if($page_agenda): ?>
            <a href="<?=get_permalink($page_agenda->ID); ?>" class="btn btn-sm btn-red">Tout l'agenda</a>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-6 col-xs-12">

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
                            <div class="col-md-12 col-xs-12">
                                <div class="shortline">

                                    <?php if (has_post_thumbnail() ) : ?> 
                                        <a href="<?php the_permalink(); ?>" class="shortline-img"><?php the_post_thumbnail( 'citeo-shortline', array('class'=>'img-responsive', 'width'=>'103', 'height'=>'158', 'alt' => get_the_title() ) ); ?></a>
                                    <?php endif; ?>
                                    
                                    <div class="shortline-body">
                                        <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'shortline-meta') ); ?>
                                        
                                        <h3 class="shortline-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                        <?php if ($date_debut_mois && $date_debut_jour): ?>
                                            
                                            <div class="shortline-date">
                                                <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>Du<?php else: ?>Le<?php endif; ?> 
                                                <strong><?php echo $date_debut_jour; ?></strong> <?php echo $date_debut_mois; ?>
                                                <?php if (($unixtimestampDebut != $unixtimestampFin) && !empty($unixtimestampFin)): ?>
                                                    au <strong><?php echo $date_fin_jour; ?></strong> <?php echo $date_fin_mois; ?>
                                                <?php endif; ?>
                                            </div>

                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </div>

            <?php 
                // Get the interactive map page from the permalink
                $agenda_page = get_pages(array('meta_key' => '_wp_page_template','meta_value' => 'page-templates/evenements.php'));
                $link_agenda_page = get_permalink($agenda_page['0']->ID);
            ?>
            <div class="col-lg-12 col-md-6 col-xs-12">
                <div class="panel panel-search">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rechercher <span class="bold">un événement</span></h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?=$link_agenda_page ?>" method="GET" role="form">
                            <input name="utf8" type="hidden" value="&#x2713;" />
                            <input type="hidden" name="f" value="1">

                            <div class="form-group">
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
                                ?>
                                    <option value="">Quoi ?</option>
                                    <?php foreach ($terms as $term): ?>
                                        <option value="<?php echo $term->slug; ?>"<?php if (!empty($_GET['theme']) && $_GET['theme'] == $term->slug): ?> selected="selected"<?php endif; ?>><?php echo $term->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if(get_field('opt_event_display_place_filter', 'option')): ?>
                            <div class="form-group">
                                <select name="lieu" id="lieu" class="form-control">
                                    <option value="">Où ?</option>
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
                            <?php endif; ?>
                            <div class="form-group">
                                <select name="date" id="date" class="form-control">
                                    <option value="">Quand ?</option>
                                    <option value="aujourdhui">Aujourd'hui</option>
                                    <option value="semaine">Cette semaine</option>
                                    <option value="weekend">Ce week-end</option>
                                    <option value="mois">Ce mois-ci</option>
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-black">Rechercher</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.section-events -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>