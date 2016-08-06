<?php


if ( ! function_exists( 'remove_dashboard_widgets' ) ) :

/**
 * Remove Unused dashboard widgets
 * @return [type] [description]
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['wp_welcome_panel']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
remove_action( 'welcome_panel', 'wp_welcome_panel' );
endif;

if ( ! function_exists( 'add_dashboard_widget' ) ) :

function add_dashboard_widget() {
    wp_add_dashboard_widget("rss-feed", "Inovagora - Dernières nouvelles", "display_rss_dashboard_widget");
}
 
function display_rss_dashboard_widget() {
 
    include_once( ABSPATH . WPINC . "/feed.php");
 
    $rss = fetch_feed("http://www.inovagora.net/rss/feed/actualites/");
    $maxitems = $rss->get_item_quantity(10); 
    $rss_items = $rss->get_items(0, $maxitems);
     
    ?>
 
    <ul>
        <?php
            if($maxitems == 0)
            {
                echo "<li>No items</li>";
            }
            else
            {
                foreach($rss_items as $item)
                {
                    ?>
                        <li>
                            <a href="<?php echo esc_url($item->get_permalink()); ?>">
                                <?php echo esc_html($item->get_title()); ?>
                            </a>
                        </li>
                    <?php
                }
            }
        ?>
    </ul>
 
    <?php
}
 
add_action("wp_dashboard_setup", "add_dashboard_widget");
endif;


if ( ! function_exists( 'add_dashboard_widget_support' ) ) :

function add_dashboard_widget_support()
{
    wp_add_dashboard_widget("support_inovagora", "Aide & Assistance", "display_support_inovagora_dashboard_widget");
     
}
 
function display_support_inovagora_dashboard_widget()
{
    echo "<p>Vous rencontrez un problème ? Une difficulté dans la gestion de votre site ? N'hésitez pas à contacter le service support nous sommes là pour vous aider !</p>
    	<p>Pour cela, rien de plus simple, envoyez-nous un email en détaillant votre problème à <a href='mailto:assistance@inovagora.net?subject=Demande de support sur le site ".get_site_url()."'>assistance@inovagora.net</a> ou appelez-nous au <strong>03 44 86 76 66</strong></p>
	";
}
 
add_action("wp_dashboard_setup", "add_dashboard_widget_support");

endif;


if ( ! function_exists( 'add_dashboard_widget_update' ) ) :

function add_dashboard_widget_update()
{
    wp_add_dashboard_widget("update_citeo", "A propos de Citéo", "display_update_citeo_dashboard_widget");
     
}

function display_update_citeo_dashboard_widget()
{
    echo "
    <h2>Version 1.1 <small>- mai 2015</small></h2>
    <ul>
        <li>- Intégration des nouvelles recommendations SEO de Google</li>
        <li>- Mise à jour du socle WordPress dans sa version 4.2</li>
        <li>- Possibilité d'afficher les événements et les fiches annuaire sur une carte interactive</li>
        <li>- Galerie photo en plein écran</li>
        <li>- Un menu de navigation encore plus puissant</li>
        <li>- Des sidebars encore plus personnalisables</li>
        <li>- Optimisation du poids des CSS et des pages</li>
        <li>- Possibilité de filtrer sur les PDF dans la médiathèque</li>
        <li>- Mise à jour de l'ensemble des plugins</li>
    </ul>

    ";
}

add_action('wp_dashboard_setup', 'add_dashboard_widget_update');

endif;


/*
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}

function custom_dashboard_help() {
	echo '<p>Welcome to Custom Blog Theme! Need help? Contact the developer <a href="mailto:yourusername@gmail.com">here</a>. For WordPress Tutorials visit: <a href="http://www.wpbeginner.com" target="_blank">WPBeginner</a></p>';
}
*/


if ( ! function_exists( 'add_custom_dashboard_activity' ) ) :

/**
 *
 * Show custom post types in dashboard activity widget
 *
 */


