<?php

require_once('application/models/entity_model.php');
require_once('application/models/common/post.php');

class RatingListModel extends AbstractListModel {

	protected $tableName = 'posts';

	public function getByDate($postId, $ip) {
		$this->db->where('post_id', $postId);
		$this->db->where('ip', $ip);
		return $this->getSingle();
	}

	public function getCount($postId) {
		$this->db->where('post_id', $postId);
		return $this->db->count_all_results($this->tableName);
	}

}