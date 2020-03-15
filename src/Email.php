<?php

namespace SimpleNotify;

use SimpleNotify\lib\PHPMailer;

class Email {
	public $address_from;
	public $password;
	public $name_from;
	public $smtp_host;
	public $smpt_port;
	public $smtp_user;
	public $smtp_pwd;
	public $smtp_secure;
	public $subject;
	public $text;

	/** @var PHPMailer */
	private $mailer;
	/**
	 * @var int
	 */
	private $debug;

	public function __construct( $debug = 1, $html = true ) {
		$this->debug = $debug;

		$this->mailer            = new PHPMailer();
		$this->mailer->SMTPDebug = $debug;
		$this->mailer->IsHTML( $html );
		$this->mailer->IsSMTP();
		$this->mailer->CharSet = 'UTF-8';
	}

	public function setAuth( $auth ) {
		$this->mailer->SMTPAuth = $auth;
	}

	public function add( $to ) {
		if ( ! is_array( $to ) ) {
			$to = array( $to );
		}
		foreach ( $to as $t ) {
			$this->mailer->AddAddress( $t );
		}
	}

	public function attach( $file, $name = "" ) {
		$this->mailer->AddAttachment( $file, $name );
	}

	public function clear() {
		$this->mailer->ClearAllRecipients();
	}

	public function send() {

		$this->mailer->From     = $this->address_from;
		$this->mailer->FromName = $this->name_from;
		$this->mailer->Host     = $this->smtp_host;
		$this->mailer->Port     = $this->smtp_port;

		$this->mailer->Subject = ( $this->subject );
		$this->mailer->Body    = ( $this->text );

		if ( $this->smtp_secure ) {
			$this->mailer->SMTPSecure = $this->smtp_secure;
		}

		$this->mailer->Username = $this->smtp_user ?: $this->address_from ?: '';
		$this->mailer->Password = $this->smtp_pwd ?: $this->password ?: '';

		//Se verifica que se haya enviado el correo con el metodo Send().
		return $this->mailer->Send();
	}


}