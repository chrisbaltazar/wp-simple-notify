<?php

namespace SimpleNotify;

use SimpleNotify\lib\PHPMailer;
use SimpleNotify\lib\PHPMailer2;

/**
 * Class Controller
 * @package SimpleNotify
 */
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
		$post = get_post( $commentdata['comment_post_ID'] );
		if ( ! $post || $post->post_author == $commentdata['user_id'] ) {
			return;
		}

		$author = get_userdata( $post->post_author );
		if ( ! $author->user_email ) {
			return;
		}

		$link    = get_permalink( $post->ID );
		$subject = 'New comment for <strong>' . $post->post_title . '</strong>';
		$message = '<strong>Message:</strong><p>' . $commentdata['comment_content'] . '</p>';
		$this->send_email( $author->user_email, $subject, $message, $link );
	}

	public function notify_comment_user( $comment_ID, $comment_approved, $commentdata ) {
		var_dump( $commentdata );
		die;
		if ( ! $commentdata['user_id'] ) {
			return;
		}


	}

	private function send_email( string $address, string $subject, string $message, string $post_link ) {
		$mail = $this->get_email( $this->settings->get_config() );

		$mail->AddAddress( $address );
		$mail->Subject = $subject;
		$mail->Body    = $message . '<p>Post link: <a href = "' . $post_link . '">' . $post_link . '</a></p>';

		return $mail->Send();
	}

	private function get_email( array $config ) {
//		require_once WPINC . '/class-phpmailer.php';
		$mail          = new PHPMailer(true);
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML( true );

		$mail->IsSMTP();
		$mail->SMTPAuth  = true;
		$mail->SMTPDebug = 2;

		$mail->From       = $config['email_from'];
		$mail->FromName   = $config['sender'];
		$mail->Host       = $config['host'];
		$mail->Port       = $config['port'];
		$mail->SMTPSecure = $config['secure'];
		$mail->Username   = $config['smtp_user'] ?: $config['email_from'];
		$mail->Password   = $config['smtp_pwd'] ?: $config['email_pwd'];

		return $mail;
	}
}