// register your custom activity widget
add_action('wp_dashboard_setup', 'add_custom_dashboard_activity' );
function add_custom_dashboard_activity() {
    wp_add_dashboard_widget('custom_dashboard_activity', 'Activité', 'custom_wp_dashboard_site_activity');
}

// the new function based on wp_dashboard_recent_posts (in wp-admin/includes/dashboard.php)
function wp_dashboard_recent_post_types( $args ) {

/* Chenged from here */

    if ( ! $args['post_type'] ) {
        $args['post_type'] = 'any';
    }

    $query_args = array(
        'post_type'      => $args['post_type'],

/* to here */

        'post_status'    => $args['status'],
        'orderby'        => 'date',
        'order'          => $args['order'],
        'posts_per_page' => intval( $args['max'] ),
        'no_found_rows'  => true,
        'cache_results'  => false
    );
    $posts = new WP_Query( $query_args );

    if ( $posts->have_posts() ) {

        echo '<div id="' . $args['id'] . '" class="activity-block">';

        if ( $posts->post_count > $args['display'] ) {
            echo '<small class="show-more hide-if-no-js"><a href="#">' . sprintf( __( 'See %s more…'), $posts->post_count - intval( $args['display'] ) ) . '</a></small>';
        }

        echo '<h4>' . $args['title'] . '</h4>';

        echo '<ul>';

        $i = 0;
        $today    = date( 'Y-m-d', current_time( 'timestamp' ) );
        $tomorrow = date( 'Y-m-d', strtotime( '+1 day', current_time( 'timestamp' ) ) );

        while ( $posts->have_posts() ) {
            $posts->the_post();

            $time = get_the_time( 'U' );
            if ( date( 'Y-m-d', $time ) == $today ) {
                $relative = __( 'Today' );
            } elseif ( date( 'Y-m-d', $time ) == $tomorrow ) {
                $relative = __( 'Tomorrow' );
            } else {
                /* translators: date and time format for recent posts on the dashboard, see http://php.net/date */
                $relative = date_i18n( __( 'M jS' ), $time );
            }

            $obj = get_post_type_object( get_post_type() );

            $text = sprintf(
                /* translators: 1: relative date, 2: time, 4: post title */
                __( '<span>%1$s, %2$s</span> <a href="%3$s">%4$s</a><small> - %5$s par %6$s </small>' ),
                $relative,
                get_the_time(),
                get_edit_post_link(),
                _draft_or_post_title(),
                $obj->labels->singular_name,
                get_the_author()
            );

            $hidden = $i >= $args['display'] ? ' class="hidden"' : '';
            echo "<li{$hidden}>$text</li>";
            $i++;
        }

        echo '</ul>';
        echo '</div>';

    } else {
        return false;
    }

    wp_reset_postdata();

    return true;
}

// The replacement widget
function custom_wp_dashboard_site_activity() {

    echo '<div id="activity-widget">';

    $future_posts = wp_dashboard_recent_post_types( array(
        'post_type'  => 'any',
        'display' => 10,
        'max'     => 10,
        'status'  => 'future',
        'order'   => 'ASC',
        'title'   => __( 'Publishing Soon' ),
        'id'      => 'future-posts',
    ) );

    $recent_posts = wp_dashboard_recent_post_types( array(
        'post_type'  => 'any',
        'display' => 10,
        'max'     => 10,
        'status'  => 'publish',
        'order'   => 'DESC',
        'title'   => __( 'Recently Published' ),
        'id'      => 'published-posts',
    ) );

    //$recent_comments = wp_dashboard_recent_comments( 10 );

    if ( !$future_posts && !$recent_posts && !$recent_comments ) {
        echo '<div class="no-activity">';
        echo '<p class="smiley"></p>';
        echo '<p>' . __( 'No activity yet!' ) . '</p>';
        echo '</div>';
    }

    echo '</div>';
}

endif;