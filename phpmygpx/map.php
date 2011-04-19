<?php
/**
* @version $Id: map.php 324 2010-07-27 15:35:51Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

session_start();

include("./check_db.php");
#include("./config.inc.php");
#include("./libraries/functions.inc.php");
include("./libraries/classes.php");
include("./libraries/html.classes.php");
include("./libraries/map.classes.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");
include("./head.html.php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$id 	= getUrlParam('HTTP_GET', 'INT', 'id');
$gpx 	= getUrlParam('HTTP_GET', 'STRING', 'gpx');
$f_lat	= getUrlParam('HTTP_GET', 'FLOAT', 'lat');
$f_lon	= getUrlParam('HTTP_GET', 'FLOAT', 'lon');
$zoom 	= getUrlParam('HTTP_GET', 'INT', 'zoom');
$marker	= getUrlParam('HTTP_GET', 'INT', 'marker');
$poi 	= getUrlParam('HTTP_GET', 'INT', 'poi');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$cfg['embedded_mode'] || !$cfg['public_host'] || check_password($cfg['admin_password'])) {
	HTML::heading(_APP_NAME, 2);
	HTML::main_menu();
}

$f_minlat = 0;
$f_maxlat = 0;
$f_minlon = 0;
$f_maxlon = 0;

if(!$zoom)	$zoom = 15;
if(!$f_lat || !$f_lon) {
	if($id) {
		if(!$gpx) {
			$query = "SELECT * FROM `${cfg['db_table_prefix']}gpx_files` 
						WHERE `id` = '$id' ;";
			$result = db_query($query);
			if($DEBUG)	out($query, 'OUT_DEBUG');
			if(mysql_num_rows($result)) {
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$gpx = $row['name'];
				}
			}
		}
		
	    $query = "SELECT `gpx_id`, 
			MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat', AVG(`latitude`) AS 'avglat', 
			MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon', AVG(`longitude`) AS 'avglon'
			FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' GROUP BY `gpx_id` ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$f_minlat = $row['minlat'] /1000000;
				$f_maxlat = $row['maxlat'] /1000000;
				$f_minlon = $row['minlon'] /1000000;
				$f_maxlon = $row['maxlon'] /1000000;
	    	}
		}else {
		    $query = "SELECT `gpx_id`, 
				MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat', AVG(`latitude`) AS 'avglat', 
				MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon', AVG(`longitude`) AS 'avglon'
				FROM `${cfg['db_table_prefix']}waypoints` WHERE `gpx_id` = '$id' GROUP BY `gpx_id` ;";
		    $result = db_query($query);
			if($DEBUG)	out($query, 'OUT_DEBUG');
		    if(mysql_num_rows($result)) {
		    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$f_minlat = $row['minlat'] /1000000;
					$f_maxlat = $row['maxlat'] /1000000;
					$f_minlon = $row['minlon'] /1000000;
					$f_maxlon = $row['maxlon'] /1000000;
		    	}
			}
		}
	}else {
		$f_lat = $cfg['home_latitude'];
		$f_lon = $cfg['home_longitude'];
		$zoom = $cfg['home_zoom'];
	}
}

$map = new SlippyMap();
$map->setMapSize($cfg['page_width'], $cfg['map_height']);
$map->setMapCenter($f_lat, $f_lon, $zoom);
$map->setBoundingBox($f_maxlat, $f_maxlon, $f_minlat, $f_minlon);
if($cfg['local_tile_proxy'] && checkCapability('proxysimple'))
	$map->enableFeatures(array('proxy'=>TRUE));
$map->enableFeatures(array('gpx'=>$gpx));
if($marker)
	$map->enableOverlays(new Layer('marker',TRUE));
if($cfg['photo_features'])
	$map->enableOverlays(new Layer('photos',TRUE));
$map->enableOverlays(new Layer('hiking',TRUE));
$map->embedJSincludes();
$map->embedMapcontainer();

if(!$cfg['embedded_mode']) {
?>

<img src="images/b_bookmark.png" />
<input type="hidden" name="url" id="bookmarklink" />
<a href="JavaScript:addBookmark();"><?php echo _MAP_ADD_BOOKM ?></a><br />
<img src="images/b_select.png" />
<a href="" id="searchGPXlink"><?php echo _MENU_GPX ?></a>&nbsp;
<img src="images/b_select.png" />
<a href="" id="searchTRKPTlink"><?php echo _MENU_TRKPT ?></a>&nbsp;
<img src="images/b_select.png" />
<a href="" id="searchWPTlink"><?php echo _MENU_WPT ?></a><?php echo _MAP_CURRENT_AREA ?><br />
<img src="images/icon_josm.png" />
<a target="josm" href="" id="josmlink"><?php echo _MAP_JOSM_EDIT ?></a>&nbsp;
<img src="images/icon_osb.png" />
<a target="osb" href="" id="osblink">OpenStreetBugs</a>&nbsp;
<img src="images/icon_keepright.png" />
<a target="keepright" href="" id="keeprightlink">keep right!</a><br />

<?php
}
$map->embedJSinitMap();

if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>