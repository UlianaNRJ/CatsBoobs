<?php

require_once('application/controllers/abstract.php');
require_once('application/models/common/post.php');
require_once('application/models/common/post_list.php');
require_once('application/models/common/rating.php');
require_once('application/models/common/rating_list.php');

class Common extends AbstractController {

	public function index() {
		$data = $this->getRequestData();

		$postModel= null;
		if(isset($data['_escaped_fragment_'])){
			$postListModel = new PostListModel();
			$postModel = $postListModel->getById($data['_escaped_fragment_']);
		}
		$this->getActionData()
			->add('postModel', $postModel);

		$this
			->addJs('jquery.tmpl.min.js')
			->addJs('jquery.ba-hashchange.min.js')
			->addJs('jquery.form.js')
			->addJs('common/upload.js')
			->addJs('common/index.js')
			->addCss('upload.css');

		return $this->getActionResult();
	}

	public function indexAjaxPost() {
		$post = $this->getPostData();

		if(!isset($post['sort'])){
			$post['sort']='date_desc';
		}
		if(!isset($post['id'])){
			$post['id']=null;
		}



		$postListModel = new PostListModel();
		switch($post['sort']){
			case 'rating':

				$postModel = $postListModel->getByRating($post['id']);
				break;
			case 'random':
				$postModel = $postListModel->getByRandom($post['id']);
				break;
			case 'date_asc':
				$postModel = $postListModel->getByDateAsc($post['id']);
				break;
			case 'date_desc':
			default:
				$postModel = $postListModel->getByDateDesc($post['id']);
				break;
		}

		echo $postModel ? $postModel->toJSON() : 'null';
		return;
	}

	public function indexPost() {
		$files = $this->getFileData('files');

		$status = array();
		$uniqid = uniqid(); //md5(now());
		$size = 450;

		$types = array('cats','boobs');
		foreach($types as $type){
			if (!isset($files[$type])){
				$status[$type] = 'а как же картинкa?';
			} elseif (!$files[$type]['tmp_name'] || $files[$type]['size'] > 1048576){
				$status[$type] = 'размер файла больше 1M';
			} elseif (!in_array($files[$type]['type'], array('image/gif','image/jpeg','image/png'))){
				$status[$type] = 'это разве картинка?';
			}
		}

		if (empty($status)){
			$sample = imagecreatetruecolor(2*$size, $size);

			//$sample = imagecreatetruecolor(2*$size, $size);
			//imagesavealpha($sample, true);
			//$transparent = imagecolorallocatealpha($sample, 0, 0, 0, 127);
			//imagefill($sample, 0, 0, $transparent);

			foreach($types as $type){
				$files[$type]['new_name'] = SP_TEMP_DIR.'/'.$uniqid.'.'.end(explode('/', $files[$type]['type']));
				move_uploaded_file($files[$type]['tmp_name'], $files[$type]['new_name']);
				$image[$type] = array();
				list($image[$type]['width'], $image[$type]['height']) = getimagesize($files[$type]['new_name']);
				$image[$type]['source'] = $this->_createImage($files[$type]);
				$dim = $image[$type]['width'] > $image[$type]['height'] ? 'width' : 'height';
				if($image[$type][$dim] < $size){
					$image[$type]['new_width'] = $image[$type]['width'];
					$image[$type]['new_height'] = $image[$type]['height'];
				} else {
					$image[$type]['ratio'] = $size / $image[$type][$dim] * 100;
					$image[$type]['new_width'] = $image[$type]['width'] * $image[$type]['ratio'] / 100;
					$image[$type]['new_height'] = $image[$type]['height'] * $image[$type]['ratio'] / 100;
				}

				imagecopyresampled(
					$sample,
					$image[$type]['source'],
					$type=='cats'?$size-$image[$type]['new_width']:$size,
					($size-$image[$type]['new_height'])/2,
					0,
					0,
					$image[$type]['new_width'],
					$image[$type]['new_height'],
					$image[$type]['width'],
					$image[$type]['height']
				);

				$watermark = $this->_createImage(array('type'=>'image/png','new_name'=>FCPATH.'skin/img/watermark.png'));
				imagecopyresampled(
					$sample,
					$watermark,
					$type=='cats'?($size-$image[$type]['new_width']):($size+$image[$type]['new_width']-132),
					($size-$image[$type]['new_height'])/2,
					0,
					0,
					132,
					92,
					132,
					92
				);

				if ($type!='cats'){
					$text = "catsboobs.com";
					$font_size = 10;
					$font_height = 15; //imagefontheight($font_size);
					$font_width = 100; //imagefontwidth($font_size)*strlen($text);
					$horizontal_padding = 5;
					$vertical_padding = 3;

					$background = imagecolorallocatealpha($sample, 0, 0, 0, 60);

					imagefilledrectangle(
						$sample,
						$type=='cats'?($size-$font_width-$horizontal_padding):($size+$image[$type]['new_width']-$font_width-$horizontal_padding),
						($size+$image[$type]['new_height'])/2,
						$type=='cats'?$size:2*$size,
						($size+$image[$type]['new_height'])/2 - $font_height,
						$background
					);

					imagettftext(
						$sample,
						$font_size,
						0,
						$type=='cats'?($size-$font_width):($size+$image[$type]['new_width']-$font_width),
						($size+$image[$type]['new_height'])/2 - $vertical_padding,
						imagecolorclosest($sample, 255, 255, 255),
						FCPATH."skin/font/helvetica.ttf",
						$text
					);
				}
				unlink($files[$type]['new_name']);
			}

			imagealphablending($sample, false);
			imagepng($sample, FCPATH.'content'.DIRECTORY_SEPARATOR.$uniqid.'.png' , 9);
			imagedestroy($sample);

			$postModel = new PostModel();
			$postModel->setUniqid($uniqid);
			$postModel->save();
		}

		header('Content-Type: text/html');
		//echo '<textarea>';
		echo json_encode($status);
		//echo '</textarea>';
		return;
	}

	public function pageNotFound() {
		return $this->getActionResult();
	}

	public function internalServerError() {
		return $this->getActionResult();
	}

	public function browserNotSupported() {
		return $this->getActionResult();
	}

	protected function _createImage($file){
		switch ($file['type']){
			case 'image/gif':
				return imagecreatefromgif($file['new_name']);
				break;
			case 'image/jpeg':
				return imagecreatefromjpeg($file['new_name']);
				break;
			case 'image/png':
				return imagecreatefrompng($file['new_name']);
				break;
		}
	}

}