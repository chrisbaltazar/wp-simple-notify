<?php

namespace SimpleNotify;

class Boostrap {

	const PLUGIN_NAME = 'wp-simple-notify';

	const MENU_SLUG = 'wp-simple-notify-admin';

	const POST_DATA_ACTION = 'wp-simple-notify-settings';

	public static function init() {
		$obj = new self;

		add_action( 'plugins_loaded', [ $obj, 'run' ] );

		add_action( 'admin_enqueue_scripts', [ $obj, 'manage_assets' ] );

		add_action( 'admin_menu', [ $obj, 'set_admin_menu' ] );

		add_action( 'admin_post_' . self::POST_DATA_ACTION, [ new Settings(), 'save' ] );
	}


	public function run() {

	}

	public function manage_assets() {

	}

	public function set_admin_menu() {
		add_submenu_page(
			'options-general.php',
			'WP Simple Notify Settings',
			'WP Simple Notify',
			'manage_options',
			self::MENU_SLUG,
			function () {
				include __DIR__ . '/templates/main-settings.php';
			}
		);
	}
}