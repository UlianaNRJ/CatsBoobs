<?php

class My_Exceptions extends CI_Exceptions {

	public function __construct(){
		parent::__construct();
	}

	function show_404($page = '', $log_error = TRUE){
	
		$heading = "404 Page Not Found";
		$message = "The page you requested was not found.";

		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '404 Page Not Found --> '.$page);
		}

		echo $this->show_error($heading, $message, 'error_404', 404);
		exit;
	}

	function show_error($heading, $message, $template = 'error_general', $status_code = 500){
		set_status_header($status_code);

		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include(APPPATH.'errors/'.$template.EXT);
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}