<?php 
/**
 * CONTENUS ASSOCIES
 */
?>
<?php if(get_field('citeo_extra_related_content')): ?>
  <div class="panel panel-article">
    <!-- Default panel contents -->
    <div class="panel-heading">Sur le même sujet</div>                               

    <!-- List group -->
    <?php $posts = get_field('citeo_extra_related_content'); ?>
    <ul class="list-group">
      <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <li class="list-group-item"><a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i><?php the_title(); ?></a></li>
      <?php endforeach; ?>
      <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    </ul>
  </div>
<?php endif; ?>