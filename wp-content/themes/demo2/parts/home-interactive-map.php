<?php 

// Get All selected terms from frontpage page
$selected_terms = get_field('citeo_interactive_map');
//tool::output($selected_terms);

// Get only the ID's
/*$terms_id = array();
foreach($selected_terms as $selected_term){
	$terms_id[] = $selected_term;
}*/

// Launch a resquest to get all items corresponding to theses terms ID's
$args = array(
    'post_type'      => 'map_marker',
    'paged'          => $paged,
    'posts_per_page' => -1,
    'relation' => 'AND',
    'tax_query' => array(
                    'taxonomy' => 'category_map',
                    'field'    => 'slug',
                    'terms'    => $terms_id,
                )
);

$map_query = new WP_Query( $args );

//tool::output($map_query);

// Grab all terms from the category_map taxonomy
$args_terms = array(
        'post_type'  => array('map_marker'),
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true,
        'exclude'    => array(),
);
$all_terms = get_terms('category_map', $args_terms);

?>
	

	<div class="section-interactive-map">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="box-white">
				
					    <div class="section-header">
    						<h2 class="section-title">Près de chez vous</h2>
						</div>

						<div class="lead">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sodales hendrerit nulla, ac vulputate ligula bibendum vel.
						</div>

						<?php 
							// Get the interactive map page from the permalink
							$map_page = get_pages(array('meta_key' => '_wp_page_template','meta_value' => 'page-templates/carte-interactive.php'));
							$link_map_page = get_permalink($map_page['0']->ID);
						?>
						<form action="<?=$link_map_page ?>" method="GET" role="form" id="map-form">
		                    <input name="utf8" type="hidden" value="&#x2713;" />
                            <input type="hidden" name="f" value="1">

							<div class="form-group">
								<label for="map-category-select" class="sr-only">Catégories</label>
								<select class="form-control" name="categories[]" id="map-category-select">
									<option value="">Choisissez un type d'équipement</option>
									<?php foreach($all_terms as $term): ?>
									<option value="<?=$term->slug; ?>"><?=$term->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="form-group text-right">
								<button type="submit" class="btn btn-orange">Recherche</button>
							</div>
						</form>
						<?php 
						/**
						 * @todo : In javascript submit form on select change
						 */
						?>
						<script>
							$(document).ready(function(){
								$('#map-category-select').on('change', function(){
									// var value = $(this).val();
									// $('#map-form').submit();
								});
							});
						</script>
						<div class="text-right">
							<a href="<?=$link_map_page ?>" class="btn btn-white">Tous les équipements</a>
							<a href="<?=$link_map_page ?>?utf8=✓&amp;f=1&amp;categories%5B%5D=infos-travaux" class="btn btn-outline-red"><i class="fa fa-warning"></i> Infos travaux</a>
						</div>

					</div>
				</div>
				<div class="col-lg-8 col-md-6 col-xs-12">

                    <div class="google-map">
	                    <?php if($map_query->have_posts()) : ?>
		                    <?php while( $map_query->have_posts() ) : $map_query->the_post(); ?>
								<?php
								    $location = get_field('location');
								    //tool_output($location);
								    if($location){
								        $lat = $location['lat'];
								        $lng = $location['lng'];
								        $address = $location['address'];
								    }

								    $kml = get_field('kml');
								    if($kml)
								            $kml = $kml['url'];
								    $terms = get_the_terms(get_the_ID(), 'category_map');
								    $icon = '';
								?>
								<?php 
								if(!empty($terms) && count($terms) > 0){

								    foreach($terms as $term){
								        // pattern "{$term->taxonomy}_{$term->term_id}" 
								        // @SEE: http://www.advancedcustomfields.com/resources/get-values-from-a-taxonomy-term/
								        $pattern = $term->taxonomy.'_'.$term->term_id;
								        $icon = get_field('icone', $pattern);
								        if($icon)
								            $icon = $icon['url'];
								        break;
								    }
								}
								?>

								<div class="marker hidden" data-kml="<?=$kml ?>" data-icon-marker="<?=$icon ?>" data-lat="<?=$lat ?>" data-lng="<?=$lng ?>">
								    <div class="infowindow">
								        <h3><?php the_title(); ?></h3>
								        <?php citeo_terms( get_the_id(), 'category_map' , array('class' => 'thumbnail-meta') ); ?>

								        <?php if(has_post_thumbnail()): ?>
								            <div class="line-img">
								                <?php the_post_thumbnail('citeo-line', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
								            </div>
								        <?php endif; ?>

								        <div class="line-text">
								            <?php the_content(); ?>
								        </div>

								        <hr>
								        <?php if ($address): ?>
								            <p><?=$address; ?></p>
								        <?php endif; ?>

								        <?php /*
								            @TODO:
								            <p class="itineraire-bulle">Itinéraire : <a class="itineraire itineraire-aller" data-address="47.539386914287626,-2.3237772552947717">Partir de ce lieu</a> - <a class="itineraire itineraire-retour" data-address="47.539386914287626,-2.3237772552947717">Aller vers ce lieu</a></p>

								            @SEE: http://www.marzan.fr/plan-interactif/
								        */ ?>
								    </div>
								</div>
		                    <?php endwhile; ?>
	                    <?php endif; ?>
					
					</div><!-- /.google-map -->

				</div>
			</div>
		</div>
	</div>


<?php wp_reset_postdata(); ?>
<?php wp_reset_query(); ?>
