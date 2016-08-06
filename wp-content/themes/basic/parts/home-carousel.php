<?php $slides = get_field( "citeo_carrousel" ); ?>
<?php if ($slides): ?>
    
    <?php
        $carousel_opt = '';

        if( get_field('opt_general_displayed_nav', 'option') == 'puces' OR get_field('opt_general_displayed_nav', 'option') == 'puces-fleches' ) {
            $carousel_opt .= ' data-dots="true"';
        } else {
            $carousel_opt .= ' data-dots="false"';
        }

        if( get_field('opt_general_displayed_nav', 'option') == 'fleches'  OR get_field('opt_general_displayed_nav', 'option') == 'puces-fleches' ) {
            $carousel_opt .= ' data-nav="true"';
        } else {
            $carousel_opt .= ' data-nav="false"';
        }

        if( get_field('opt_general_automatic_carrousel', 'option')) {
            $carousel_opt .= ' data-autoplay="true" data-autoplay-timeout="4500"';
        } else {
            $carousel_opt .= ' data-autoplay="false"';
        }
    ?>

    <div class="section-slideshow">
        <div class="owl-carousel owl-carousel-large"<?php if(count($slides) == 1): ?> data-loop="false"<?php endif; ?> data-ride="owl-carousel"<?=$carousel_opt; ?>>
            

            <?php foreach($slides as $post): ?>
                <?php setup_postdata($post); ?>

                
                    <?php if (has_post_thumbnail() ) : ?>

                        <a href="<?php the_permalink(); ?>" class="owl-content">
                            <?php the_post_thumbnail('citeo-slideshow', array('class'=>'owl-img', 'alt' => get_the_title() )); ?>
                            <div class="owl-body">
                                <h3 class="owl-title"><?php the_title(); ?></h3>
                                <div class="owl-text">
                                    <?php citeo_excerpt(22); ?>
                                </div>
                            </div>
                        </a>

                    <?php endif; ?>

            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>


        </div>
    </div>

<?php endif; ?>
