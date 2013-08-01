<?php
final class Image {
	private $file;
	private $image;
	private $info;
	private $is_image;

	public function __construct($file) {
		
		if (file_exists($file)) {
			$this->file = $file;
			$this->is_image=true;
			$info = getimagesize($file);

			$this->info = array(
            	'width'  => $info[0],
            	'height' => $info[1],
            	'bits'   => $info['bits'],
            	'mime'   => $info['mime']
			);
			
			if($this->info['mime']!='image/gif' && $this->info['mime']!='image/png' && $this->info['mime']!='image/jpeg') {
				
				$this->is_image=false;
			}	else {		
				$this->image = $this->create($file);
			}
		} else {
			$this->is_image=false;
			//exit('Error: Could not load image ' . $file . '!');
		}
	}

	public function isImage() {
		return $this->is_image;
	}
	
	private function create($image) {
		$mime = $this->info['mime'];

		if ($mime == 'image/gif') {
			return imagecreatefromgif($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
	}

	public function save($file, $quality = 100) {
		$info = pathinfo($file);
		$extension = $info['extension'];
		
		if ($extension == ('jpeg' || 'jpg')) {
			imagejpeg($this->image, $file, $quality);
		} elseif($extension == 'png') {
			imagepng($this->image, $file, 0);
		} elseif($extension == 'gif') {
			imagegif($this->image, $file);
		}
			
		imagedestroy($this->image);
	}
	
	public function save_withWatermark($file, $quality = 100) {
		$info = pathinfo($file);
		$extension = $info['extension'];

		//watermark
		$watermark_file = "engine/watermark50.png";
		$source_w = imagesx($this->image);
		$source_h = imagesy($this->image);
		$watermark = imagecreatefrompng($watermark_file);
		$watermark_w = imagesx($watermark);
		$watermark_h = imagesy($watermark);
		
		$dest_x = $source_w - $watermark_w - 5;
		$dest_y = $source_h - $watermark_h - 5;
		
		if($dest_x>0 && $dest_y >0) {
			imagecopy($this->image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_w, $watermark_h);
		} else die($watermark_w." ".$watermark_h." ".$source_w." ".$source_h);
		//fine watermark
		
		if ($extension == ('jpeg' || 'jpg')) {
			imagejpeg($this->image, $file, $quality);
		} elseif($extension == 'png') {
			imagepng($this->image, $file, 0);
		} elseif($extension == 'gif') {
			imagegif($this->image, $file);
		}
			
		imagedestroy($this->image);
	}

	public function resize($width = 0, $height = 0) {
		if (!$this->info['width']) {
			//if (!$this->info['width'] || !$this->info['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;

		if($height==0) {
			$rapporto = $this->info['width'] / $width;
			$height = $this->info['height'] / $rapporto;
		}
		
		$scale = min($width / $this->info['width'], $height / $this->info['height']);

		if ($scale == 1) {
			return;
		}

		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);
		$xpos = (int)(($width - $new_width) / 2);
		$ypos = (int)(($height - $new_height) / 2);

		$image_old = $this->image;
		$this->image = imagecreatetruecolor($width, $height);
			
		$background = imagecolorallocate($this->image, 255, 255, 255);
		imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

		imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);
			
		$this->info['width']  = $width;
		$this->info['height'] = $height;
	}

	public function watermark($file, $position = 'bottomright') {
		$watermark = $this->create($file);

		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);

		switch($position) {
			case 'topleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = 0;
				break;
			case 'topright':
				$watermark_pos_x = $this->info['width'] - $watermark_width;
				$watermark_pos_y = 0;
				break;
			case 'bottomleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = $this->info['height'] - $watermark_height;
				break;
			case 'bottomright':
				$watermark_pos_x = $this->info['width'] - $watermark_width;
				$watermark_pos_y = $this->info['height'] - $watermark_height;
				break;
		}

		imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, 120, 40);

		imagedestroy($watermark);
	}

	public function crop($top_x, $top_y, $bottom_x, $bottom_y) {
		$image_old = $this->image;
		$this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);

		imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);

		$this->info['width'] = $bottom_x - $top_x;
		$this->info['height'] = $bottom_y - $top_y;
	}

	public function rotate($degree, $color = 'FFFFFF') {
		$rgb = $this->html2rgb($color);

		$this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));

		$this->info['width'] = imagesx($this->image);
		$this->info['height'] = imagesy($this->image);
	}

	private function filter($filter) {
		imagefilter($this->image, $filter);
	}

	private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000') {
		$rgb = $this->html2rgb($color);

		imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
	}

	private function merge($file, $x = 0, $y = 0, $opacity = 100) {
		$merge = $this->create($file);

		$merge_width = imagesx($image);
		$merge_height = imagesy($image);

		imagecopymerge($this->image, $merge, $x, $y, 0, 0, $merge_width, $merge_height, $opacity);
	}

	private function html2rgb($color) {
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return FALSE;
		}

		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);

		return array($r, $g, $b);
	}
}
?>