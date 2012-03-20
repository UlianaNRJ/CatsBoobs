<?php

if (!function_exists('paging')) {
	function paging($page, $total, $prepage, $action) {
		$pages = ceil($total / $prepage);

		$result = '<ul class="c paging">';
		for($i=1;$i<=$pages;$i++){
			$result .= '<li class="ib">';
			$result .= $i==$page?'':'<a href="'.base_url().$action.'/'.$i.'/">';
			$result .= $i;
			$result .= $i==$page?'':'</a>';
			$result .= '</li>';
		}
		$result .= '</ul>';
		return $result;
	}
}