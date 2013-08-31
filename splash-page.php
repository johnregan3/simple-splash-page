<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set up SSP Admin Page
 *
 * @since  1.0
 */
add_action( 'admin_menu', 'register_ssp_menu_page' );

function register_ssp_menu_page() {
	add_submenu_page( 'themes.php', __( 'Simple Splash Page', 'sspjr3' ), __( 'Splash Page', 'sspjr3' ),'manage_options', basename(__FILE__), 'ssp_form' );
}

/**
 * Register Settings
 *
 * @since  1.0
 */
add_action( 'admin_init', 'regsiter_ssp_settings' );

function regsiter_ssp_settings() {
	register_setting( 'ssp-options-group', 'ssp-options' );
}

/**
 * Add Updated Message on Save
 *
 * @since  1.0
 */
add_action( 'admin_notices', 'ssp_updated_notice' );

function ssp_updated_notice() {
	if ( isset( $_GET['settings-updated'] ) ) { ?>
		<div class="updated">
			<p><?php _e( 'Splash Page updated.', 'sspjr3' ); ?></p>
		</div>
	<?php
	}
}

/**
 * Render Simple Splash Page Form
 *
 * @since  1.0
 */
function ssp_form(){
	$options   = get_option('ssp-options');
	$title     = isset( $options['title'] )       ? $options['title']       : '';
	$content   = isset( $options['content'] )     ? $options['content']     : '';
	$activate  = isset( $options['activate'] )    ? $options['activate']    : 0;
	$message   = isset( $options['message'] )     ? $options['message']     : 0;
	$default   = isset( $options['default-css'] ) ? $options['default-css'] : 0;
?>

<div class="wrap">
	<div id="icon-edit" class="icon32" style="background: url('<?php echo plugins_url() ?>/simple-splash-page/ssp-icon.png') no-repeat;" >
		<br />
	</div>
	<h2><?php esc_html_e( 'Simple Splash Page', 'sspjr3' ) ?></h2>

	<form id="ssp-edit-post" action="options.php" method="post">
	<?php settings_fields( 'ssp-options-group' ) ?>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">

				<div id="titlediv">
					<div id="titlewrap">
						<input type="text" name="ssp-options[title]" size="30" value="<?php echo esc_attr( $title ); ?>" id="title" autocomplete="off" />
					</div>
				</div>
				<?php wp_editor( $content, 'ssp-options[content]' ) ; ?>
			</div>

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables">
					<div id="submitdiv" class="postbox ">
						<h3 class='hndle'><span>Save</span></h3>
						<div id="minor-publishing-actions">
							<div id="preview-action">
								<a id="ssp-preview" class="button" target="_blank" ><?php _e( 'Preview', 'sspjr3' ) ?></a>
							</div>
						</div>
						<div id="misc-publishing-actions">
							<div id="misc-pub-section" style="border-bottom: 1px solid #dfdfdf; padding: 6px 10px 8px;">
								<input type="checkbox" id="activate" name="ssp-options[activate]" value="1" <?php checked( 1, $activate ) ?>>&nbsp;&nbsp;
								<?php esc_html_e( 'Activate this Splash Page', 'sspjr3' ) ?>
							</div>
						</div>
						<div id="misc-publishing-actions">
							<div id="misc-pub-section" style="border-bottom: 1px solid #dfdfdf; padding: 6px 10px 8px;">
								<input type="checkbox" id="message" name="ssp-options[message]" value="1" <?php checked( 1, $message ) ?>>&nbsp;&nbsp;
								<?php esc_html_e( 'Activate Dashboard reminder', 'sspjr3' ) ?>
							</div>
						</div>
						<div id="misc-publishing-actions">
							<div id="misc-pub-section" style="border-bottom: 1px solid #dfdfdf; padding: 6px 10px 8px;">
								<input type="checkbox" id="default-css" name="ssp-options[default-css]" value="1" <?php checked( 1, $default ) ?>>&nbsp;&nbsp;
								<?php esc_html_e( 'Use Default plugin stylesheet', 'sspjr3' ) ?>
							</div>
						</div>
						<div id="major-publishing-actions">
							<span id="delete-action"><a href="#"><?php esc_html_e( 'Help', 'sspjr3' ) ?></a></span>
							<div id="publishing-action">
								<input type="submit" value="<?php _e( 'Save', 'sspjr3' ); ?>" class="button-primary"/>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div id="otherdiv" class="postbox ">
						<h3 class='hndle'><span>Styles</span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'Your Theme\'s stylesheet is available, but it may not seem to display correctly because its required HTML elements are not present.', 'sspjr3' ) ?>
							<p><?php esc_html_e( 'To fully customize the CSS styles on your Splash Page, it is recommended you download and install the ', 'sspjr3' ) ?>
							<a href="http://wordpress.org/plugins/simple-custom-css/" target="_blank">Simple Custom CSS</a> <?php esc_html_e( 'plugin.', 'sspjr3') ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
}

