<?php

require_once('application/models/user/account.php');
require_once('application/models/model.php');

abstract class UserAuthorizationModel extends AbstractModel {
	/**
	 * @var UserAccountModel
	 */
	protected $_account;

	/**
	 * @var string
	 */
	protected $_cookieName;

	public function isUserAuthenticated() {
		return $this->getAccount() instanceof AdminAccountModel;
	}

	public function initialize() {
		if (!$this->isUserAuthenticated()) {
			$this->loginByCookie();
		}
		return $this;
	}

	/**
	 * @return bool
	 */
	public function loginByCookie() {
		$cookie = get_cookie($this->_cookieName, true);
		if (!$cookie) return false;
		$cookie = $this->encrypt->decode($cookie);
		$cookie = unserialize($cookie);
		if ($cookie instanceof stdClass) {
			return self::login($cookie->login, $cookie->password, $cookie->autologin);
		}
		return false;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @param bool $permanent
	 * @return bool
	 */
	public function login($email, $password, $permanent=false) {
        if($email && $password){
            $this->_account = null;
            $account = $this->_loadAccount($email, $password);
            if ($account) {
                $this->_account = $account;
                $this->saveSessionAccount($account);
                if ($permanent) {
                    $this->sendCookie($account);
                }
                return true;
            }
        }
		return false;
	}

	/**
	 * @param UserAccountModel $account
	 * @return UserAuthorizationModel
	 */
	public function sendCookie($account) {
		$cookie = new stdClass();
		$cookie->id = $account->getId();
		$cookie->login = $account->getEmail();
		$cookie->password = $account->getPassword();
		$cookie->email = $account->getEmail();
		$cookie->autologin = true;

		set_cookie(array(
			'name' => $this->_cookieName,
			'value' => get_instance()->encrypt->encode(serialize($cookie)),
			'expire' => 86400 * 30
		));

		return $this;
	}

	/**
	 * @return bool
	 */
	public function logout() {
		if ($this->isUserAuthenticated()) {
			$this->_account = null;
			$this->closeSessionAccount()
				->removeCookie();
		}
		return true;
	}

	/**
	 * @return UserAuthorizationModel
	 */
	public function removeCookie() {
		set_cookie(array(
			'name' => $this->_cookieName,
			'value' => null
		));
		return $this;
	}

	/**
	 * @param $url
	 * @return UserAuthorizationModel
	 */
	public function setRedirectUrl($url) {
		$this->session->set_userdata($this->_cookieName . '-redirect-url', $url);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRedirectUrl() {
		$url = $this->session->userdata($this->_cookieName . '-redirect-url');
		$this->session->unset_userdata($this->_cookieName . '-redirect-url');
		return !$url ? $this->_cookieName."/account" : $url;
	}

	/**
	 * @return UserAccountModel
	 */
	public function getAccount() {
		if (!$this->_account) {
			$this->_account = $this->getSessionAccount();
		}
		return $this->_account;
	}

	/**
	 * @return UserAccountModel
	 */
	public function getSessionAccount() {
		$guid = $this->session->userdata($this->_cookieName.'-authorization-account');
		if ($guid){
			$list = new AdminAccountListModel;
			$accountListModel = new $list;
			$accountModel = $accountListModel->getByGuid($guid);
			if ($accountModel) {
				$accountModel->setDateVisit(date(SQL_FORMAT, time()))->save();
			}
			return $accountModel;
		}
		return null;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @return UserAccountModel
	 */
	protected function _loadAccount($email, $password) {
		$accountListModel = new AdminAccountListModel;
		return $accountListModel->getByEmail($email, $password);
	}

	/**
	 * @param UserAccountModel $account
	 * @return bool
	 */
	public function saveSessionAccount($account) {
		$this->session->set_userdata($this->_cookieName.'-authorization-account', $account->getGuid());
		return true;
	}

	/**
	 * @return UserAuthorizationModel
	 */
	public function closeSessionAccount() {
		$this->session->unset_userdata($this->_cookieName.'-authorization-account');
        $this->session->sess_destroy();
		return $this;
	}

	/**
	 * @return CI_Controller
	 */
	public function ci() {
		return get_instance();
	}
}