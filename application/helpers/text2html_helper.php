<?php

if (!function_exists('text2html')) {
	function text2html($text, $maxLength = 0) {
		$string = ltrim($text);
		
		if (empty($text)) return '&nbsp;';

		$strSuffix = '';
		$strLength = mb_strlen($text, 'utf-8');
		if (0 != $maxLength) {
			if ($maxLength < $strLength && 3 < $strLength) {
				$strSuffix = '...';
			}
			$text = mb_substr($text, 0, $maxLength - strlen($strSuffix), 'utf-8');
		}

		return htmlspecialchars(rtrim($text) . $strSuffix);
	}
}

if (!function_exists('text4price')) {
	function text4price($value, $precision = 2) {
		$value = round((double)str_replace(',', '.', $value), $precision);
		return number_format($value, $precision);
	}
}

if (!function_exists('text2float')) {
	function text2float($value, $precision = null) {
		if (null === $precision) {
			return (double) $value;
		}

		$value = round((double) $value, $precision);
		return sprintf('%.' . $precision . 'f', $value);
	}
}

if (!function_exists('text2number')) {
	function text2number($text) {
		return $text;
	}
}

if (!function_exists('text2url')) {
	function text2url($text) {
		$str = mb_strtolower($text, 'utf-8');
		$str = strip_tags($str);
		$str = stripslashes($str);
		$str = html_entity_decode($str);

		# Remove quotes (can't, etc.)
		$str = str_replace('\'', '', $str);
		
		$match = '/[^a-z0-9]+/';
		$replace = '-';
		$str = preg_replace($match, $replace, $str);
		$str = trim($str, '-');

		$str = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]e/", "\${1}e", $str);
		$str = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]/", "\${1}'", $str);

		return $str;
	}
}

if (!function_exists('text4input')) {
	function text4input($text, $emptyValue = '') {
		return (empty($text)) ? $emptyValue : htmlspecialchars(stripslashes($text));
	}
}

if (!function_exists('price4input')) {
	function price4input($value, $precision = 2) {
		$value = round((double)str_replace(',', '.', $value), $precision);
		return sprintf('%.' . $precision . 'f', $value);
	}
}