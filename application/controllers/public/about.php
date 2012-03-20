<?php

require_once('application/controllers/abstract.php');

class About extends AbstractController {
	public function index() {

		$this
			->addJs('jquery.form.js')
			->addJs('common/upload.js')
			->addCss('public/about.css')
			->addCss('upload.css');

		return $this->getActionResult();
	}
}