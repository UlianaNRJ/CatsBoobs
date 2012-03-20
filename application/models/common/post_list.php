<?php

require_once('application/models/entity_model.php');
require_once('application/models/common/post.php');

class PostListModel extends AbstractListModel {

	protected $tableName = 'posts';

	public function getById($id, $admin=false) {
		$this->db->where('id', $id);
		if (!$admin){
			$this->db->where('status', PostStatus::ACCEPTED);
		}
		return $this->getSingle();
	}

	public function getByDateDesc($id=null) {
		$this->db->order_by('date_created', 'desc');
		$this->db->where('status', PostStatus::ACCEPTED);
		if ($id){
			$this->db->where('id', $id);
		}
		return $this->getSingle();
	}

	public function getByDateAsc($id=null) {
		$this->db->order_by('date_created', 'asc');
		$this->db->where('status', PostStatus::ACCEPTED);
		if ($id){
			$this->db->where('id', $id);
		}
		$postModel = $this->getSingle();
		$tmp = $postModel->getNext();
		$postModel->setNext($postModel->getPrev());
		$postModel->setPrev($tmp);
		return $postModel;
	}

	public function getByRating($id=null) {
		$this->db->order_by('rating', 'desc');
		$this->db->where('status', PostStatus::ACCEPTED);
		if ($id){
			$this->db->where('id', $id);
		}
		return $this->getSingle();
	}

	public function getByRandom($id=null) {
		$this->db->select('t1.*');
		$this->db->from($this->tableName.' as t1');
		$this->db->where('status', PostStatus::ACCEPTED);
		if ($id){
			$this->db->where('id', $id);
		} else {
			$this->db->order_by('RAND()');
		}
		$this->db->limit(1);


		$query = $this->db->get();
		$list = array();
		if ($query->num_rows()) {
			foreach ($query->result() as $row) {
				$post = $this->bind($row);
				$this->addNeighbours2($post);
				$list[$row->id] = $post;
			}
			$query->free_result();
		}
		return array_shift($list);
	}

	public function getRss($limit=10,$offset=0) {
		$this->db->order_by('date_created', 'desc');
		$this->db->where('status', PostStatus::ACCEPTED);
		$this->ci()->db->limit($limit, $offset);
		return $this->getAll();
	}

	public function getNew($limit=10,$offset=0) {
		$this->db->order_by('date_created', 'desc');
		$this->db->where('status', PostStatus::PENDING);
		$this->ci()->db->limit($limit, $offset);
		return $this->getAll();
	}

	public function getNewCount() {
		$this->db->where('status', PostStatus::PENDING);
		return $this->db->count_all_results($this->tableName);
	}

	public function getOld($limit=10,$offset=0) {
		$this->db->order_by('date_created', 'desc');
		$this->db->where('status', PostStatus::ACCEPTED);
		$this->ci()->db->limit($limit, $offset);
		return $this->getAll();
	}

	public function getOldCount() {
		$this->db->where('status', PostStatus::ACCEPTED);
		return $this->db->count_all_results($this->tableName);
	}

	public function getByUniqid($uniqid) {
		$this->db->where('uniqid', $uniqid);
		return $this->getSingle();
	}

	protected function buildList($query) {
		$list = array();
		if ($query->num_rows()) {
			foreach ($query->result() as $row) {
				$post = $this->bind($row);
				$this->addNeighbours($post);
				$list[$row->id] = $post;
			}
			$query->free_result();
		}
		return $list;
	}

	/**
	 * @param $post
	 */
	protected function addNeighbours($post){

		$query = $this->db->query(
				"SELECT * FROM
				(SELECT MAX(id) as prev FROM posts WHERE date_created < ? AND status = ? ORDER BY date_created DESC LIMIT 1) as t1,
				(SELECT MIN(id) as next FROM posts WHERE date_created > ? AND status = ? ORDER BY date_created ASC LIMIT 1) as t2;"
		, array(date(SQL_FORMAT, $post->getDateCreated()), PostStatus::ACCEPTED, date(SQL_FORMAT, $post->getDateCreated()), PostStatus::ACCEPTED));
		$row = $query->row();
		$post->setPrev($row->prev);
		$post->setNext($row->next);
	}

	protected function addNeighbours2($post){
		$query = $this->db->query(
				"SELECT * FROM
				(SELECT id as prev FROM posts WHERE id != ? AND status = ? ORDER BY RAND() LIMIT 1) as t1,
				(SELECT id as next FROM posts WHERE id != ? AND status = ? ORDER BY RAND() LIMIT 1) as t2;"
		, array($post->getId(), PostStatus::ACCEPTED, $post->getId(), PostStatus::ACCEPTED));
		$row = $query->row();
		$post->setPrev($row->prev);
		$post->setNext($row->next);
	}

}