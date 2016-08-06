<?php $acces = get_field( "citeo_acces_direct" ); ?>
<?php if (!empty($acces)) : ?>
    <div class="container mb-lg-3x mb-sm-2x">
        <div class="section-access listicon listicon-block">
            <div class="row">
                    
                <div class="col-lg-2 col-md-3 col-xs-12">
                    <div class="section-header">
                        <h2 class="section-title">En 1 <span class="bold">clic</span></h2>
                    </div>
                </div>

                <div class="col-lg-10 col-md-9 col-xs-12">
                    <div id="js-access-carousel" class="owl-carousel owl-carousel-large">

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

                            <a href="<?php echo ($link) ? $link : '#'; ?>"<?php echo ($accesv['citeo_lien_new_tab']) ? ' target="_blank"' : '' ?> class="listicon-item owl-content">
                                <?php if ($accesv['citeo_image_ac']['sizes']['citeo-icon']): ?>
                                    <span class="listicon-icon"><img src="<?php echo $accesv['citeo_image_ac']['sizes']['citeo-icon']; ?>" width="54" height="54" alt="<?php echo $accesv['citeo_image_ac']['alt']; ?>"></span>
                                <?php endif; ?>
                                <?php if (!empty($accesv['citeo_titre_ac'])) : ?>
                                    <span class="listicon-title"><?php echo $accesv['citeo_titre_ac']; ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div><!-- /.section-access -->
    </div><!-- /.section-access -->
<?php endif; ?>