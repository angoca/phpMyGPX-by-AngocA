<?php
/**
* @version $Id: image.classes.php 320 2010-07-24 21:02:57Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define('PHOTO_THUMBS_DIR', './photos/thumbs/');

class ImageFile {
	var $imageURI = NULL;
	var $width = 0;
	var $height = 0;
	var $imageInfo = NULL;
	var $JPGsupport = FALSE;
	var $PNGsupport = FALSE;
	var $GIFreadsupport = FALSE;
	var $GIFcreatesupport = FALSE;
	
	function ImageFile() {
		$info = @gd_info();
		if($info) {
			if($info["JPG Support"])	$this->JPGsupport = TRUE;
			if($info["PNG Support"])	$this->PNGsupport = TRUE;
			if($info["GIF Read Support"])	$this->GIFreadsupport = TRUE;
			if($info["GIF Create Support"])	$this->GIFcreatesupport = TRUE;
			return TRUE;
		}
		else
			return FALSE;
	}
	
	function load($file) {
		if(file_exists($file)) {
			$this->imageURI = $file;
			list($this->width, $this->height) = 
				getimagesize($this->imageURI, $this->imageInfo);
			return TRUE;
		}else
			return FALSE;
	}
	
	function createThumbnail($size) {
		// default size of thumbnail
		if(intval($size)) {
			$width_thumb = $size;
			$height_thumb = $size;
		}else {
			$width_thumb = 150;
			$height_thumb = 150;
		}
		
		// calculate new dimensions
		$ratio_orig = $this->width / $this->height;
		
		if ($width_thumb / $height_thumb > $ratio_orig)
		   $width_thumb = $height_thumb * $ratio_orig;
		else
		   $height_thumb = $width_thumb / $ratio_orig;
		
		// create thumbnail
		$im_thumb = @imagecreatetruecolor($width_thumb, $height_thumb);
		$im = @imagecreatefromjpeg($this->imageURI);
		$ok = @imagecopyresampled($im_thumb, $im, 0, 0, 0, 0, 
			$width_thumb, $height_thumb, $this->width, $this->height);
		
		if(!$im_thumb || !$im || !$ok)
			return FALSE;
		return $im_thumb;
	}
	
	function rotate($image, $angle) {
		if($angle == 'auto') {
			// read EXIF data
			$exif = exif_read_data($this->imageURI, 'IFD0', TRUE);
			// check IFD0 section in EXIF header
			if($exif) {
				// get orientation and set rotation angle 
				$orientation = $exif['IFD0']['Orientation'];
				switch($orientation) {
					case '8':
						$angle = 90;
						break;
					case '6':
						$angle = 270;
						break;
					case '3':
						$angle = 180;
						break;
					case '1':
					default:
						return $image;
						break;
				}
			}else
				return FALSE;
		}
		// and finally rotate
		$image_rot = @imagerotate($image, intval($angle), 0);
		
		return $image_rot;
	}
	
	function importPhoto($gpx_id, $title_opt, $title, $desc_opt, $description, 
			$timezone, $offset, $option) {
		global $DEBUG, $cfg;
		set_time_limit(30);
		$status = array('error'=>-1, 'lid'=>0, 'msg'=>'');
		
		// read IPTC data
		if(isset($this->imageInfo["APP13"])) {
	    	$iptc = iptcparse($this->imageInfo["APP13"]);
			if($DEBUG)	var_dump($iptc);
		}
		
		// read EXIF data
		$exif = exif_read_data($this->imageURI, 'GPS', TRUE);
		
		// check GPS section in EXIF header
		if($exif) {
			// parse GPS data
			$alt = intval($this->exif_get_float($exif['GPS']['GPSAltitude']));
			$lat = $this->exif_get_latitude($exif);
			$lon = $this->exif_get_longitude($exif);
			$ts = $this->exif_get_timestamp($exif);
			
			$lat *= 1000000;
			$lon *= 1000000;
			$status['msg'] = _PHOTO_LOCATION_FROM_EXIF;
		}else {
			$exif = exif_read_data($this->imageURI, 'IFD0', TRUE);
			if(!$exif)
				$status['msg'] = _PHOTO_NO_EXIF;
			$ts = $this->exif_get_timestamp($exif);
			
			// try to get position from trackpoints
			$query = "SELECT `latitude`, `longitude` 
				FROM `${cfg['db_table_prefix']}gpx_import` 
				WHERE timestampdiff(second, 
					timestampadd(HOUR, $timezone, `timestamp`), timestampadd(SECOND, $offset, '$ts')
					) BETWEEN 0 AND ".$cfg['max_timediff_import']." 
				AND `gpx_id` = '$gpx_id' 
				ORDER BY `timestamp` DESC LIMIT 1; ";
				
		        $result = db_query($query);
		        if($DEBUG)	out($query, 'OUT_DEBUG');
				if(mysql_num_rows($result)) {
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$lat = $row['latitude'];
					$lon = $row['longitude'];
					$status['msg'] = _PHOTO_LOCATION_FROM_TRKPT;
				}
		}
		
		if($lat && $lon) {
			// set title for photo
			switch($title_opt) {
				case 'iptc_title':
					$title = encode_UTF8($iptc['2#005'][0]);
					break;
				case 'file_name':
					$title = basename($this->imageURI);
					break;
				case 'own':
					break;
			}
			// set description for photo
			switch($desc_opt) {
				case 'iptc_title':
					$description = encode_UTF8($iptc['2#005'][0]);
					break;
				case 'iptc_desc':
					$description = encode_UTF8($iptc['2#120'][0]);
					break;
				case 'own':
					break;
			}
			
			// create and save thumbnail
			$ok = @imagejpeg($this->rotate(
				$this->createThumbnail($cfg['photo_thumb_width']), 'auto'),  
				'./photos/thumbs/'.basename($this->imageURI), $cfg['photo_jpeg_quality']);
			
			if($ok) {
				// insert poi into database
		        $query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}pois` SET 
		        	`altitude` = '$alt', 
		        	`latitude` = '$lat', 
		        	`longitude` = '$lon',
		        	`timestamp` = '$ts',
		        	`file` = '".basename($this->imageURI)."', 
		        	`size` = '".filesize($this->imageURI)."', 
		        	`title` = '$title', 
		        	`description` = '$description',
		        	`thumb` = '$thumb_blob',
		        	`icon_file` = 'images/marker_blue_cross.png',
		        	`icon_size` = '24,24',
		        	`icon_offset` = '0,-24',
		        	`public` = '1',
		        	`gpx_id` = '$gpx_id',
		        	`user_id` = '0' ;";
		        $result = db_query($query);
		        if($DEBUG)	out($query, 'OUT_DEBUG');
		        $liid = intval(mysql_insert_id());	        
		        
		        if($liid) {
		        	$status['lid'] = $liid;
		        	$status['error'] = 0;
		        	$status['msg'] .= _IMPORT_SUCCESS;
		        }else {
		        	$status['msg'] .= _IMPORT_FAILED;
		        }
	        }else
	        	$status['msg'] = _PHOTO_NO_VALID_JPG;
        }else
        	$status['msg'] .= _PHOTO_NO_LOCATION;
		return $status; 
	}
	
	// private functions
	function exif_get_float($value) {
		$pos = strpos($value, '/');
		if ($pos === false) return (float) $value;
		$a = (float) substr($value, 0, $pos);
		$b = (float) substr($value, $pos+1);
		return ($b == 0) ? ($a) : ($a / $b);
	}
	function exif_get_latitude(&$exif) {
		if(!isset($exif['GPS']['GPSLatitude']))	return false; 
		$lat = $this->exif_get_float($exif['GPS']['GPSLatitude'][0]);
		$lat += $this->exif_get_float($exif['GPS']['GPSLatitude'][1]) / 60;
		if(sizeof($exif['GPS']['GPSLatitude']) == 3)
			$lat += $this->exif_get_float($exif['GPS']['GPSLatitude'][2]) / 3600;
		if($exif['GPS']['GPSLatitudeRef'] == 'S')
			$lat *= -1; 
		return $lat;
	}
	function exif_get_longitude(&$exif) {
		if(!isset($exif['GPS']['GPSLongitude']))	return false; 
		$lon = $this->exif_get_float($exif['GPS']['GPSLongitude'][0]);
		$lon += $this->exif_get_float($exif['GPS']['GPSLongitude'][1]) / 60;
		if(sizeof($exif['GPS']['GPSLongitude']) == 3)
			$lon += $this->exif_get_float($exif['GPS']['GPSLongitude'][2]) / 3600;
		if($exif['GPS']['GPSLatitudeRef'] == 'W')
			$lat *= -1; 
		return $lon;
	}
	function exif_get_timestamp(&$exif) {
		if(!isset($exif['EXIF']['DateTimeOriginal']))	return false;
		$ts = $exif['EXIF']['DateTimeOriginal'];
		$ts = substr_replace($ts, '-', 4, 1);
		$ts = substr_replace($ts, '-', 7, 1);
		return $ts;
	}
}
?>