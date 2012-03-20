<?php

if (!function_exists('baseurl')) {
	function baseurl($uri = '') {
		if (is_array($uri)) $uri = implode('/', $uri);
		return base_url() . $uri;
	}
}

if (!function_exists('baseurl_secure')) {
	function baseurl_secure($uri = '') {
		if (is_array($uri)) $uri = implode('/', $uri);
		$ci = &get_instance();
		return $ci->config->slash_item('base_url_secure') . $uri;
	}
}

if (!function_exists('siteurl')) {
	function siteurl($uri = '') {
		return site_url($uri);
	}
}

if (!function_exists('siteurl_secure')) {
	function siteurl_secure($uri = '') {
		$ci = get_instance();
		if ($uri == '')
		{
			return $ci->config->slash_item('base_url_secure').$ci->config->item('index_page');
		}

		if ($ci->config->item('enable_query_strings') == FALSE)
		{
			if (is_array($uri))
			{
				$uri = implode('/', $uri);
			}

			$index = $ci->config->item('index_page') == '' ? '' : $ci->config->slash_item('index_page');
			$suffix = ($ci->config->item('url_suffix') == FALSE) ? '' : $ci->config->item('url_suffix');
			return $ci->config->slash_item('base_url_secure').$index.trim($uri, '/').$suffix;
		}
		else
		{
			if (is_array($uri))
			{
				$i = 0;
				$str = '';
				foreach ($uri as $key => $val)
				{
					$prefix = ($i == 0) ? '' : '&';
					$str .= $prefix.$key.'='.$val;
					$i++;
				}

				$uri = $str;
			}

			return $ci->config->slash_item('base_url_secure').$ci->config->item('index_page').'?'.$uri;
		}
	}
}

if (!function_exists('http_redirect')) {
	function http_redirect($location, $type, $httpResponseCode = 302) {
		$url = $location;
		$anchor = '';
		if (false != strpos($location, '#')) {
			list($url, $anchor) = explode('#', $location);
			if (!empty($anchor)) $anchor = '#' . $anchor;
		}
		$location = siteurl($url) . $anchor;
		header('Location: ' . $location, true, $httpResponseCode);
		exit();
	}
}

if (!function_exists('http_redirect_secure')) {
	function http_redirect_secure($location, $type, $httpResponseCode = 302) {
		$url = $location;
		$anchor = '';
		if (false != strpos($location, '#')) {
			list($url, $anchor) = explode('#', $location);
			if (!empty($anchor)) $anchor = '#' . $anchor;
		}
		$location = siteurl_secure($url) . $anchor;
		header('Location: ' . $location, true, $httpResponseCode);
		exit();
	}
}