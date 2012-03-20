<?php

require_once('application/models/model.php');

abstract class AbstractDataModel extends AbstractModel {
	protected $_properties = array();
	protected $_rcMap = array();
	protected $validation = array();
	protected $errors = array();

	protected function _addProperty($index, $rcIndex, $defValue = null) {
		$this->_properties[$index] = $defValue;
		if (!empty($rcIndex)) {
			$this->_rcMap[$index] = $rcIndex;
		}
		return $this;
	}

	public function __isset($index) {
		return true && array_key_exists($index, $this->_properties);
	}

	public function __get($index) {
		if (!array_key_exists($index, $this->_properties)) {
			throw new UndefinedPropertyException($index);
		}
		if (strtolower(substr($index, 0, 4)) == 'date') {
			return strtotime($this->_properties[$index]);
		}
		return $this->_properties[$index];
	}

	public function __set($index, $value) {
		if (!array_key_exists($index, $this->_properties)) {
			throw new UndefinedPropertyException($index);
		}
		$this->_properties[$index] = $value;
	}

	/**
	 * @param string $methodName
	 * @param array $param
	 * @return AbstractDataModel
	 * @throws Exception
	 */
	public function __call($methodName, $param) {
		$prefix = strtolower(substr($methodName, 0, 3));
		switch ($prefix) {
			case 'get':
				return $this->_getProperty(substr($methodName, 3));
				break;
			case 'set':
				return $this->_setProperty(substr($methodName, 3), $param);
				break;
		}

		throw new Exception('Call to undefined method: ' . get_class($this) . '::' . $methodName);
	}

	protected function _getProperty($index) {
		$index[0] = strtolower($index[0]);
		return $this->$index;
	}

	protected function _setProperty($index, $value) {
		$index[0] = strtolower($index[0]);
		$this->$index = $value[0];
		return $this;
	}

	/**
	 * @param object $data
	 * @return AbstractDataModel
	 */
	public function bind($data) {
		foreach ($this->_rcMap as $index => $field) {
			if (property_exists($data, $field)){
				$this->_properties[$index] = $data->$field;
			}
		}
		return $this;
	}

	/**
	 * @param AbstractDataModel $data
	 * @return AbstractDataModel
	 */
	public function assign(AbstractDataModel $data) {
		foreach ($this->_properties as $index => $field) {
			$this->_properties[$index] = $data->$index;
		}
		return $this;
	}

	/**
	 * @param array $data
	 * @return AbstractDataModel
	 */
	public function setData($data){
		foreach ($this->_properties as $index => $field) {
			$this->_properties[$index] = $data[$index];
		}
		return $this;
	}

	public function fullErrorMessages(){
		return $this->errors;
	}
}

class UndefinedPropertyException extends Exception {
	public function __construct($propertyName) {
		parent::__construct('Use of undefined property "' . $propertyName . '"');
	}
}