<?php

require_once('application/models/user/authorization.php');
require_once('application/models/admin/account.php');
require_once('application/models/admin/account_list.php');

class AdminAuthorizationModel extends UserAuthorizationModel {

	public function __construct() {
		log_message('debug', get_class($this). " Initialized");
		$this->_cookieName = 'admin';
	}

	/**
	 * @param $data
	 * @return AbstractDataModel
	 */
	public function bind($data) {
		$class = $this->getBeanName();
		$record = new $class;
		return $record->bind($data);
	}
}