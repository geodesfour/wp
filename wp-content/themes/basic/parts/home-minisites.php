    <?php $minisites = get_field('citeo_minisites'); ?>
    <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>
        <div class="row">
            <div class="col-lg-2 col-xs-12">
                <div class="section-heading">
                    <img src="<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/icon-globe.png" alt="icon globe">
                    <h3 class="section-title">Nos minisites</h3>
                </div>
            </div>
            <?php foreach ($minisites as $minisite) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-md-2x clearfix">
                    <div class="text-center">
                        <a class="thumbnail" href="<?php echo $minisite['citeo_minisites_lien']; ?>" target="_blank">
                            <?php if (!empty($minisite['citeo_minisites_image']['sizes']['citeo-minisite'])): ?>
                                <div class="thumbnail-img">
                                    <img class="img-responsive" src="<?php echo $minisite['citeo_minisites_image']['sizes']['citeo-minisite']; ?>" width="<?php echo $minisite['citeo_minisites_image']['sizes']['263x216-width']; ?>" height="<?php echo $minisite['citeo_minisites_image']['sizes']['263x216-height']; ?>" alt="<?php echo $minisite['citeo_minisites_image']['alt']; ?>">
                                </div>
                            <?php endif; ?>
                            <h3 class="thumbnail-title"><?php echo $minisite['citeo_minisites_titre']; ?></h3>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php // carousel minisites part
            $minisites_c = get_field('citeo_minisites_carrousel');
            if (!empty($minisites_c)) : ?>
                <div class="mb-md-2x col-lg-4 col-md-4 col-xs-12 clearfix">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="owl-carousel" data-ride="owl-carousel" data-dots="true" data-nav="false" data-responsive='{"0" : {"items" : 1}, "800" : {"items" : 1}, "1200" : {"items" : 1, "nav" : true, "dots": false} }'>
                                <?php foreach ($minisites_c as $minisite_c) : ?>

                                    <?php if (!empty($minisite_c['citeo_minisites_image']['sizes']['citeo-logo'])): ?>
                                        <div class="owl-content">
                                            <a href="<?php echo $minisite_c['citeo_minisites_lien']; ?>" target="_blank">
                                                <img src="<?php echo $minisite_c['citeo_minisites_image']['sizes']['citeo-logo']; ?>" alt="<?php echo $minisite_c['citeo_minisites_image']['alt']; ?>">
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>