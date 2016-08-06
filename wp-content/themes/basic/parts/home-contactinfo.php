    <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>   
        <h2 class="section-title">Près de chez vous</h2>
        <div class="row">

            <div class="col-lg-5 mb-md-3x col-xs-12">

                <?php if(count($citeo_adresses_accueil) > 0): ?>
                <div class="col-lg-5 col-md-12 mb-md-3x">
                    <h2 class="section-title">Nos coordonnées</h2>
                    <div id="gmap" class="google-map gmap-sm">
                    <?php foreach($citeo_adresses_accueil as $element_carte): ?>   
                        <?php if(isset($element_carte['address']['lat']) && !empty($element_carte['address']['lng']) && isset($element_carte['address']['lng']) && !empty($element_carte['address']['lng']) ): ?>

                            <div class="marker hidden" data-lat="<?=$element_carte['address']['lat']; ?>" data-lng="<?=$element_carte['address']['lng']; ?>" >
                                <div class="infowindow">
                                    <?=$element_carte['citeo_texte_adresse']; ?>
                                </div>
                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                    </div>
                </div>
                <?php endif; ?>


            </div>


            <div class="col-lg-7 col-md-12 col-xs-12">
                <div class="row">
                    <?php
                        $citeo_adresses_accueil = get_field('citeo_adresse_accueil');
                        $coordonnees = array();
                    ?>

                    <?php if (!empty($citeo_adresses_accueil)): ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?php $i = -1;
                            foreach ($citeo_adresses_accueil as $citeo_adresse_accueil) : $i++; ?>
                            <?php if ($i == 0 OR $i == 2): ?>
                                 <?php endif; ?>
                                    <address>
                                        <?php echo $citeo_adresse_accueil['citeo_texte_adresse']; ?>
                                    </address>
                                    <?php if ($i%2): ?>
                                        </div>
                                        <div class='col-md-4 col-sm-4 col-xs-12'>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>