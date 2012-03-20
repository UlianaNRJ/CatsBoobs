<?php

require_once('application/libraries/PHPMailer_v5.1/class.phpmailer.php');

class My_Email /*extends CI_Email*/{
	private $mail;

	public function __construct() {
		$config = get_instance()->config;

		$this->mail             = new PHPMailer();

		$this->mail->SMTPDebug  = 0;

		$this->mail->IsSMTP();
		$this->mail->SMTPAuth   = $config->item('smtp_auth');
		$this->mail->SMTPSecure = $config->item('smtp_secure');
		$this->mail->Host       = $config->item('smtp_host');
		$this->mail->Port       = $config->item('smtp_port');

		$this->mail->Username   = $config->item('smtp_username');
		$this->mail->Password   = $config->item('smtp_userpass');

		$this->mail->From       = SP_EMAIL_CONTACT;
		$this->mail->FromName   = "Segterra Team";
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
		foreach((array)$addresses as $key => $address){
			$this->mail->AddAddress($address);
		}
		return $this;
	}

    public function bcc($addresses){
        foreach((array)$addresses as $key => $address){
            $this->mail->AddBCC($address);
        }
        return $this;
    }

        public function attachment($attachment){
                $this->mail->AddStringAttachment($attachment, 'labslip.pdf', 'base64', 'application/pdf');
                return $this;
        }

        public function send() {
		$status = $this->mail->Send();
		if (!$status){
			log_message('error', $this->mail->ErrorInfo);
			$this->mail->ErrorInfo = "";
		}
		return $status;
	}

	// todo: move all this to view
	protected $_messageData = array();

	public function getData($index = null) {
		if (!empty($index)) {
			if (!array_key_exists($index, $this->_messageData)) {
				throw new Exception('Use of undefined index: "' . $index . '"');
			}
			return $this->_messageData[$index];
		}
		return $this->_messageData;
	}

	public function addData($index, $value, $replace = false) {
		if (array_key_exists($index, $this->_messageData)) {
			throw new Exception('Data item with index: "' . $index . '" already exists.');
		}
		$this->_messageData[$index] = $value;
		return $this;
	}

	public function setData($data, $replace = false) {
		if (!$replace) {
			$this->_messageData = array_merge($this->_messageData, $data);
		}
		else {
			$this->_messageData = $data;
		}
		return $this;
	}

	public function getImgUrl($location) {
		return $this->getUrl('skin/img/' . $location);
	}

	public function getUrl($location = '') {
		return baseurl($location);
	}

	public function getWebUrl($location) {
		return siteurl($location);
	}

	public function getSecureWebUrl($location) {
		return siteurl_secure($location);
	}

	public function clear() {
		$this->mail->ClearAddresses();
		$this->mail->ClearAttachments();
		$this->_messageData = array();
		return $this;
	}
}