<?php

require_once('application/models/entity_model.php');

class PostModel extends AbstractEntityModel {

	protected $tableName = 'posts';

	public function __construct() {
		parent::__construct();

		$this->_addProperty('status', 'status');
		$this->_addProperty('dateCreated', 'date_created', DATE_EMPTY);
		$this->_addProperty('dateUpdated', 'date_updated', DATE_EMPTY);
		$this->_addProperty('uniqid', 'uniqid');
		$this->_addProperty('rating', 'rating', 0);

		$this->_addProperty('next', '');
		$this->_addProperty('prev', '');

	}

	public function _insertRecord(){
		$time = time();
		$this->dateCreated = date(SQL_FORMAT, $time);
		$this->status = PostStatus::PENDING;
		return parent::_insertRecord();
	}

	protected function _updateRecord() {
		$this->dateUpdated = date(SQL_FORMAT, time());
		return parent::_updateRecord();
	}
}

class PostStatus {
	const PENDING	= 0;
	const ACCEPTED	= 1;
	const REJECTED	= 2;

	static public function getDescription($status) {
		switch ($status) {
			case self::PENDING: return 'Pending';
			case self::ACCEPTED: return 'Accepted';
			case self::REJECTED: return 'Rejected';
		}
		return '';
	}
}