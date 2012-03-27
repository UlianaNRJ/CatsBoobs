<?php

require_once('application/controllers/abstract.php');
require_once('application/models/common/post_list.php');

class Cron extends AbstractController {
	public function index() {

		$postListModel = new PostListModel();
		$postList = $postListModel->getCron();


		$list =array();
		foreach($postList as $post) {
			$list[] = /*base_url()*/ "http://catsboobs.com/" . "%23!" . $post->getId();
		}

		$url = "http://graph.facebook.com/?ids=".implode(",", $list);
		$json = json_decode(file_get_contents($url), TRUE);
		foreach($json as $url => $data){
			if (!isset($data['shares'])){
				$data['shares'] = 0;
			}
			$id = end(explode("!", $url));
			log_message("DEBUG", "post #".$id." has ". $data['shares']. " shares");
			$post = $postListModel->getById($id);
			$post->setRating($data['shares']);
			$post->save();
		}
	}
}