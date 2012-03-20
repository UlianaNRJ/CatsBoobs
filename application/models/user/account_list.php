<?php

require_once('application/models/list_model.php');
require_once('application/models/user/account.php');
require_once('application/models/admin/account.php');

abstract class UserAccountListModel extends AbstractListModel {

	protected $tableName = 'system_account';

	/**
	 * @param string $login
	 * @param string|null $password
	 * @return UserAccountModel
	 */
	public function getByLogin($login, $password = null) {
		$this->db->where('login', $login);
		if ($password) {
			// don't remove condition because of
			// or password IS NULL
			$this->db->where('password', $password);
		}
		return $this->getSingle();
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @param int $customerId
	 * @return UserAccountModel
	 */
	public function getByEmail($email, $password = null, $customerId = null) {
		$this->db->like('email', $email);
        if($customerId){
            $this->db->where('id !=', $customerId);
        }
		if ($password) {
			$this->db->where('password', $password);
		}
		return $this->getSingle();
	}

	/**
	 * @param string $guid
	 * @return UserAccountModel
	 */
	public function getByGuid($guid) {
		$this->db->where('guid', $guid);
		return $this->getSingle();
	}

}