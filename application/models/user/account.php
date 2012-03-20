<?php

require_once('application/models/entity_model.php');

abstract class UserAccountModel extends AbstractEntityModel {
	public function __construct() {
		parent::__construct();

		$this->_addProperty('dateCreated', 'date_created', DATE_EMPTY);
		$this->_addProperty('dateUpdated', 'date_updated', DATE_EMPTY);
		$this->_addProperty('dateVisit', 'date_visit', DATE_EMPTY);

		//$this->_addProperty('login', 'login', null);
		$this->_addProperty('email', 'email', null);
		$this->_addProperty('autologin', '', null);

		$this->_addProperty('password', 'password');
		$this->_addProperty('newPassword', '');
		$this->_addProperty('newPasswordConfirm', '');

		$this->_addProperty('guid', 'guid', null);

		$this->_addProperty('firstName', 'first_name');
		$this->_addProperty('lastName', 'last_name');


	}

	public function bind($data) {

		if(isset($data->new_password)){
			$this->newPassword = $data->new_password;
		}
		if(isset($data->new_password_confirm)){
			$this->newPasswordConfirm = $data->new_password_confirm;
		}
		return parent::bind($data);
	}

	protected function _insertRecord() {
		$time = time();
		$this->dateCreated = date(SQL_FORMAT, $time);
		$this->dateUpdated = date(SQL_FORMAT, $time);
		$this->dateVisit = date(SQL_FORMAT, $time);

		$this->setPassword($this->ci()->encrypt->sha1($this->getNewPassword()));

		$this->guid = guid(
			$this->getDateCreated(),
			$this->getEmail(),
			$this->getPassword(),
			$this->getFirstName(),
			$this->getLastName()
		);
		return parent::_insertRecord();
	}

	protected function _updateRecord() {
		$time = time();
		$this->dateUpdated = date(SQL_FORMAT, $time);

		if($this->getNewPassword()){
			$this->setPassword($this->ci()->encrypt->sha1($this->getNewPassword()));
		}

		return parent::_updateRecord();
	}

	public function getFullName() {
		return $this->getFirstName() . ' ' . $this->getLastName();
	}
}