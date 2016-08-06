<?php $font_actus = get_field('citeo_font_lactualite');

if (!empty($font_actus)) : ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php $titre = get_field('citeo_titre_widget'); ?>
        <?php if($titre): ?>
          <h3 class="panel-title"><?php echo $titre; ?></h3>
        <?php else: ?>
          <h3 class="panel-title">Ils font...</h3>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php $nb_element = count($font_actus); ?>
        <div class="owl-carousel" data-ride="owl-carousel"<?php if(count($font_actus) == 1): ?> data-loop="false" data-nav="false" <?php else: ?> data-loop="true" data-nav="true" data-autoplay="true" data-animate-in="fadeIn" data-animate-out="fadeOut" <?php endif; ?>>
            <?php foreach ($font_actus as $font_actu) : ?>
            <div class="blockquote">
                <div class="blockquote-header">
                    <div class="blockquote-img">
                        <?php echo wp_get_attachment_image( $font_actu['citeo_image_profil'], 'citeo-portrait-mini', false, array('class'=>'img-circle', 'width'=>'70', 'height'=>'70', 'alt'=>$font_actu['citeo_nom_profil'] ) ); ?>
                    </div>
                    <div class="blockquote-title"><?php echo $font_actu['citeo_nom_profil']; ?></div>
                    <div class="blockquote-desc"><?php echo $font_actu['citeo_fonction_profil']; ?></div>
                </div>
                <blockquote class="blockquote-body"><?php echo $font_actu['citeo_citation_profil']; ?></blockquote>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>