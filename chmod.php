<?php

function chmodr($path, $filemode) {
	$dh = opendir($path);
	while (($file = readdir($dh)) !== false) {
		if($file != "." && $file != "..") {
			echo $path.DIRECTORY_SEPARATOR.$file;
			chmod($path.DIRECTORY_SEPARATOR.$file, $filemode);
		}
	}
	closedir($dh);
}

chmodr(dirname(__FILE__)."/content", 0777);
echo "done";
