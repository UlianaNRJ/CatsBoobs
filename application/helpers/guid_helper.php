<?php

if (!function_exists('guid')) {
	function guid() {
		$params = func_get_args();
		return md5(implode('-', $params)) . md5(mdate('%Y-%m-%d %H:%i:%s'));
	}
}