<?php

require_once('application/models/model.php');

abstract class AbstractListModel extends AbstractModel {

	/**
	 * @param $data
	 * @return AbstractDataModel
	 */
	public function bind($data) {
		$class = $this->getBeanName();
		$record = new $class;
		return $record->bind($data);
	}

	/**
	 * Returns single db record
	 * @return AbstractModel
	 */
	public function getSingle() {
		$this->db->limit(1);
		return array_shift($this->getAll());
	}

	/**
	 * Returns all db records
	 * @return array of AbstractModel
	 */
	public function getAll() {
		$this->db->select('t1.*');
		$this->db->from($this->tableName.' as t1');
		$this->db->order_by('id', 'ASC');
		return $this->buildList($this->db->get());
	}

	/**
	 * Returns single db record by id
	 * @param int $id
	 * @return AbstractModel
	 */
	public function getById($id) {
		$this->db->where('id', $id);
		return $this->getSingle();
	}

	/*
	public function countAll(){
		return $this->db->count_all_results($this->tableName);
	}
	*/
	/**
	 * Creates a list of models from db records
	 * @param $query
	 * @return array of AbstractModel
	 */
	protected function buildList($query) {
		//var_dump($this->db_latest_query());
		$list = array();
		if ($query->num_rows()) {
			foreach ($query->result() as $row) {
				$list[$row->id] = $this->bind($row);
			}
			$query->free_result();
		}
		return $list;
	}

	/**
	 * Removes all db entries that belongs to user
	 * @param $customerId
	 * @return bool
	 */
	public function removeByCustomerId($customerId) {
		$this->ci()->db->where('user_id', $customerId);
		$this->ci()->db->delete($this->tableName);
		return true;
	}
}