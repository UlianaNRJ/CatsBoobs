<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once('system/libraries/Image_lib.php');

class My_Image_lib extends CI_Image_lib {

	function convert($type = 'jpg', $delete_orig = FALSE) {

		$this->full_dst_path = $this->dest_folder . end($this->explode_name($this->dest_image)) . '.' . $type;

		if (!($src_img = $this->image_create_gd())) {
			return FALSE;
		}

		if ($this->image_library == 'gd2' AND function_exists('imagecreatetruecolor')) {
			$create = 'imagecreatetruecolor';
		} else {
			$create = 'imagecreate';
		}
		$copy = 'imagecopy';

		$props = $this->get_image_properties($this->full_src_path, TRUE);
		$dst_img = $create($props['width'], $props['height']);
		$copy($dst_img, $src_img, 0, 0, 0, 0, $props['width'], $props['height']);

		$types = array('gif' => 1, 'jpg' => 2, 'jpeg' => 2, 'png' => 3);

		$this->image_type = $types[$type];

		if ($delete_orig) {
			unlink($this->full_src_path);
			$this->full_src_path = $this->full_dst_path;
		}

		if ($this->dynamic_output == TRUE) {
			$this->image_display_gd($dst_img);
		} else {
			if (!$this->image_save_gd($dst_img)) {
				return FALSE;
			}
		}

		imagedestroy($dst_img);
		imagedestroy($src_img);

		@chmod($this->full_dst_path, DIR_WRITE_MODE);

		return TRUE;
	}
}