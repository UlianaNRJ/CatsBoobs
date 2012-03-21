<?php
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	/**
	 * Обработчик ошибок
	 * @redirect internal-server-error
	 * @return void
	 */
	function sp_error_handler() {
		$args = func_get_args();
		if ($args[0] !== E_STRICT){
			// todo: use exception_error_handler
			log_message('error', "Error occurred");
			log_message('error', "Message:". $args[1]);
			log_message('error', "File:". $args[2]);
			log_message('error', "Line:". $args[3]);
			if (defined('ENVIRONMENT') && (ENVIRONMENT==='testing' || ENVIRONMENT==='local')) {
				call_user_func_array("_exception_handler", $args);
			} else {
				http_redirect('internal-server-error', 'http', 500);
				exit;
			}
		}
	}

	/**
	 * Обработчик исключений
	 * @redirect internal-server-error
	 * @param Exception $e
	 * @return void
	 */
	function sp_exception_handler(Exception $e) {
		// todo: improve log_message to accept Exception
		log_message('error', "Exception occurred");
		log_message('error', "Message:". $e->getMessage());
		log_message('error', "File:". $e->getFile());
		log_message('error', "Line:". $e->getLine());
		if (defined('ENVIRONMENT') && (ENVIRONMENT==='testing' || ENVIRONMENT==='local')) {
			_exception_handler(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
		} else {
			http_redirect('internal-server-error', 'http', 500);
			exit;
		}
	}

	/**
	 * converts error into Exception
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 * @throws ErrorException
	 */
	function exception_error_handler($errno, $errstr, $errfile, $errline ) {
	    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}


	/**
	 * Установка обработчика исключений
	 *
	 */
	function addExceptionHandler() {
		set_error_handler('sp_error_handler');
		set_exception_handler('sp_exception_handler');
	}




?>