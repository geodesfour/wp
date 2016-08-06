<ul class="list-inline pull-xs-none pull-left">

    <?php $telephone = get_field( "opt_general_phone_number", "options" );
    if ($telephone) : ?>
        <li><i class="fa fa-phone fa-fw"></i> <?=$telephone; ?></li>
    <?php endif; ?>

    <?php $email = get_field( "opt_general_email", "options" );
    if ($email) : ?>
        <li><a href="mailto:<?=$email; ?>"><i class="fa fa-envelope fa-fw"></i> Nous contacter</a></li>
    <?php endif; ?>

    <?php $email = get_field( "opt_general_address", "options" );
    if ($email) : ?>
        <li><i class="fa fa-home fa-fw"></i> <?=get_field( "opt_general_address", "options" ); ?></li>
    <?php endif; ?>
</ul>

<ul class="list-inline hidden-xs pull-xs-none pull-right">
    <?php $fbck = get_field( "opt_general_facebook", "options" );
    if ($fbck) : ?>
        <li><a href="<?=$fbck; ?>" target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a></li>
    <?php endif; ?>

    <?php $twitter = get_field( "opt_general_twitter", "options" );
    if ($twitter) : ?>
        <li><a href="https://twitter.com/<?=$twitter; ?>" target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a></li>
    <?php endif; ?>

    <?php $gplus = get_field( "opt_general_google_plus", "options" );
    if ($gplus) : ?>
        <li><a href="<?=$gplus; ?>" target="_blank"><i class="fa fa-google-plus-square fa-lg"></i></a></li>
    <?php endif; ?>
</ul>