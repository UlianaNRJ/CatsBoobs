<?php

require_once('application/controllers/admin_controller.php');

class Logout extends AbstractAdminController {
	public function __construct() {
		parent::__construct();
		$this->_allowedMethodList = array(
			'index' => true,
		);
	}

	public function index() {
		if (!$this->getAuth()->isUserAuthenticated()) {
			return $this->redirect('admin/login');
		}
		$this->getAuth()->logout();
		$this->session->unset_userdata('system-authorization-account');
		
		return $this->getActionResult();
	}
}