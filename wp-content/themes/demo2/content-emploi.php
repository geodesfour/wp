<?php
/**
 * The template used for displaying page content in single-emploi.php
 *
 * @package citeo
 */
?>

<div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="article-header">

		<?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
		
		<?php get_template_part( 'parts/template', 'meta' ); ?>

    	<?php
    		$dateformatstring = "l d F Y";
    		$date_limite_unixtimestamp = strtotime(get_field('citeo_limit_date'));
        ?>

        <p>Date limite de l'offre : <?php echo date_i18n($dateformatstring, $date_limite_unixtimestamp); ?></p>

	</div>

	<div class="article-content">

		<?php if( $post->post_excerpt ): ?>
			<p class="lead"><?php echo get_the_excerpt(); ?></p>
		<?php endif; ?>
	
		<?php the_content(); ?>



		<?php 
		/**
		 * RESSOURCES ASSOCIES
		 */
		?>
		<?php if( have_rows('citeo_ressources') ): ?>
		  <div class="panel panel-article">
		    <!-- Default panel contents -->
		    <div class="panel-heading">Ressources utiles</div>     
		    <ul class="list-group">
		    <?php while ( have_rows('citeo_ressources') ) : the_row(); ?>
		      <?php if(get_row_layout() == 'citeo_ressource_file'): ?>
		        <?php $document = get_sub_field('citeo_ressource_file_item'); ?>
		        <li class="list-group-item">
		            <a href="<?php ($document['url'])? $document['url'] : ''; ?>" target="_blank">
		                <i class="fa fa-file-pdf-o"></i> <?=($document['title'])? $document['title'] : ''; ?>
		            </a>
		            <?php if ($document['ID']): ?>
		                <?php
		                    $filesize = filesize( get_attached_file( $document['ID'] ) );
		                    $filesize = size_format($filesize, 2);
		                ?>
		                <span class="information"><?=$filesize; ?>, <?=pathinfo($document['url'], PATHINFO_EXTENSION); ?></span>
		            <?php endif; ?>
		        </li>
		      <?php elseif(get_row_layout() == 'citeo_ressource_link'): ?>
		        <?php $link = get_sub_field('citeo_ressource_link_item'); ?>
		        <?php $title = get_sub_field('citeo_ressource_link_item_title'); ?>
		        <li class="list-group-item">
		            <a href="<?=$link ?>" target="_blank">
		                <i class="fa fa-external-link"></i> <?=($title)? $title : $link; ?>
		            </a>
		            <span class="information"><?= ($link)? $link: '' ?></span>
		        </li>
		      <?php endif; ?>

		    <?php endwhile; ?>
		    </ul>

		  </div>
		<?php endif; ?>



		<?php 
		/**
		 * CONTACTS ASSOCIES
		 */
		?>
		<?php if( have_rows('citeo_contacts') ): ?>
		  <div class="panel panel-article">
		    <!-- Default panel contents -->
		    <div class="panel-heading">Contacts</div>                               

		    <!-- List group -->
		    <ul class="list-group">
		    <?php while ( have_rows('citeo_contacts') ) : the_row(); ?>
		      <?php $contact = get_sub_field('citeo_contacts_item'); ?>
		      <li class="list-group-item">
		        <p>
		        <i class="fa fa-user"></i>
		        <?=$contact; ?>
		        </p>
		      </li>  
		    <?php endwhile; ?>               
		    </ul>
		  </div>
		<?php endif; ?>



	</div>

	<?php get_template_part( 'parts/template', 'share' ); ?>
	
</div>