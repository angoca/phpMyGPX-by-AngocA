<?php
/**
* @version $Id: getphoto.php 341 2010-08-22 20:59:49Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);
include("./config.inc.php");
include("./libraries/functions.inc.php");
#include("./libraries/classes.php");
include("./libraries/image.classes.php");

setlocale (LC_TIME, $cfg['config_locale']);

$id 	= getUrlParam('HTTP_GET', 'INT', 'id');
$width 	= getUrlParam('HTTP_GET', 'INT', 'x');
$height	= getUrlParam('HTTP_GET', 'INT', 'y');
$name 	= getUrlParam('HTTP_GET', 'STRING', 'name');
$type 	= getUrlParam('HTTP_GET', 'STRING', 'type');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$name)
	header ("Content-type: image/jpeg");
$im = new ImageFile();

// 
if(!$type) { 
	$query = "SELECT SQL_CALC_FOUND_ROWS * 
				FROM `${cfg['db_table_prefix']}pois` WHERE `id` = '$id' ;";
	$result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
	
	if(mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			// load image file
			if(!$width) {
				// using existing thumbnail for maximum speed
				if($im->load('./photos/thumbs/'. $row['file']))
					$thumb = imagecreatefromjpeg($im->imageURI);
			}else {
				// creating thumb (resampling original image)
				if($im->load('./photos/'. $row['file'])) {
					$thumb = $im->rotate($im->createThumbnail($width), 'auto');
				}
			}
		}
	}
	
}

if(!$name)
	ImageJPEG ($thumb);
else
	ImageJPEG ($thumb, "./files/".$name.".jpg");

ImageDestroy ($thumb);
?>