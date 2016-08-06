<?php if(get_field('opt_general_displayed_share_buttons', 'option')): ?>
<ul class="social-toolbar">
    <!--<li class="label">Partager cette page :</li>-->
    <li class="social-tool social-tool-facebook">
        <a class="sharer" data-share-network="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?=get_permalink(); ?>" data-share-link="<?=get_permalink(); ?>" data-share-title="<?=esc_html(get_the_title()); ?>"><i class="fa fa-facebook fa-2x"></i></a>
    </li>
    <li class="social-tool social-tool-twitter">
        <a class="sharer" data-share-network="twitter" href="https://twitter.com/home?status=<?=esc_html(get_the_title()); ?> <?=get_permalink(); ?>" data-share-link="<?=get_permalink(); ?>" data-share-title="<?=esc_html(get_the_title()); ?>"><i class="fa fa-twitter fa-2x"></i></a>
    </li>
    <li class="social-tool social-tool-google">
        <a class="sharer" data-share-network="google" href="https://plus.google.com/share?url=<?=get_permalink(); ?>" data-share-link="<?=get_permalink(); ?>" data-share-title="<?=esc_html(get_the_title()); ?>"><i class="fa fa-google-plus fa-2x"></i></a>
    </li>
</ul>
<?php endif; ?>