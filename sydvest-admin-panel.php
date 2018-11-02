<?php 
/**
* Plugin Name: Sydvest Adminpanel
* Plugin URI: http://sydvest.no/
* Description: Sydvest-tema for administrasjonspanelet.
* Based on Oktan Admin 1.0 by Øyvind Eikeland <oyvind.eikeland@oktan.no>. Edited 19.10.2018 by Håvard Hvoslef Kvalnes <haavard@sydvest.no>.
* Version: 1.1.4
* Author: Sydvest AS <post@sydvest.no> 
* Author URI: http://sydvest.no/
* Icon1x: https://raw.github.com/SydvestHaavard/sydvest-admin-panel/master/img/icon-128x128.png
* Icon2x: https://raw.github.com/SydvestHaavard/sydvest-admin-panel/master/img/icon-256x256.png
* BannerHigh: https://raw.github.com/SydvestHaavard/sydvest-admin-panel/master/img/banner-1544x500.png
* BannerLow: https://raw.github.com/SydvestHaavard/sydvest-admin-panel/master/img/banner-722x250.png
 */

// Set some changeable variables, change as needed
define("SVNAME", "Jostein Sydnes");
define("SVEMAIL", "post@sydvest.no");
define("SVPHONE", "913 71 097");


// Register our admin stylesheet
function register_sv_styles() {
	wp_register_style( 'sv_admin_stylesheet', plugins_url( '/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'sv_admin_stylesheet' );
}

 
// Change footer text
function sv_change_footer_text() {
	echo '<a href="http://sydvest.no" target="_blank"><img src="/wp-content/plugins/sydvest-admin-panel/img/SYDVEST_logo_farge.svg" alt="SYDVEST Logo" /></a> For kundeservice, kontakt '. SVNAME .', <a href="mailto:'. SVEMAIL .'" title="Send e-post til support">'. SVEMAIL .'</a>, '. SVPHONE .'';
}

// DASHBOARD REMOVE WIDGETS
function sv_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // Wp News
	//remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Draft
}

// DASHBOARD ADD CUSTOM WIDGET
function sv_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wptutsplus_dashboard_welcome', 'Velkommen', 'sv_add_welcome_widget' );
}
function sv_add_welcome_widget(){ ?>
 
    <h4>Velkommen til <?php echo get_option('blogname') ?></h4>
    
    <p>For å endre innhald på nettsida di navigere du i menyen til venstre til det du vil endra. Du finn du alt du treng for å administrera nettstaden din i menyen. Det beste tipset du kan få er å kikka på kva som er gjort på linkande innlegg eller sider.</p>
    <p><strong>Hovudpunkta i menyen består av:</strong></p>
    <ul style="list-style:disc; padding-left:1em;">
        <li style="margin:1em 0;"><strong>Innlegg</strong><br />Her finn du alle nyhetsartiklar på sida di.</li>
        
        <li style="margin:1em 0;"><strong>Media</strong><br />Her finn du alt av bilete, video, pdf og andre dokument som er lasta opp til nettstaden din.</li>
        
        <li style="margin:1em 0;"><strong>Side</strong><br />Her kan du leggja til og endre innhald på sider. Prinsippet er det samme som på innlegg. Ei side er til dømes &laquo;Om Oss&raquo;. Sider kan og ha undersider, undersider blir vist med ein strek foran namnet sitt.</li>
        
        <li style="margin:1em 0;"><strong>Brukarar</strong><br />Her kan du endre og leggja til brukarar (administratorar).</li>
    </ul>
	
	<p>Sit du fast og ikkje får det til, kan du ta kontakt med Sydvest. Då kan me hjelpa deg på ein time-basert basis, eller gjennom ein månadleg supportavtale.<p><?php echo SVNAME ?><br /><?php echo SVEMAIL; ?><br /><?php echo SVPHONE; ?></p></p> 
 
<?php 
}

// HIDE POST META BOXES
function sv_default_hidden_meta_boxes( $hidden, $screen ) {
	// Grab the current post type
	$post_type = $screen->post_type;
	// If we're on a 'post'...
	if ( ('post' == $screen->base) && ('my-custom-post_type' == $screen->id) ){
		// Define which meta boxes we wish to hide
		$hidden = array(
			// 'authordiv', // Author Metabox
			'commentstatusdiv', // Comments Status Metabox
			'commentsdiv', // Comments Metabox
			'postcustom', // Custom Fields Metabox
			// 'postexcerpt', // Excerpt Metabox
			'revisionsdiv', // Revisions Metabox
			'slugdiv', // Slug Metabox
			'trackbacksdiv', // Trackback Metabox
			// 'categorydiv', // Categories Metabox
			'formatdiv', // Formats Metabox
			// 'postimagediv', // Featured Image Metabox
			// 'submitdiv', // Submit Metabox
			'tagsdiv-post_tag', // Tags Metabox
		);
		// Pass our new defaults onto WordPress
		return $hidden;
	}
	// If we are not on a 'post', pass the
	// original defaults, as defined by WordPress
	return $hidden;
}

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* ================================================================================================ */
/*                                  WP Plugin Update Server                                         */
/* ================================================================================================ */

/**
* Selectively uncomment the sections below to enable updates with WP Plugin Update Server.
*
* WARNING - READ FIRST:
* Before deploying the plugin or theme, make sure to change the following value
* - https://your-update-server.com  => The URL of the server where WP Plugin Update Server is installed
* - $prefix_updater                 => Replace "prefix" in this variable's name with a unique plugin prefix
*
* @see https://github.com/froger-me/wp-package-updater
**/

require_once plugin_dir_path( __FILE__ ) . 'lib/wp-package-updater/class-wp-package-updater.php';

/** Enable plugin updates with license check **/
// $svadmin_updater = new WP_Package_Updater(
// 	'https://your-update-server.com',
// 	wp_normalize_path( __FILE__ ),
// 	wp_normalize_path( plugin_dir_path( __FILE__ ) ),
// 	true
// );

/** Enable plugin updates without license check **/
$svadmin_updater = new WP_Package_Updater(
'http://plugins.sydvestdev.no/',
wp_normalize_path( __FILE__ ),
wp_normalize_path( plugin_dir_path( __FILE__ ) )
);

/* ================================================================================================ */

function sydvest_admin_run() {}
add_action( 'plugins_loaded', 'sydvest_admin_run', 10, 0 );

// Sydvest Admin actions
add_action( 'login_enqueue_scripts', 'register_sv_styles' ); // Change login logo
add_action( 'admin_enqueue_scripts', 'register_sv_styles' );	// register stylesheet action
add_action( 'wp_dashboard_setup', 'sv_remove_dashboard_widgets' ); // remove dashboard action
add_action( 'wp_dashboard_setup', 'sv_add_dashboard_widgets' ); // add dashboard widgets
add_action( 'sv_default_hidden_meta_boxes','hide_meta_box',10,2 ); // Hide post meta boxes

// Sydvest Admin filters
add_filter( 'admin_footer_text', 'sv_change_footer_text' );	// Change footer text filter

?>
