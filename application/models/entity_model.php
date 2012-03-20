<?php

require_once('application/models/data_model.php');

class AbstractEntityModel extends AbstractDataModel {

	/**
	 * @var int
	 */
	protected $_id;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @param $data
	 * @return AbstractDataModel
	 */
	public function bind($data) {
		if (property_exists($data, 'id')){
			$this->_id = $data->id;
		}
		return parent::bind($data);
	}

	/**
	 * Saves row and returns its id
	 * @return int
	 */
	public function save() {
		if (!$this->getId()) {
			return $this->_id = $this->_insertRecord();
		}
		return $this->_updateRecord();
	}

	/**
	 * Inserts row and returns its id
	 * @return int
	 */
	protected function _insertRecord() {
		$data = array();
		foreach ($this->_rcMap as $index => $field) {
			$data[$field] = $this->_properties[$index];
		}
		$this->ci()->db->insert($this->tableName, $data);
		return $this->ci()->db->insert_id();
	}

	/**
	 * Updates row and returns its id
	 * @return int
	 */
	protected function _updateRecord() {
		$data = array();
		foreach ($this->_rcMap as $index => $field) {
			$data[$field] = $this->_properties[$index];
		}
		$this->ci()->db->where('id', $this->getId());
		$this->ci()->db->update($this->tableName, $data);
		return $this->getId();
	}

	/**
	 * Removes row from db
	 * Its safe to pass NULL as id
	 * @return bool
	 */
	public function remove() {
		$this->ci()->db->delete($this->tableName, array('id'=>$this->getId()));
		return $this->ci()->db->affected_rows() > 0;
	}

	/**
	 * Returns JSON representation of Model
	 * @return string
	 */
	public function toJSON(){
		$array = $this->_properties;
		$array['id'] = $this->_id;
		return json_encode($array);
	}

	/**
	 * Returns Array representation of Model
	 * @return array
	 */
	public function toArray(){
		return $this->_properties;
	}
}