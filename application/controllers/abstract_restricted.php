<?php

require_once('application/controllers/abstract.php');

abstract class AbstractRestrictedController extends AbstractController {

	/**
	 * @var UserAccountModel
	 */
	protected $account;

	public function __construct() {
		parent::__construct();
	}

	protected $_allowedMethodList = array();

	public function _isAllowedMethod($method) {
		return array_key_exists($method, $this->_allowedMethodList) && $this->_allowedMethodList[$method];
	}

	public function _remap($method, $params = array()) {
		if ($this->getAuth()->isUserAuthenticated() || $this->_isAllowedMethod($method)) {
			return parent::_remap($method, $params);
		}
		$this->getAuth()->setRedirectUrl($this->uri->uri_string());
		$this->redirect($this->getActionData()->get("directory")."/login");
		return $this;
	}
}