<ul class="list-inline hidden-xs pull-xs-none pull-right">
    <?php $telephone = get_field( "opt_general_phone_number", "options" );
    if ($telephone) : ?>
        <li><i class="fa fa-phone fa-fw"></i> <?=$telephone; ?></li>
    <?php endif; ?>

        <?php $page_contact = get_page_by_title( 'Nous contacter' ); ?>
        <?php if($page_contact): ?>
        <li><a href="<?=get_permalink($page_contact->ID); ?>"><i class="fa fa-envelope fa-fw"></i> Nous contacter</a></li>
        <?php endif; ?>

        <?php $page_a11y = get_page_by_title( 'Accessibilité numérique' ); ?>
        <?php if($page_a11y): ?>
        <li><a href="<?=get_permalink($page_a11y->ID); ?>">Accessibilité</a></li>
        <?php endif; ?>
    <?php /*
    <?php $email = get_field( "opt_general_address", "options" );
    if ($email) : ?>
        <li><i class="fa fa-home fa-fw"></i> <?=get_field( "opt_general_address", "options" ); ?></li>
    <?php endif; ?>
    */ ?>
</ul>