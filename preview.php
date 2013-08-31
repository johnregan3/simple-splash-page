<?php

/**
 * Preview Splash Page
 *
 * @since 1.0
 */

include_once( plugin_dir_path(__FILE__) . 'simple-splash-page.php' );

$options  = get_option( 'ssp-options' );
$title    = isset( $options['title'] )   ? $options['title']   : '';
$content  = isset( $options['content'] ) ? $options['content'] : '';

ssp_display( $title, $content );

?>