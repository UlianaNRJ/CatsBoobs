<?php

require_once('application/models/user/account.php');
require_once('application/models/admin/status.php');

class AdminAccountModel extends UserAccountModel {

	protected $tableName = 'system_account';

	public function bind($data){
		if (isset($data->is_active)){
			$data->is_active = (bool) $data->is_active;
		}

		return parent::bind($data);
	}

	public function __construct() {
		parent::__construct();

		$this->_addProperty('isActive', 'is_active', false);
		$this->_addProperty('activation', 'activation', ActivationState::NONE);
	}

	public function validate($adminId = false) {

		// TODO use Validator

		if(!$adminId){
			$this->validate_password();
		}

		return empty($this->errors);
	}

	public function validate_password(){
		$password = $this->getNewPassword();
		$this->lang->load('imglib');

		if ($password){
			$passwordConfirm = $this->getNewPasswordConfirm();
			if ($password != $passwordConfirm) {
				$this->errors['customer-new-password-confirm']['dontmatch'] = $this->lang->line('account_password_confirm_dontmatch');
			}
		}else{
			$this->errors['customer-new-password']['required'] = $this->lang->line('account_password_required');
		}
		return empty($this->errors);
	}
}