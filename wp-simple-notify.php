<?php
/**
 * Plugin Name: WP Simple Notify
 * Plugin URI:
 * Description: Very simple plugin to handle common email notifications
 * Version: 1.0
 * Author: Chris Baltazar
 **/

define( 'SIMPLE_NOTIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SIMPLE_NOTIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( file_exists( SIMPLE_NOTIFY_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once SIMPLE_NOTIFY_PLUGIN_DIR . 'vendor/autoload.php';
}

SimpleNotify\Bootstrap::init();