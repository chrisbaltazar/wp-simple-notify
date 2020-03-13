<?php


namespace SimpleNotify;


class Settings {

	const ENDPOINT_SAVE_CONFIG = '/save';

	const ENDPOINT_SET_ACTION = '/action';

	const OPTION_CONFIG_NAME = Bootstrap::PLUGIN_NAME . '-config';

	const OPTION_ACTION_NAME = Bootstrap::PLUGIN_NAME . '-actions';

	const PLUGIN_ACTIONS = [
		'comment_for_author' => 'Notify new comments to post author',
		'comment_for_user'   => 'Notify new replies to visitor\'s comments',
	];
	/**
	 * @var array
	 */
	private $stored_data;

	/**
	 * Settings constructor.
	 */
	public function __construct() {
		$this->stored_data = [
			'config'  => get_option( self::OPTION_CONFIG_NAME, [] ),
			'actions' => get_option( self::OPTION_ACTION_NAME, [] ),
		];
	}

	public static function init() {
		$obj = new self();

		add_action( 'rest_api_init', [ $obj, 'register_rest_route' ] );

		return $obj;
	}

	public function register_rest_route() {
		register_rest_route( Bootstrap::PLUGIN_NAME, self::ENDPOINT_SAVE_CONFIG,
			[
				'methods'  => 'POST',
				'callback' => [ $this, 'save' ],
			] );

		register_rest_route( Bootstrap::PLUGIN_NAME, self::ENDPOINT_SET_ACTION,
			[
				'methods'  => 'POST',
				'callback' => [ $this, 'set_action' ],
			] );
	}

	public function get_endpoint( string $path = '' ): string {
		return '/wp-json/' . trim( Bootstrap::PLUGIN_NAME, '\\/' ) . '/' . ltrim( $path, '/' );
	}

	public function get_config(): array {
		return $this->stored_data['config'];
	}

	public function get_actions() {
		$data = [];
		foreach ( self::PLUGIN_ACTIONS as $action => $description ) {
			$data[] = [
				'key'    => $action,
				'text'   => $description,
				'active' => false
			];
		}

		return $data;
	}

	public function save( \WP_REST_Request $request ) {
		$request_data = $this->get_request_data( $request->get_body_params() );

		if ( empty( $request_data ) ) {
			return new \WP_REST_Response( 'Please check again your entries and try again.', 500 );
		}

		update_option( self::OPTION_CONFIG_NAME, $request_data );

		return new \WP_REST_Response( 'Settings successfully saved!' );
	}

	private function get_request_data( array $request ): array {
		$config = [
			'email_from' => sanitize_email( $request['email_from'] ),
			'email_pwd'  => sanitize_text_field( $request['email_pwd'] ),
			'sender'     => sanitize_text_field( $request['sender'] ),
			'host'       => esc_url_raw( $request['host'] ),
			'port'       => sanitize_text_field( $request['port'] ),
			'secure'     => sanitize_text_field( $request['secure'] ),
		];

		foreach ( $config as $key => $value ) {
			if ( empty( $value ) ) {
				return [];
			}
		}

		$config['smtp_user'] = sanitize_text_field( $request['smtp_user'] );
		$config['smtp_pwd']  = sanitize_text_field( $request['smtp_pwd'] );

		return $config;
	}

	public function set_action( \WP_REST_Request $request ) {

	}
}