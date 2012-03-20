<?php

require_once('application/models/entity_model.php');

class RatingModel extends AbstractEntityModel {

	protected $tableName = 'rating';

	public function __construct() {
		parent::__construct();

		$this->_addProperty('status', 'status');
		$this->_addProperty('postId', 'post_id');
		$this->_addProperty('ip', 'ip');
	}

}
