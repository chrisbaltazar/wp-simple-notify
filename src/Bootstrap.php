<?php

namespace SimpleNotify;

class Bootstrap {

	const PLUGIN_NAME = 'wp-simple-notify';

	const MENU_SLUG = 'wp-simple-notify-admin';

	const PLUGIN_OPTIONS = [
		'comment_for_author' => 'Notify new comments to post autor',
		'comment_for_user'   => 'Notify new replies to visitor',
	];

	const POST_DATA_ACTION = 'wp_simple_notify_settings';

	public static function init() {
		$obj = new self;

		add_action( 'admin_enqueue_scripts', [ $obj, 'manage_assets' ] );

		add_action( 'admin_menu', [ $obj, 'set_admin_menu' ] );

		add_action( 'admin_post_' . self::POST_DATA_ACTION, [ new Settings(), 'save' ] );

		add_action( 'wp-simple-notify-settings-end', [ $obj, 'handle_settings_script' ] );
	}


	public function handle_settings_script() {
		wp_enqueue_script( 'main-app', SIMPLE_NOTIFY_PLUGIN_URL . '/src/assets/main.js', [ 'vue-resource' ] );

		wp_localize_script( 'main-app', 'wsnOptions', $this->get_script_data() );
	}

	public function manage_assets() {
		if ( ! $this->is_plugin_page() ) {
			return;
		}

		wp_enqueue_style( 'boostrap4-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
		wp_enqueue_script( 'vue-js', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' );
		wp_enqueue_script( 'vue-resource', 'https://cdn.jsdelivr.net/npm/vue-resource@1.5.1', [ 'vue-js' ] );
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

	public function is_plugin_page() {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		$screen = get_current_screen();

		return strpos( $screen->id, self::MENU_SLUG ) !== false;
	}

	private function get_script_data() {
		$data = [];
		foreach ( self::PLUGIN_OPTIONS as $option => $descripion ) {
			$data[] = [
				'key'    => $option,
				'text'   => $descripion,
				'active' => 0
			];
		}

		return $data;
	}
}