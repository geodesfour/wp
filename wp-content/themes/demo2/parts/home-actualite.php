<?php $actus_star = get_field('citeo_actu_star'); ?>

<?php if ($actus_star) : ?>
    <div class="section-news">
        <div class="section-header">
            <h2 class="section-title">L'actualité</h2>
            <?php $page_news = get_page_by_title( "Les actualités" ); ?>
            <?php if($page_news): ?>
            <a href="<?=get_permalink($page_news->ID); ?>" class="btn btn-sm btn-red">Toute l'actualite</a>
            <?php endif; ?>
        </div>
        <div class="row">

    <?php foreach( $actus_star as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>


        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="thumbnail">

                 <?php if (has_post_thumbnail() ) : ?> 
                <a href="<?php the_permalink(); ?>" class="thumbnail-img">
                        <?php the_post_thumbnail( 'citeo-thumbnail', array('class'=>'img-responsive', 'alt' => get_the_title() ) ); ?>
                </a>
                <?php endif; ?>
                <div class="thumbnail-body">
                    <?php if (get_field('opt_general_display_categories', 'option') OR get_field('opt_general_display_publish_date', 'option')): ?>
                        <div class="thumbnail-info">
                            <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'thumbnail-meta') ); ?>

                            <?php if(get_field('opt_general_display_publish_date', 'option')): ?>
                                <p class="thumbnail-date"><?php echo get_the_date( 'j F, Y' ); ?></p>
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

    <?php endforeach; ?>

    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

        </div>
    </div><!-- /.section-news -->

<?php endif; ?>