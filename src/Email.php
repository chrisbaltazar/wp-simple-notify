<?php


namespace SimpleNotify;

class EMail {
	public $address_from;
	public $name_from;
	public $smtp_host;
	public $smpt_port;
	public $smtp_user;
	public $smtp_pwd;
	public $smtp_secure;
	public $subject;
	public $text;


	private $mail;
	private $html;
	private $debug;
	private $auth;

	public function __construct( $debug = 1, $html = true, $auth = true ) {
		$this->html  = $html;
		$this->debug = $debug;
		$this->auth  = $auth;

		$this->mail = new PHPMailer();
		$this->mail->IsHTML( $this->html );
		$this->mail->IsSMTP();
		$this->mail->SMTPDebug = $this->debug;
		$this->mail->SMTPAuth  = $this->auth;
		$this->mail->CharSet   = 'UTF-8';
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

	public function Send() {

		$this->mail->From     = $this->address_from;
		$this->mail->FromName = $this->name_from;
		$this->mail->Host     = $this->smtp_host;
		$this->mail->Port     = $this->smtp_port;

		$this->mail->Subject = ( $this->subject );
		$this->mail->Body    = ( $this->text );

		if ( $this->smtp_secure ) {
			$this->mail->SMTPSecure = $this->smtp_secure;
		}

		$this->mail->Username = $this->smtp_user ? $this->smtp_user : $this->address_from;
		$this->mail->Password = $this->smtp_pwd;

		//Se verifica que se haya enviado el correo con el metodo Send().
		return $this->mail->Send();
	}


}