<?php $acces = get_field( "citeo_acces_direct" ); ?>
<?php if (!empty($acces)) : ?>
    <div class="section-access listicon listicon-block">
        <?php foreach ($acces as $accesv) : ?>
            <?php
                $link = '';
                if (!empty($accesv['citeo_lien_ext_ac'])) {
                    $link = $accesv['citeo_lien_ext_ac'];
                } elseif (isset($accesv['citeo_lien_ac'][0])){
                    $lienac = $accesv['citeo_lien_ac'][0];
                    if ((int)$lienac->ID > 0) {
                        $link = get_permalink($lienac->ID);
                    }
                }
            ?>
            <a href="<?php echo ($link) ? $link : '#'; ?>"<?php echo ($accesv['citeo_lien_new_tab']) ? ' target="_blank"' : '' ?> class="listicon-item" <?php echo (!empty($accesv['citeo_couleur_ac'])) ? 'style="background:'.$accesv['citeo_couleur_ac'].'"' : ''; ?>>
                <?php if ($accesv['citeo_image_ac']['sizes']['citeo-icon']): ?>
                    <span class="listicon-icon"><img src="<?php echo $accesv['citeo_image_ac']['sizes']['citeo-icon']; ?>" width="50" height="50" alt="<?php echo $accesv['citeo_image_ac']['alt']; ?>"></span>
                <?php endif; ?>
                <?php if (!empty($accesv['citeo_titre_ac'])) : ?>
                    <span class="listicon-title"><?php echo $accesv['citeo_titre_ac']; ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div><!-- /.section-access -->
<?php endif; ?>