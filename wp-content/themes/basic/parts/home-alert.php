    <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>
        <div class="row">
            <div class="col-xs-12">

                <div class="alert alert-<?php the_field('citeo_message_type'); ?>" role="alert">
                    <?php the_field('citeo_message_texte'); ?>
                </div>

            </div>
        </div>
    </div>