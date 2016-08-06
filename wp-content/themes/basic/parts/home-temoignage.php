<?php $font_actus = get_field('citeo_font_lactualite');
if (!empty($font_actus)) : ?>
<div class="layout-aside">    
   <?php foreach ($font_actus as $font_actu) : ?>
        <div class="blockquote">                    
            <blockquote class="blockquote-body"><?php echo $font_actu['citeo_citation_profil'] ?></blockquote>
            <div class="blockquote-header">
                <div class="blockquote-img">
                    <?php echo wp_get_attachment_image( $font_actu['citeo_image_profil'], 'citeo-icon', false, array('class'=>'img-circle', 'width'=>'70', 'height'=>'70', 'alt'=>$font_actu['citeo_nom_profil'] ) ); ?>
                </div>
                <div class="blockquote-title"><?php echo $font_actu['citeo_nom_profil'] ?></div>
                <div class="blockquote-desc"><?php echo $font_actu['citeo_fonction_profil'] ?></div>
            </div>
        </div>
    <?php endforeach; ?>       
</div>
<?php endif;
