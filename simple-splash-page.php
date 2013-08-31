<?php
/**
 * Plugin Name: Simple Splash Page
 * Plugin URI: http://johnregan3.github.io/simple-splash-page
 * Description: Easy-to-Use creator for Mainentance Mode & Coming Soon Pages
 * Author: John Regan
 * Author URI: http://johnregan3.me
 * Version: 1.0
 * Text Domain: sspjr3
 *
 * Copyright 2013  John Regan  (email : johnregan3@outlook.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package Simple Splash Page
 * @author  John Regan
 * @version 1.0
 */

//Settings Page
include_once( plugin_dir_path(__FILE__) . 'splash-page.php' );

/**
 * Register text domain
 *
 * @since 1.0
 */
add_action( 'init', 'sspjr3_textdomain' );

function sspjr3_textdomain() {
	load_plugin_textdomain( 'sspjr3' );
}

/**
 * Delete Options on Uninstall
 *
 * @since 1.1
 */
register_uninstall_hook( __FILE__, 'ssp_uninstall' );

function ssp_uninstall() {
	delete_option( 'ssp-options-group' );
}

/**
 * Load Scripts
 *
 * @since 1.0
 */
add_action( 'wp_enqueue_scripts', 'ssp_scripts', '', 99 );
function ssp_scripts() {
	$options   = get_option( 'ssp-options' );
	if ( ( isset( $options['activate'] ) && isset( $options['default-css'] ) )
		|| ( isset( $_GET['ssp-preview'] ) && isset( $_GET['default-css'] ) ) ) {

			wp_register_style( 'ssp-default', plugins_url( 'default-styles.css', __FILE__ ) );
			wp_enqueue_style( 'ssp-default' );

			wp_register_script( 'ssp-center', plugins_url( 'center.js', __FILE__ ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'ssp-center' );
			wp_enqueue_script( 'jquery' );
	}
}

/**
 * Load Admin Scripts
 *
 * @since 1.0
 */
add_action( 'admin_enqueue_scripts', 'ssp_admin_scripts', '', 99 );

function ssp_admin_scripts() {
	wp_register_script( 'ssp-admin', plugins_url( 'admin.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'ssp-admin' );
}

/**
 * Load JS Var for Admin Scripts
 *
 * @since 1.0
 */
add_action( 'wp_print_scripts','ssp_preview_url' );
function ssp_preview_url() {
	if ( is_admin() ) :?>
	<script type="text/javascript">
		var previewUrl = "<?php echo home_url() . '?ssp-preview' ?>";
	</script>
<?php endif;
}

/**
 * Active Splash Page Reminder Admin Notice
 *
 * @since 1.0
 */
add_action( 'admin_notices', 'ssp_admin_notice' );

function ssp_admin_notice(){
	$options = get_option( 'ssp-options' );
	if ( isset( $options['activate'] ) &&  isset( $options['message'] ) ) {
		echo '<div class="updated">
		<p>Splash Page is currently active.  Edit <a href="' . admin_url( 'themes.php?page=splash-page.php' ) . '">Splash Page settings</a> to deactivate.</p>
		</div>';
	}
}

/**
 * Display Splash Page Preview
 *
 * @since 1.0
 */
add_action( 'init', 'ssp_preview' );

function ssp_preview() {
	if( isset( $_GET['ssp-preview'] ) ) {
		$options  = get_option( 'ssp-options' );
		$title    = isset( $options['title'] )   ? $options['title']   : '';
		$content  = isset( $options['content'] ) ? $options['content'] : '';

		if ( ! is_admin() ) { //not admin, just to be safe
			ssp_display( $title, $content );
		}
	}
}

/**
 * Display Splash Page
 *
 * @since 1.0
 */
add_action( 'init', 'ssp_display_splash_page' );

function ssp_display_splash_page(){
	$options  = get_option( 'ssp-options' );
	$title    = isset( $options['title'] )   ? $options['title']   : '';
	$content  = isset( $options['content'] ) ? $options['content'] : '';

	if ( ! ( is_admin() ) && isset( $options['activate'] ) ) {
		ssp_display( $title, $content );
	}
}

/**
 * Render Splash Page
 *
 * @since  1.0
 * @param  string  $title    Splash Page Title
 * @param  string  $content  Splash Page Content
 */
function ssp_display( $title, $content ){
	// Needed for WP Super Cache Plugin
	if( defined( 'WPCACHEHOME' ) ) {
		ob_end_clean();
	} ?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<?php wp_head() ?>
		</head>
		<body>
			<!-- Main Wrapper -->
			<div id="ssp-wrap">
				<!-- Element that gets centered on page & contains the content -->
				<div id="ssp-box">
					<div id="ssp-box-inner">
						<h1 id="ssp-title"><?php echo $title; ?></h1>
						<div id="ssp-content-wrap">
							<div id="ssp-content-inner">
								<?php echo $content; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php wp_footer() ?>
		<body>
	</html>

	<?php
	exit();
}
