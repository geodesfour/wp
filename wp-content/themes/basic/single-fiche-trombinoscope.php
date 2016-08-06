<?php
/**
 * The template for displaying all evenement single posts.
 *
 * @package citeo
 */
?>

	<?php get_header(); ?>
	
   <?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
    <div class="container-fluid">
    <?php else: ?>
    <div class="container">
    <?php endif; ?>

        <div class="row">
            <div class="col-lg-8 col-xs-12 mb-md-2x">

        		<div class="layout-content">
        			<?php while (have_posts()) : the_post(); ?>

                        <?php
                            $elu_birthday = date( 'd/m/Y',strtotime(get_field('citeo_date_trombi')));
                            $elu_fonction = get_field('citeo_fonction_trombi');
                            $elu_groupe = get_field('citeo_groupe_trombi');
                            $elu_profession = get_field('citeo_profession_trombi');
                            $elu_accroche = get_field('citeo_accroche_trombi');
                            $elu_bio = get_field('citeo_bio_trombi');
                            $elu_tel = get_field('citeo_tel_trombi');
                            $elu_mail = get_field('citeo_mail_trombi');
                            $elu_site = get_field('citeo_site_trombi');
                            $elu_twitter = get_field('citeo_twitter_trombi');
                            $elu_fbck = get_field('citeo_fbck_trombi');
                        ?>

                        <div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

                            <div class="article-header">

                            	<?php if(!empty($elu_fonction)): ?>
                                    <?php the_title( '<h1 class="article-title">', ' <small>'.$elu_fonction.'</small></h1>' ); ?>
                                <?php else: ?>
                                    <?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
                                <?php endif; ?>

                                <?php get_template_part( 'parts/template', 'meta' ); ?>

                            </div>
                            
                            <?php if(has_post_thumbnail()): ?>
                                <div class="article-image pull-left">
                                    <?php the_post_thumbnail('citeo-portrait', array('class' => 'img-responsive', 'alt' => get_the_title() )); ?>
                                </div>
                            <?php endif; ?>

                            <div class="article-content">

                                <?php the_content(); ?>

                                <?php if(!empty($elu_groupe) OR !empty($elu_birthday) OR !empty($elu_profession) OR !empty($elu_bio)): ?>
                                    
                                    <h3>Biographie :</h3>
                                    <p>
                                        <?php if(!empty($elu_groupe)): ?>
                                            <strong>Groupe politique :</strong> <?=$elu_groupe; ?><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_birthday)): ?>
                                            <strong>Date de naissance :</strong> <?=$elu_birthday; ?><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_profession)): ?>
                                            <strong>Profession :</strong> <?=$elu_profession; ?><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_bio)): ?>
                                            <?php echo $elu_bio; ?>
                                        <?php endif; ?>
                                    </p>

                                <?php endif; ?>
                                
                                <?php if(!empty($elu_tel) OR !empty($elu_mail) OR !empty($elu_site) OR !empty($elu_twitter) OR !empty($elu_fbck) OR !empty($elu_google)): ?>

                                    <h3>Contact :</h3>
                                    <p>
                                        <?php if(!empty($elu_tel)): ?>
                                            <strong>Téléphone :</strong> <?=$elu_tel; ?><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_mail)): ?>
                                            <strong>Email :</strong> <a href="mailto:<?=$elu_mail; ?>"><?=$elu_mail; ?></a><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_site)): ?>
                                            <strong>Site internet :</strong> <a href="<?=$elu_site; ?>" target="_blank"><?=$elu_site; ?></a><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_twitter)): ?>
                                            <strong>Compte Twitter :</strong> <a href="https://twitter.com/<?=$elu_twitter; ?>" target="_blank"><?=$elu_twitter; ?></a><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_fbck)): ?>
                                            <strong>Compte Facebook :</strong> <a href="https://www.facebook.com/<?=$elu_fbck; ?>" target="_blank"><?=$elu_fbck; ?></a><br>
                                        <?php endif; ?>
                                        <?php if(!empty($elu_google)): ?>
                                            <strong>Compte Google+ :</strong> <a href="https://plus.google.com/+<?=$elu_google; ?>" target="_blank"><?=$elu_google; ?></a><br>
                                        <?php endif; ?>
                                    </p>

                                <?php endif; ?>

                            </div>

                            <?php get_template_part( 'parts/template', 'share' ); ?>

                        </div>

                    <?php endwhile; ?>

                </div>
                
            </div>

            <?php get_sidebar(); ?>

        </div>
    </div>

    <?php get_footer(); ?>
