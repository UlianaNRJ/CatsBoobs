<?php

class My_Controller_ActionData {
	/**
	 * @var array
	 */
	protected $properties = array();

	/**
	 * @param string $index
	 * @param mixed $value
	 * @param bool $replace
	 * @return My_Controller_ActionData
	 * @throws Exception
	 */
	public function add($index, $value, $replace = false) {
		if (isset($this->properties[$index]) && !$replace) {
			throw new Exception('Property with index: "' . $index . '" already exists');
		}
		$this->properties[$index] = $value;
		return $this;
	}

	/**
	 * @param string $index
	 * @return mixed
	 * @throws Exception
	 */
	public function get($index) {
		if (isset($this->properties[$index])) {
			return $this->properties[$index];
		}
		throw new Exception('Use of undefined property: "' . $index . '"');
	}

	/**
	 * @return array
	 */
	public function getList() {
		return $this->properties;
	}
}