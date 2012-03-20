<?php

require_once('application/controllers/admin_controller.php');

class Login extends AbstractAdminController {

	public function __construct() {
		parent::__construct();
		$this->_allowedMethodList = array(
			'index' => true,
			'index-post' => true,
		);
	}

	public function index() {
		if ($this->getAuth()->isUserAuthenticated()) {
			return $this->redirect('admin/dashboard');
		}

		$account = $this->session->userdata('login-admin-info');
		if (!$account) {
			$account = new stdClass();
			$account->login = '';
			$account->password = '';
			$account->autologin = false;
		}
		$account->password = '';
		$this->session->unset_userdata('login-admin-info');

		$this->getActionData()
			->add('account', $account);

		$this
			->addCss('customer/login.css')
            ->setTitle('Login page');

		return $this->getActionResult();
	}

	public function indexPost() {
		$data = $this->getPostData('admin');
		$account = new stdClass();
		$account->email = isset($data['email']) ? trim($data['email']) : '';
		$account->password = isset($data['password']) ? $this->encrypt->sha1(trim($data['password'])) : '';
		$account->autologin = isset($data['autologin']);
		if ($this->getAuth()->login($account->email, $account->password, $account->autologin)) {
			return $this->redirect('admin/dashboard');
		} else {
			$this->session->set_userdata('login-admin-info', $account);
			$this->lang->load('authentication');
			$this->addError($this->lang->line('login_fail'));
			return $this->redirect('admin/login');
		}
	}
}