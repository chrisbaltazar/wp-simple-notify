<?php


namespace SimpleNotify;


class Controller {
	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * Controller constructor.
	 *
	 * @param Settings $settings
	 */
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	public function run() {
		foreach ( Settings::PLUGIN_ACTIONS as $action ) {
			if ( ! $this->is_active( $action ) ) {
				continue;
			}

			switch ( $action ) {
				case 'comment_for_author':
					add_action( 'comment_post', [ $this, 'notify_comment_authot' ], 10, 3 );
					die($action);
					break;
				case 'comment_for_user':
					add_action( 'comment_post', [ $this, 'notify_comment_user' ], 10, 3 );
					die($action);
					break;
			}
		}
	}

	private function is_active( string $action ): bool {
		$finder = array_filter( $this->settings->get_actions(), function ( $item ) use ( $action ) {
			return $item['key'] === $action;
		} );

		if ( empty( $finder ) ) {
			return false;
		}

		return (bool) $finder[0]['active'];
	}

	public function notify_comment_authot( $comment_ID, $comment_approved, $commentdata ) {
		var_dump($commentdata); die;
	}

	public function notify_comment_user( $comment_ID, $comment_approved, $commentdata ) {
		var_dump($commentdata); die;
	}
}