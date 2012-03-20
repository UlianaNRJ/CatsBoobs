<?php

require_once(BASEPATH . 'core/Model.php');

abstract class AbstractModel extends CI_Model {

	/**
	 * @var string
	 */
	protected $tableName;

	/**
	 * @return string
	 */
	public function getTableName(){
		return $this->tableName;
	}

	/**
	 * @return CI_Controller
	 */
	public function ci() {
		return get_instance();
	}

	/**
	 * Gets namespace of current object
	 * @return string
	 */
	public function getNameSpace(){
		$class = get_class($this);
		$nameSpace = substr($class, 0, strrpos($class, "\\"));
		/*
        $reflection = new ReflectionClass($class);
        $namespace = $reflection->getNamespaceName();
		*/
		return "\\".$nameSpace."\\";
	}

	/**
	 * Gets bean name for list
	 * namespace should not contains 'list'
	 * @return string
	 */
	public function getBeanName(){
		$class = get_class($this);
		$className = str_replace("List", "", $class);
		return $className;
	}

	abstract public function bind($data);


}