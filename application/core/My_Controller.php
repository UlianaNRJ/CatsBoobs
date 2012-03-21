<?php

require_once('system/core/Controller.php');
require_once('application/core/My_Controller_ActionData.php');

class My_Controller extends CI_Controller {

	/**
	 * @return CI_Controller
	 */
	public function ci() {
		// do we really need this method?
		return get_instance();
	}

	/**
	 * @param string $output
	 * @return void
	 */
	public function _output($output){
		// headers from google plus
		// TODO add etag
		//header('Last-Modified: ' . date("D, d M Y H:i:s T"));
		//header('Date:' . date("D, d M Y H:i:s T"));
		if (!headers_sent()){
			header('Expires: Fri, 01 Jan 1990 00:00:00 GMT');
			header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
			header('Pragma: no-cache');
		}
		$this->session->sess_write();
		echo $output;
	}

	/**
	 * @var My_Controller_ActionData
	 */
	protected $actionData;

	/**
	 * @return My_Controller_ActionData
	 */
	public function getActionData() {
		if (!$this->actionData instanceof My_Controller_ActionData) {
			$this->actionData = new My_Controller_ActionData();
		}
		return $this->actionData;
	}

	public function _remap($method, $params = array()) {
		$method = str_replace('_', '-', trim($method));
		$methodArr = explode('-', $method);
		$methodName = '';
		foreach ($methodArr as $part) {
			$methodName .= ucfirst($part);
		}

		if (method_exists($this, $methodName)) {
			call_user_func_array(array($this, $methodName), $params);
		} else {
			$this->redirect('page-not-found');
		}

		return $this;
	}

	/**
	 * Redirects user to new page and EXIT!
	 * @param string $location - url for redirect
	 * @param string $requestType - protocol
	 * @param int $httpResponseCode - http
	 * @return void
	 */
	protected function redirect($location = '', $requestType = 'http', $httpResponseCode = 302) {
		$this->session->sess_write();
		switch ($requestType) {
			case 'secure':
			case 'https':
				http_redirect_secure($location, $requestType, $httpResponseCode);
				break;
			case 'http':
			default:
				http_redirect($location, $requestType, $httpResponseCode);
				break;
		}
	}


	public function getRequestData($index = null) {
		if (empty($index)) {
			return $_GET;
		}
		return isset($_GET[$index]) ? $_GET[$index] : null;
	}

	public function getPostData($index = null) {
		if (empty($index)) {
			return $_POST;
		}
		return isset($_POST[$index]) ? $_POST[$index] : null;
	}

	protected $_requestFiles = array();

	public function getFileData($index = null) {
		$this->_initRequestFiles();
		if (empty($index)) {
			return $this->_requestFiles;
		}
		return isset($this->_requestFiles[$index]) ? $this->_requestFiles[$index] : null;
	}

	protected function _digg($source, $alias = null) {
		$res = array();
		foreach ($source as $index => $node) {
			if (!is_array($node)) {
				$res[$index] = (!empty($alias)) ? array($alias => $node) : $node;
				continue;
			}
			$res[$index] = $this->_digg($node, $alias);
		}
		return $res;
	}

	protected function _initRequestFiles() {
		foreach ($_FILES as $index => $info) {
			if (!isset($this->_requestFiles[$index])) {
				$this->_requestFiles[$index] = array();
			}

			if (isset($info['name'])) {
				if (!is_array($info['name'])) {
					$this->_requestFiles[$index]['name'] = $info['name'];
				} else {
					$this->_requestFiles[$index] = array_merge_recursive($this->_requestFiles[$index], $this->_digg($info['name'], 'name'));
				}
			}

			if (isset($info['type'])) {
				if (!is_array($info['type'])) {
					$this->_requestFiles[$index]['type'] = $info['type'];
				} else {
					$this->_requestFiles[$index] = array_merge_recursive($this->_requestFiles[$index], $this->_digg($info['type'], 'type'));
				}
			}

			if (isset($info['tmp_name'])) {
				if (!is_array($info['tmp_name'])) {
					$this->_requestFiles[$index]['tmp_name'] = $info['tmp_name'];
				} else {
					$this->_requestFiles[$index] = array_merge_recursive($this->_requestFiles[$index], $this->_digg($info['tmp_name'], 'tmp_name'));
				}
			}

			if (isset($info['error'])) {
				if (!is_array($info['error'])) {
					$this->_requestFiles[$index]['error'] = $info['error'];
				} else {
					$this->_requestFiles[$index] = array_merge_recursive($this->_requestFiles[$index], $this->_digg($info['error'], 'error'));
				}
			}

			if (isset($info['size'])) {
				if (!is_array($info['size'])) {
					$this->_requestFiles[$index]['size'] = $info['size'];
				} else {
					$this->_requestFiles[$index] = array_merge_recursive($this->_requestFiles[$index], $this->_digg($info['size'], 'size'));
				}
			}
		}
		return $this;
	}
}

