<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('application/libraries/smarty/Smarty.class.php');

class Smarty_view extends Smarty {
	const EXT = '.tpl';

	public function __construct() {
		parent::__construct();
		$this->template_dir = APPPATH . 'views';
		$conf =& get_config();
		$this->config_dir = APPPATH . 'language/'.$conf['language'];
		$this->compile_dir = 'temp';
		$this->cache_dir = 'temp';
		$this->force_compile = false;
		//$this->debugging = true;
	}

	public function display($template, $cache_id = null, $compile_id = null, $parent = null){
		$this->fetch($template, $cache_id, $compile_id, $parent, true);
	}

	public function fetch($template, $cache_id = null, $compile_id = null, $parent = null, $display = false) {
		$template = $this->template_dir . DS . $template . self::EXT;
		return parent::fetch($template, $cache_id, $compile_id, $parent, $display);
	}

	public function assignGlobalByRef($tpl_var, &$value, $nocache = false){
		if ($tpl_var != '') {
			Smarty::$global_tpl_vars[$tpl_var] = new Smarty_variable(null, $nocache);
			Smarty::$global_tpl_vars[$tpl_var]->value = &$value;
		}
	}
}