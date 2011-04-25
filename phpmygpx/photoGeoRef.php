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

$task = getUrlParam('HTTP_GET', 'STRING', 'task');
$f_x = getUrlParam('HTTP_GET', 'FLOAT', 'x') * 1000000;
$f_y = getUrlParam('HTTP_GET', 'FLOAT', 'y') * 1000000;
$f_limit = getUrlParam('HTTP_GET', 'FLOAT', 'limit');
$f_img_dir = getUrlParam('HTTP_GET', 'FLOAT', 'img_dir');
$f_img_delta = getUrlParam('HTTP_GET', 'FLOAT', 'img_delta');
$f_pos_dir = getUrlParam('HTTP_GET', 'FLOAT', 'pos_dir');
$f_pos_delta = getUrlParam('HTTP_GET', 'FLOAT', 'pos_delta');

// Connects to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'],
$cfg['db_password']);

switch ($task) {
    case 'getClosestPhotos':
        getClosestPhotos($f_x, $f_y, $f_limit);
        break;

    case 'getClosestPhoto':
        getClosestPhoto($f_x, $f_y);
        break;

    case 'getClosestPhotosWithOrientation':
        getClosestPhotosWithOrientation($f_x, $f_y, $f_img_dir, $f_img_delta, $f_limit);
        break;

    case 'getClosestPhotoWithOrientation':
        getClosestPhotoWithOrientation($f_x, $f_y, $f_img_dir, $f_img_delta);
        break;

    case 'getClosestPhotosOverDirection':
        getClosestPhotosOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta, $f_limit);
        break;

    case 'getClosestPhotoOverDirection':
        getClosestPhotoOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta);
        break;

    case 'getClosestPhotosWithOrientationOverDirection':
        getClosestPhotosWithOrientationOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta, $f_img_dir, $f_img_delta, $f_limit);
        break;

    case 'getClosestPhotoWithOrientationOverDirection':
        getClosestPhotoWithOrientationOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta, $f_img_dir, $f_img_delta);
        break;

    default:
        getData();
        break;
}

function getClosestPhotos($x, $y, $limit) {
    global $DEBUG, $cfg, $dbqueries;
    $query = $dbqueries['closestPhotos_1'].$x.$dbqueries['closestPhotos_2'].$y
    .$dbqueries['closestPhotos_3'].$limit;
    if ($DEBUG){
        out($query, 'OUT_DEBUG');
    }
    $result = db_query($query);
    $ret = "{";
    $ret .= "  \"photos\": {";
    if(mysql_num_rows($result)) {
        while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            if ($started){
                $ret .= ", ";
            }
            $started = TRUE;
            // Writes the description in JSON format.
            $ret .= "    \"photo\": {";
            $ret .= "      \"id\": \"".$row['id'].'", ';
            $ret .= "      \"altitude\": \"".$row['altitude'].'", ';
            $ret .= "      \"latitude\": \"".($row['latitude']/1000000).'", ';
            $ret .= "      \"longitude\": \"".($row['longitude']/1000000).'", ';
            $ret .= "      \"timestamp\": \"".$row['timestamp'].'", ';
            $ret .= "      \"image_dir\": \"".$row['image_dir'].'", ';
            $ret .= "      \"speed\": \"".$row['speed'].'", ';
            $ret .= "      \"move_dir\": \"".$row['move_dir'].'", ';
            $ret .= "      \"size\": \"".$row['size'].'", ';
            $ret .= "      \"file\": \"".$row['file'];
            $ret .= "    }";

            // Writes an hyperlink to the photo.
            $photos .= "<p><a href='${cfg['photo_images_dir']}${row['file']}'>";
            $photos .= "<img src='${cfg['photo_thumbs_dir']}${cfg['thumbs_prefix']}${row['file']}' hspace=5 /></a></p>";
        }
    }
    $ret .= "  }";
    $ret .= "}";
    echo $ret;
    echo $photos;
}

function getClosestPhoto($x, $y) {
    global $DEBUG, $cfg, $dbqueries;
    $query = $dbqueries['closestPhoto_1'].$x.$dbqueries['closestPhoto_2'].$y
    .$dbqueries['closestPhoto_3'];
    if($DEBUG) {
        out($query, 'OUT_DEBUG');
    }
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
        $ret .= "    \"file\": \"".$row['file'];
        $ret .= "  }";
        $ret .= "}";
        echo $ret;

        // Writes an hyperlink to the photo.
        echo "<p><a href='${cfg['photo_images_dir']}${row['file']}'>";
        echo "<img src='${cfg['photo_thumbs_dir']}${cfg['thumbs_prefix']}${row['file']}' hspace=5 /></a></p>";
    } else {
        echo "{}";
    }
}

function getClosestPhotosWithOrientation($x, $y, $img_dir, $img_delta, $limit) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$img_dir."-".$img_delta."-".$limit."\"}";
}

function getClosestPhotoWithOrientation($x, $y, $img_dir, $img_delta) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$img_dir."-".$img_delta."\"}";
}

function getClosestPhotosOverDirection($x, $y, $pos_dir, $pos_delta, $limit) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$pos_dir."-".$pos_delta."-".$limit."\"}";
}

function getClosestPhotoOverDirection($x, $y, $pos_dir, $pos_delta) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$pos_dir."-".$pos_delta."\"}";
}

function getClosestPhotosWithOrientationOverDirection($x, $y, $pos_dir, $pos_delta, $img_dir, $img_delta, $limit) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$pos_dir."-".$pos_delta."-".$img_dir."-".$img_delta."-".$limit."\"}";
}

function getClosestPhotoWithOrientationOverDirection($x, $y, $pos_dir, $pos_delta, $img_dir, $img_delta) {
    global $DEBUG, $cfg, $dbqueries;
    echo "{\"Note\": \"To be done ".$x."-".$y."-".$pos_dir."-".$pos_delta."-".$img_dir."-".$img_delta."\"}";
}

if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}

?>
