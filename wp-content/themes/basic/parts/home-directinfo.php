<?php
$args = array(
    'post_type'         => 'breve',
    'posts_per_page'    => 4,
    'order'             => 'date',
    'orderby'           => 'DESC',
);
// The Query who get last posts
$last_posts = new WP_Query( $args );
?>

<?php if ($last_posts->have_posts()) : ?>
    <div class="section-brief">
        <h2 class="section-title">Direct info</h2>
        <div class="shortlines">
            <div class="row">
                <?php while ( $last_posts->have_posts() ) : $last_posts->the_post(); ?>
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="shortline">
                            <?php citeo_terms( get_the_id(), 'thematique' , array('class' => 'shortline-meta') ); ?>
                            <h3 class="shortline-title"><?php the_title(); ?></h3>
                            <p class="shortline-text"><?php citeo_excerpt(15); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div><!-- /.section-brief -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>