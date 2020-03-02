<?php

define( 'SIMPLE_NOTIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SIMPLE_NOTIFY_PLUGIN_DIR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( file_exists( SIMPLE_NOTIFY_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once SIMPLE_NOTIFY_PLUGIN_DIR . 'vendor/autoload.php';
}
