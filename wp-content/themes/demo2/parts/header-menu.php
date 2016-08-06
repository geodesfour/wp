<?php 

$menu_name = 'main';

if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ):


    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    

    $menu_items = wp_get_nav_menu_items($menu->term_id);

    function get_submenu_tree($array, $id){
        $array_return = array();
        foreach ($array as $key => $value) {
            if($value->menu_item_parent == $id){
                $array_return[] = $value;
                $array_return = array_merge($array_return, get_submenu_tree($array, $value->ID));
            }
        
        }
        return $array_return;
    }

    function get_submenu($array, $id){
        $array_return = array();
        foreach ($array as $key => $value) {
            if($value->menu_item_parent == $id)
                $array_return[] = $value;
        }
        return $array_return;
    }

?>

<div id="layout-navigation" class="layout-navigation">
    <div id="fm" class="fm">
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-navicon"></i>
                    </button>
                    <a href="#layer-search-engine" class="btn search-toggle fm-search-trigger fm-trigger">
                        <i class="fa fa-search"></i>
                    </a>
                    <?php /*
                    <?php if( get_field('opt_general_logo_location', 'option') == 'menu' || !get_field('opt_general_display_header_banner', 'option')  ): ?>
                        <?php get_template_part( 'parts/header', 'logo' ); ?>
                    <?php endif; ?>
                    */ ?>
                </div>
            
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php $level_one = get_submenu($menu_items, '0'); ?>
                    <ul class="nav navbar-nav navbar-right">
    					<?php foreach($level_one as $level_one_entry): ?>
    						<?php $level_two = get_submenu( $menu_items, $level_one_entry->ID ); ?>
      						<?php if( count( $level_two ) != 0 ): ?>
                                <li><a href="#layer-<?=$level_one_entry->post_name; ?>" class="fm-trigger"><?=$level_one_entry->title; ?></a></li>
                            <?php else: ?>
                                <li><a <?php if(!empty($level_one_entry->target)): ?>target="<?=$level_one_entry->target ?>" <?php endif;?>href="<?=$level_one_entry->url; ?>"><?=$level_one_entry->title; ?></a></li>
                            <?php endif; ?>
    					<?php endforeach; ?>

                        <li class="fm-profil">
                            <a href="#layer-vous-etes" class="fm-trigger">Vous êtes</a>
                        </li>
    
                        
                        <li class="fm-citoyen-account">
                            <a href="#">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/compte-citoyen-mini.png" class="visible-lg" width="157" height="51" alt="Mon compte citoyen">
                                <span class="visible-xs">Mon compte citoyen</span>
                            </a>
                        </li>

                        <li class="fm-search">
                            <a href="#layer-search-engine" class="fm-search-trigger fm-trigger"><i class="fa fa-search"></i><span class="sr-only">Recherche</span></a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        <div class="fm-breadcrumb">
            <div class="container">
                <ul></ul>
            </div>
        </div>

        <nav class="fm-subnav">
            <div class="fm-wrapper">
                <?php foreach ($level_one as $level_one_entry): ?>

                <?php $sub_levels = get_submenu_tree( $menu_items, $level_one_entry->ID); ?>

                <?php if(count($sub_levels) > 0): ?>                
                <div class="fm-group">
                    
                    <?php $previous_parents = []; ?>
                    <?php foreach($sub_levels as $sub_level): ?>
                    <?php if(!in_array($sub_level->menu_item_parent, $previous_parents)): ?>
                    <div id="layer-<?=$sub_level->menu_item_parent; ?>" class="fm-layer">
                        <?php $previous_parents[] = $sub_level->menu_item_parent; ?>
                        <div class="container">
                            <div class="row">
                            <?php $level_two = get_submenu( $menu_items, $sub_level->menu_item_parent); ?>
                                <ul class="fm-textlines">

                                    <?php foreach($level_two as $level_two_entry): ?>

                                        <?php $level_three = get_submenu( $menu_items, $level_two_entry->ID); ?>

                                        <li class="col-lg-4 col-xs-12">
                                            <?php if (count($level_three) > 0): ?>
                                                <a href="#layer-<?=$level_two_entry->ID;?>" class="fm-trigger fm-textline">
                                                    <span class="fm-textline-title"><?=$level_two_entry->title;?></span>
                                                    <!-- <i class="fa fa-angle-right"></i> -->
                                                </a>
                                            <?php else: ?>
                                    			<a href="<?=$level_two_entry->url; ?>" <?php if(!empty($level_two_entry->target)): ?>target="<?=$level_two_entry->target ?>" <?php endif;?>class="fm-textline"><span class="fm-textline-title"><?=$level_two_entry->title; ?></span></a>

                                            <?php endif; ?>
                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    

                </div>
                <?php endif; ?>
                <?php endforeach; ?>
               

                <div class="fm-group">
                    <div id="layer-vous-etes" class="fm-layer fm-panel">
                        <div class="container">
                            <div class="row">
                                <ul class="fm-textlines">
                                    <li class="col-lg-4 col-xs-12">
                                        <a href="/profils/jeune/" class="fm-textline"><span class="fm-textline-title">Jeune</span></a>
                                    </li>
                                    <li class="col-lg-4 col-xs-12">
                                        <a href="/profils/famille/" class="fm-textline"><span class="fm-textline-title">Famille</span></a>
                                    </li>
                                    <li class="col-lg-4 col-xs-12">
                                        <a href="/profils/nouveau-mitryen/" class="fm-textline"><span class="fm-textline-title">Nouveau Mitryen</span></a>
                                    </li>
                                    <li class="col-lg-4 col-xs-12">
                                        <a href="/profils/senior/" class="fm-textline"><span class="fm-textline-title">Sénior</span></a>
                                    </li>
                                    <li class="col-lg-4 col-xs-12">
                                        <a href="/profils/entreprise/" class="fm-textline"><span class="fm-textline-title">Entreprise</span></a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>           
                </div>
                
                <div class="fm-group">
                    <div id="layer-search-engine" class="fm-layer fm-panel">
                        <div class="container">
                            <div class="row">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    </div>           
                </div>
    			

            </div>
        </nav>
    </div>
</div>
<?php endif; ?>
