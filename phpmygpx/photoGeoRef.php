<?php
/**
 * This file permits to search photos acording several criteria.
 *
 * @version $Id$
 * @package phpmygpx
 * @copyright Copyright (C) 2011 Andres Gomez Casanova.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

include("./config.inc.php");
include("./queries.inc.php");
include("./libraries/functions.inc.php");

setlocale (LC_TIME, $cfg['config_locale']);

if($cfg['show_exec_time'])
$startTime = microtime_float();

if($DEBUG) {
	foreach($_POST as $akey => $val)
	out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$task 	= getUrlParam('HTTP_GET', 'STRING', 'task');
$f_x 	= getUrlParam('HTTP_GET', 'FLOAT', 'x') * 1000000;
$f_y 	= getUrlParam('HTTP_GET', 'FLOAT', 'y') * 1000000;

// Connects to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'],
		$cfg['db_password']);

switch ($task) {
	case 'getCloserPhoto':
		getCloserPhoto($f_x, $f_y);
		break;

	default:
		getData();
		break;
}

function getCloserPhoto($x, $y) {
	global $DEBUG, $cfg, $dbqueries;
	$query = $dbqueries['closerPhoto_1'].$x.$dbqueries['closerPhoto_2'].$y
			.$dbqueries['closerPhoto_3'];
	if($DEBUG)	out($query, 'OUT_DEBUG');
	$result = db_query($query);
	if(mysql_num_rows($result)) {
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		// Writes the description in JSON format.
		$ret = "{";
		$ret .= "  \"photo\": {";
		$ret .= "    \"id\": \"".$row['id'].'", ';
		$ret .= "    \"altitude\": \"".$row['altitude'].'", ';
		$ret .= "    \"latitude\": \"".($row['latitude']/1000000).'", ';
		$ret .= "    \"longitude\": \"".($row['longitude']/1000000).'", ';
		$ret .= "    \"timestamp\": \"".$row['timestamp'].'", ';
		$ret .= "    \"image_dir\": \"".$row['image_dir'].'", ';
		$ret .= "    \"speed\": \"".$row['speed'].'", ';
		$ret .= "    \"move_dir\": \"".$row['move_dir'].'", ';
		$ret .= "    \"size\": \"".$row['size'].'", ';
		$ret .= "    \"file\": \"".$row['file'].'", ';
		$ret .= "  }";
		$ret .= "}";
		echo $ret;
		
		// Writes an hyperlink tothe photo.
		echo "<p><a href='${cfg['photo_images_dir']}${row['file']}'>";
		echo "<img src='${cfg['photo_thumbs_dir']}${cfg['thumbs_prefix']}${row['file']}' hspace=5 /></a></p>";
	}
}

if($cfg['show_exec_time']) {
	$endTime = microtime_float();
	$exectime = round($endTime - $startTime, 4);
}

?>
