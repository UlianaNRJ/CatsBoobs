<?php

require_once('application/controllers/admin_controller.php');
require_once('application/models/common/post_list.php');

class Dashboard extends AbstractAdminController {

	private $itemsPerPage = 10;

	public function index() {
		$this->redirect('admin/dashboard/list-posts/');
	}

	public function listPosts($type='', $page=1) {
		if (!$type) {
			$this->redirect('admin/dashboard/list-posts/new');
		}


		$postListModel = new PostListModel();
		if ($type=='new'){
			$postList = $postListModel->getNew($this->itemsPerPage,($page-1)*$this->itemsPerPage);
			$total = $postListModel->getNewCount();
		} else {
			$postList = $postListModel->getOld($this->itemsPerPage,($page-1)*$this->itemsPerPage);
			$total = $postListModel->getOldCount();
		}

		$paging = paging($page, $total, $this->itemsPerPage, 'admin/dashboard/list-posts/'.$type);

		$this->getActionData()
			->add('postList', $postList)
			->add('paging', $paging)
			->add('type', $type);

		$this
			->addJs("admin/dashboard.js");

		$this->getActionResult();
	}

	public function massPost(){
		$data = (object) $this->getPostData();

		$postListModel = new PostListModel();
		foreach($data->mass as $id => $on){
			$postModel = $postListModel->getById($id, true);
			if (isset($data->delete)){
				$postModel->remove();
				$this->addSuccess('Пост #'.$id.' успешно удален.');
			}else{
				$postModel->setStatus(isset($data->accept)?PostStatus::ACCEPTED:PostStatus::PENDING);
				$postModel->save();
				$this->addSuccess('Пост #'.$id.' успешно обновлен.');
			}
		}

		$this->redirect('admin/dashboard/list-posts/');

	}

	public function viewPost($id) {

		$postListModel = new PostListModel();
		$postModel = $postListModel->getById($id, true);

		$this->getActionData()
			->add('postModel', $postModel);

		$this->getActionResult();
	}

	public function editPost() {
		$data = (object) $this->getPostData("post");

		$postListModel = new PostListModel();
		$postModel = $postListModel->getById($data->id, true);
		if (isset($data->delete)){
			$postModel->remove();
			$this->addSuccess('Пост #'.$data->id.' успешно удален.');
		} else {
			$postModel->setStatus($data->status);
			$postModel->save();
			$this->addSuccess('Пост #'.$data->id.' успешно обновлен.');
		}

		$this->redirect('admin/dashboard/list-posts/');
	}
}