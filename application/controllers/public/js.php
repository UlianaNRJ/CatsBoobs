<?php

require_once('application/controllers/abstract.php');

class Js extends AbstractController {

	public function index() {

		$this->lang->load('upload');

		$L = array();

		$L['social'] = array();

		$L['social']['vk'] = array();
		$L['social']['vk']['title'] = $this->lang->line('vkontakte_title');
		$L['social']['vk']['description'] = $this->lang->line('vkontakte_description');
		$L['social']['vk']['button'] = $this->lang->line('vkontakte_button');

		$L['upload'] = array();

		$L['upload']['response'] = array();
		$L['upload']['response']['success'] = $this->lang->line('response_success');
		$L['upload']['response']['error'] = $this->lang->line('response_error');

		$L['upload']['form'] = array();
		$L['upload']['form']['name'] = $this->lang->line('form_name');
		$L['upload']['form']['size'] = $this->lang->line('form_size');

		echo "var L = ".json_encode($L);
		return;
	}
}