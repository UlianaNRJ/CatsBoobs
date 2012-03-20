<?php

require_once('application/controllers/abstract.php');
require_once('application/models/common/post_list.php');

class Rss extends AbstractController {

	public function index() {

		$postListModel = new PostListModel();
		$postList = $postListModel->getRss();

		$this->getActionData()
			->add('postList', $postList);

		header('Content-type: text/xml');
		$this->getActionResult('public/rss/index');
	}
}