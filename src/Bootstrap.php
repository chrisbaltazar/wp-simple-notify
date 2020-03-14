<?php

namespace SimpleNotify;


/**
 * Class Bootstrap
 * @package SimpleNotify
 */
class Bootstrap {

	/**
	 *
	 */
	const PLUGIN_NAME = 'wp-simple-notify';

	const MENU_SLUG = 'wp-simple-notify-admin';

	/**
	 * @var Settings
	 */
	private $settings;
	/**
	 * @var Controller
	 */
	private $controller;

	/**
	 * Bootstrap constructor.
	 *
	 * @param Settings $settings
	 */
	public function __construct( Settings $settings ) {
		$this->settings   = $settings;
		$this->controller = new Controller( $settings );
		$this->controller->run();
	}

	/**
	 *
	 */
	public static function init() {
		$obj = new self( Settings::init() );

		add_action( 'admin_enqueue_scripts', [ $obj, 'manage_assets' ] );

		add_action( 'admin_menu', [ $obj, 'set_admin_menu' ] );

		add_action( 'wp-simple-notify-settings-end', [ $obj, 'handle_main_app' ] );
	}


	/**
	 *
	 */
	public function handle_main_app() {
		wp_enqueue_script( 'main-app', SIMPLE_NOTIFY_PLUGIN_URL . '/src/assets/main.js', [ 'vue-resource' ] );

		wp_localize_script( 'main-app', 'wsnConfig', $this->settings->get_config() ?: (object) [] );
		wp_localize_script( 'main-app', 'wsnActions', $this->settings->get_actions() ?: (object) [] );
		wp_localize_script( 'main-app', 'wsnEndpoint', [
			'save'   => $this->settings->get_endpoint( Settings::ENDPOINT_SAVE_CONFIG ),
			'action' => $this->settings->get_endpoint( Settings::ENDPOINT_SET_ACTION ),
		] );
	}

	/**
	 *
	 */
	public function manage_assets() {
		if ( ! $this->is_plugin_page() ) {
			return;
		}

		wp_enqueue_style( 'boostrap4-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
		wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' );
		wp_enqueue_script( 'vue-js', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' );
		wp_enqueue_script( 'vue-resource', 'https://cdn.jsdelivr.net/npm/vue-resource@1.5.1', [ 'vue-js' ] );
	}

	/**
	 * @return bool
	 */
	public function is_plugin_page(): bool {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		$screen = get_current_screen();

		return strpos( $screen->id, self::MENU_SLUG ) !== false;
	}
}