<?php


namespace SimpleNotify;


class Settings {

	const ENDPOINT_SAVE_CONFIG = '/save';

	/**
	 * Settings constructor.
	 */
	public function __construct() {

	}

	public function register_rest_route() {
		register_rest_route( Bootstrap::PLUGIN_NAME, self::ENDPOINT_SAVE_CONFIG,
			[
				'methods'  => 'POST',
				'callback' => [ $this, 'save' ],
			] );
	}

	public function get_endpoint( string $path = '' ): string {
		return '/wp-json/' . trim( Bootstrap::PLUGIN_NAME, '\\/' ) . '/' . ltrim( $path, '/' );
	}

	public function save() {
		$data = $_POST;

		return new \WP_REST_Response( $data );
	}
}