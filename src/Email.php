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
	private $mail;
	private $html;
	private $debug;
	private $auth;

	public function __construct( $debug = 1, $html = true ) {
		$this->debug = $debug;

		$this->mail = new PHPMailer();
		$this->mail->IsHTML( $html );
		$this->mail->IsSMTP();
		$this->mail->CharSet = 'UTF-8';
	}

	public function setAuth( $auth ) {
		$this->mail->SMTPAuth = $auth;
	}

	public function add( $to ) {
		if ( ! is_array( $to ) ) {
			$to = array( $to );
		}
		foreach ( $to as $t ) {
			$this->mail->AddAddress( $t );
		}
	}

	public function attach( $file, $name = "" ) {
		$this->mail->AddAttachment( $file, $name );
	}

	public function clear() {
		$this->mail->ClearAllRecipients();
	}

	public function send() {

		$this->mail->From     = $this->address_from;
		$this->mail->FromName = $this->name_from;
		$this->mail->Host     = $this->smtp_host;
		$this->mail->Port     = $this->smtp_port;

		$this->mail->Subject = ( $this->subject );
		$this->mail->Body    = ( $this->text );

		if ( $this->smtp_secure ) {
			$this->mail->SMTPSecure = $this->smtp_secure;
		}

		$this->mail->Username = $this->smtp_user ?: $this->address_from ?: '';
		$this->mail->Password = $this->smtp_pwd ?: $this->password ?: '';

		//Se verifica que se haya enviado el correo con el metodo Send().
		return $this->mail->Send();
	}


}