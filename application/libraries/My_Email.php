<?php

require_once('application/libraries/PHPMailer_v5.1/class.phpmailer.php');
class My_Email /*extends CI_Email*/ {

	private $mail;

	public function __construct() {
		$config = get_instance()->config;
		$this->mail = new PHPMailer();
		$this->mail->SMTPDebug = 0;
		$this->mail->IsSMTP();
		$this->mail->SMTPAuth = $config->item('smtp_auth');
		$this->mail->SMTPSecure = $config->item('smtp_secure');
		$this->mail->Host = $config->item('smtp_host');
		$this->mail->Port = $config->item('smtp_port');
		$this->mail->Username = $config->item('smtp_username');
		$this->mail->Password = $config->item('smtp_userpass');
		$this->mail->From = EMAIL_CONTACT;
		$this->mail->FromName = "CatsBoobs";
	}

	public function subject($subject) {
		$this->mail->Subject = $subject;
		return $this;
	}

	public function getSubject() {
		return $this->mail->Subject;
	}

	public function messageBody($path) {
		$this->mail->MsgHTML(get_instance()->load->view($path, array('content' => $this), true));
		$this->mail->IsHTML(true);
		return $this;
	}

	public function to($addresses) {
		foreach ((array)$addresses as $key => $address) {
			$this->mail->AddAddress($address);
		}
		return $this;
	}

	public function bcc($addresses) {
		foreach ((array)$addresses as $key => $address) {
			$this->mail->AddBCC($address);
		}
		return $this;
	}

	public function send() {
		$status = $this->mail->Send();
		if (!$status) {
			log_message('error', $this->mail->ErrorInfo);
			$this->mail->ErrorInfo = "";
		}
		return $status;
	}

	public function clear() {
		$this->mail->ClearAddresses();
		$this->mail->ClearAttachments();
		$this->_messageData = array();
		return $this;
	}
}