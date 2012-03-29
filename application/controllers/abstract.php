<?php

require_once('application/libraries/Smarty_view.php');
require_once('application/models/admin/authorization.php');

abstract class AbstractController extends My_Controller {

	public function __construct(){
		parent::__construct();

		$RTR = load_class('Router', 'core');
		/*
		var_dump(
			current(explode("/",$RTR->fetch_directory()."public")),
			$RTR->fetch_class(),
			str_replace("-", "_", $RTR->fetch_method())
		);*/

		$lang = $this->session->userdata('lang');
		if (!$lang) {
			$config =& get_config();
			$lang = $config['language'];
		}
		$this->config->set_item('language', $lang);

		$this->getActionData()
			->add('directory', current(explode("/",$RTR->fetch_directory()."public")), true)
			->add('class', $RTR->fetch_class(), true)
			->add('method', str_replace("-", "_", $RTR->fetch_method()), true)
			->add('lang', $lang, true);

		$this
			->addCss('smoothness/jquery-ui.css')
			->addCss('styles.css')
			->addCss('print.css', 'print')
			->addJs('jquery-1.7.1.min.js')
			->addJs('jquery-ui.js')
			->addJs('common.js');


	}

	public function getActionResult($layout = 'layout') {
		$view = new Smarty_view();

		$view->assignGlobalByRef('CI', $this->ci());
		$view->assignGlobalByRef('this', $this);
		$view->assignGlobalByRef('account', $this->ci()->getAuth()->getAccount());

		foreach ($this->getActionData()->getList() as $key => $value) {
			$view->assign($key, $value);
		}

		$content = $view->fetch($layout);

		$this->messages->clear();
		$this->output->enable_profiler(FALSE);
		$this->output->set_output($content);
	}

	public function getAuth() {
		return new AdminAuthorizationModel();
	}

	/**
	 * @var bool
	 */
	protected $_hasErrors = false;
	public function hasErrors() {
		return $this->_hasErrors;
	}

	public function addMessage($message, $type = null, $index = null) {
		if (!$type) $type = Messages::MT_INFO;
		if (Messages::MT_ERROR == $type || Messages::MT_WARNING == $type) $this->_hasErrors = true;
		if (empty($index)) {
			$this->ci()->messages->add($message, $type);
		}
		else {
			$this->ci()->messages->addCustom($message, $type, $index);
		}
		return $this;
	}

	public function addError($message, $location = null) {
		return $this->addMessage($message, Messages::MT_ERROR, $location);
	}

	public function addSuccess($message, $location = null) {
		return $this->addMessage($message, Messages::MT_SUCCESS, $location);
	}

	public function addWarning($message, $location = null) {
		return $this->addMessage($message, Messages::MT_WARNING, $location);
	}

	/**
	 * @var string
	 */
	protected $_pageTitle;

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->_pageTitle;
	}

	/**
	 * @param string $title
	 * @return AbstractController
	 */
	public function setTitle($title) {
		$this->_pageTitle = $title;
		return $this;
	}


	protected $_cssList = array();
	public function getCssList() {
		return $this->_cssList;
	}

	public function addCss($location, $media = 'all') {
		$item = new stdClass();
		$item->url = baseurl('skin/css/' . $location);
		$item->media = $media;
		$this->_cssList[] = $item;
		return $this;
	}

	protected $_jsList = array();
	public function getJsList() {
		return $this->_jsList;
	}

	public function addJs($location) {
		$item = new stdClass();
		$item->url = baseurl('skin/js/' . $location);
		$this->_jsList[] = $item;
		return $this;
	}


	public function getSecureWebUrl($location = '') {
		return siteurl_secure($location);
	}

	public function getWebUrl($location = '') {
		return siteurl($location);
	}

	public function getSecureUrl($location = '') {
		return baseurl_secure($location);
	}

	public function getUrl($location = '') {
		return baseurl($location);
	}

	public function getImgUrl($location) {
		return baseurl('skin/img/' . $location);
	}
}