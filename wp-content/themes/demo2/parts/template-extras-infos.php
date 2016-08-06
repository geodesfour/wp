<?php 
/**
 * DOCUMENTS ASSOCIES
 */
?>

<?php if( have_rows('citeo_extra_documents') ): ?>
<div class="panel panel-article">
  <!-- Default panel contents -->
  <div class="panel-heading">Documents liés</div>                

  <!-- List group -->
  <ul class="list-group">
    <?php while( have_rows('citeo_extra_documents') ): the_row(); ?>
      <?php $document = get_sub_field('citeo_extra_documents_item'); ?>
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
    <?php endwhile; ?>
  </ul>
</div>
<?php endif; ?>


<?php 
/**
 * LIENS ASSOCIES
 */
?>
<?php if( have_rows('citeo_extra_links') ): ?>
<div class="panel panel-article">
  <!-- Default panel contents -->
  <div class="panel-heading">Liens utiles</div>             

  <!-- List group -->
  <ul class="list-group">
    <?php while( have_rows('citeo_extra_links') ): the_row(); ?>
      <?php $link = get_sub_field('citeo_extra_links_item'); ?>
      <?php $title = get_sub_field('citeo_extra_links_item_title'); ?>
      <li class="list-group-item">
          <a href="<?=$link ?>" target="_blank">
              <i class="fa fa-external-link"></i> <?=($title)? $title : $link; ?>
          </a>
          <span class="information"><?= ($link)? $link: '' ?></span>
      </li>
    <?php endwhile; ?>
  </ul>
</div>
<?php endif; ?>



<?php 
/**
 * RESSOURCES ASSOCIES
 */
?>
<?php if( have_rows('citeo_extra_ressources') ): ?>
  <div class="panel panel-article">
    <!-- Default panel contents -->
    <div class="panel-heading">Ressources utiles</div>     
    <ul class="list-group">
    <?php while ( have_rows('citeo_extra_ressources') ) : the_row(); ?>
      <?php if(get_row_layout() == 'citeo_extra_ressources_file'): ?>
        <?php $document = get_sub_field('citeo_extra_ressources_file_item'); ?>
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
      <?php elseif(get_row_layout() == 'citeo_extra_ressources_link'): ?>
        <?php $link = get_sub_field('citeo_extra_ressources_link_item'); ?>
        <?php $title = get_sub_field('citeo_extra_ressources_link_title'); ?>
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
<?php if( have_rows('citeo_extra_contacts') ): ?>
  <div class="panel panel-article">
    <!-- Default panel contents -->
    <div class="panel-heading">Contacts</div>                               

    <!-- List group -->
    <ul class="list-group">
    <?php while ( have_rows('citeo_extra_contacts') ) : the_row(); ?>
      <?php $contact = get_sub_field('citeo_extra_contacts_item'); ?>
      <li class="list-group-item">
        <?=$contact; ?>
      </li>  
    <?php endwhile; ?>               
    </ul>
  </div>
<?php endif; ?>
