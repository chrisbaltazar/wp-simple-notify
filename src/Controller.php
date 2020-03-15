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
		foreach ( array_keys( Settings::PLUGIN_ACTIONS ) as $action_key ) {
			if ( ! $this->is_active( $action_key ) ) {
				continue;
			}

			switch ( $action_key ) {
				case 'comment_for_author':
					add_action( 'comment_post', [ $this, 'notify_comment_author' ], 10, 3 );
					break;
				case 'comment_for_user':
					add_action( 'comment_post', [ $this, 'notify_comment_user' ], 10, 3 );
					break;
			}
		}
	}

	private function is_active( string $action ): bool {
		$finder = array_filter( $this->settings->get_actions(), function ( $item ) use ( $action ) {
			return $item['key'] === $action && $item['active'];
		} );

		return ! empty( $finder );
	}

	public function notify_comment_author( $comment_ID, $comment_approved, $commentdata ) {
		var_dump( $commentdata );
		$post = get_post( $commentdata['comment_post_ID'] );
		if ( ! $post || $post->post_author == $commentdata['user_id'] ) {
			return;
		}

		if ( ! $commentdata['comment_author_email'] ) {
			return;
		}

		$author = get_userdata( $post->post_author );
		if ( ! $author->user_email ) {
			return;
		}

		$mail          = $this->get_email( $this->settings->get_config() );
		var_dump($mail);

		$mail->subject = 'New comment for <strong>' . $post->post_title . '</strong>';
		$mail->text    = $commentdata['comment_content'];
		$mail->add( $author->user_email );

		$mail->send();
		var_dump( $mail );
	}

	public function notify_comment_user( $comment_ID, $comment_approved, $commentdata ) {
		var_dump( $commentdata );
		die;
		if ( ! $commentdata['user_id'] ) {
			return;
		}

	}

	private function get_email( array $config ) {
		$mail = new Email();

		$mail->address_from = $config['email_from'];
		$mail->password     = $config['email_pwd'];
		$mail->name_from    = $config['sender'];
		$mail->smtp_host    = $config['host'];
		$mail->smpt_port    = $config['port'];
		$mail->smtp_secure  = $config['secure'];

		$mail->smtp_user = $config['smtp_user'] ?? null;
		$mail->smtp_pwd  = $config['smtp_pwd'] ?? null;

		return $mail;
	}
}