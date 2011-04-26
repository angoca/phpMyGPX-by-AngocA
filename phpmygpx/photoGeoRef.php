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
$f_limit = getUrlParam('HTTP_GET', 'INT', 'limit');
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
        getClosestPhotosWithOrientation($f_x, $f_y, $f_img_dir, $f_img_delta,
        $f_limit);
        break;

    case 'getClosestPhotoWithOrientation':
        getClosestPhotoWithOrientation($f_x, $f_y, $f_img_dir, $f_img_delta);
        break;

    case 'getClosestPhotosOverDirection':
        getClosestPhotosOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta,
        $f_limit);
        break;

    case 'getClosestPhotoOverDirection':
        getClosestPhotoOverDirection($f_x, $f_y, $f_pos_dir, $f_pos_delta);
        break;

    case 'getClosestPhotosWithOrientationOverDirection':
        getClosestPhotosWithOrientationOverDirection($f_x, $f_y, $f_pos_dir,
        $f_pos_delta, $f_img_dir, $f_img_delta, $f_limit);
        break;

    case 'getClosestPhotoWithOrientationOverDirection':
        getClosestPhotoWithOrientationOverDirection($f_x, $f_y, $f_pos_dir,
        $f_pos_delta, $f_img_dir, $f_img_delta);
        break;

    default:
        getData();
        break;
}

/**
 *
 * Thrown when the given value for a longitude or latitude is not valid.
 */
class InvalidCoordinateException extends Exception {}

/**
 * Thrown when the given number is not valid.
 */
class InvalidNumberException extends Exception {}

/**
 * Thrown when the given degree is not valid.
 */
class InvalidDegreeException extends Exception {}

/**
 * Validates a longitude or latitude.
 * @param float $value coordinate.
 * @param string $type Latitude or longitude for the message.
 * @throws InvalidLongitudeException If the value is not valid.
 */
function validateCoordinate($value, $type){
    if ((! is_numeric($value)) || ($value < -180000000)
    || ($value > 180000000)) {
        throw new InvalidCoordinateException('The value \''.$value.'\' is an '
        .'invalid format for a '.$type);
    }
}

/**
 * Validates if the given value is a positive integer.
 * @param int $value Value to verify.
 * @param string $type Name of the value.
 * @throws InvalidNumberException If the given value is invalid.
 */
function validatePostiveInteger($value, $type){
    if ((! is_numeric($value)) || ($value < 0)) {
        throw new InvalidNumberException('The value \''.$value.'\' is an '
        .'invalid format for a '.$type);
    }
}

/**
 * Validates if the given value is a correct degree (0-360).
 * @param float $value Value to verify.
 * @param string $type Name of the degree.
 * @throws InvalidDegreeException If the given value is invalid.
 */
function validateDegree($value, $type){
    if ((! is_numeric($value)) || ($value < 0) || ($value > 360)) {
        throw new InvalidDegreeException('The value \''.$value.'\' is an '
        .'invalid format for a '.$type);
    }
}

/**
 * Process a database row to return a photo description in JSON format.
 * @param Array $row Database row that contains the description of a photo.
 * @return Description in JSON format.
 */
function photoJSON($row) {
    $ret = "";
    // Writes the description in JSON format.
    $ret .= "\"photo\": {";
    $ret .= "  \"id\": \"".$row['id'].'", ';
    $ret .= "  \"altitude\": \"".$row['altitude'].'", ';
    $ret .= "  \"latitude\": \"".($row['latitude']/1000000).'", ';
    $ret .= "  \"longitude\": \"".($row['longitude']/1000000).'", ';
    $ret .= "  \"timestamp\": \"".$row['timestamp'].'", ';
    $ret .= "  \"image_dir\": \"".$row['image_dir'].'", ';
    $ret .= "  \"speed\": \"".$row['speed'].'", ';
    $ret .= "  \"move_dir\": \"".$row['move_dir'].'", ';
    $ret .= "  \"size\": \"".$row['size'].'", ';
    $ret .= "  \"file\": \"".$row['file'].'"';
    $ret .= "}";
    return $ret;
}

/**
 * Creates the HTML tags for a photo link.
 * @global array $cfg Configuration.
 * @param Array $row Description of the photo.
 * @return String that has a link to the photo.
 */
function photoLink($row) {
    global $cfg;
    $photo = "";
    $photo .= "<p><a href='${cfg['photo_images_dir']}${row['file']}'>";
    $photo .= "<img src='${cfg['photo_thumbs_dir']}${cfg['thumbs_prefix']}";
    $photo .= "${row['file']}' hspace=5 />";
    $photo .= "</a></p>";
    return $photo;
}

/**
 * Process a query, and prints the result that describe a series of photos.
 * @global boolean $DEBUG Logger level.
 * @param string $query Query to get the photos description.
 */
function processDBQuery($query) {
    global $DEBUG;
    if ($DEBUG){
        out($query, 'OUT_DEBUG');
    }
    $result = db_query($query);
    $ret = "{";
    $ret .= "  \"photos\": {";
    $link = "";
    if(mysql_num_rows($result)) {
        while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            if ($started){
                $ret .= ", ";
            }
            $started = TRUE;
            // Writes the description in JSON format.
            $ret .= photoJSON($row);

            // Writes an hyperlink to the photo.
            $link .= photoLink($row);
        }
    }
    $ret .= "  }";
    $ret .= "}";
    echo $ret;
    echo $link;

}

/**
 * Retrieves a list of the closest photos to the given point. The quantity is
 * determined by $limit.
 * @param float $x Point's longitude.
 * @param float $y Point's latitude.
 * @param int $limit Max quantity of photos to return.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidNumberException If $limit is not valid.
 */
function getClosestPhotos($x, $y, $limit) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validatePostiveInteger($limit, 'limit');

    $query = getQueryClosestPhotos($x, $y, $limit);
    processDBQuery($query);
}

/**
 * Returns the closest photo to the given coordinates.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 */
function getClosestPhoto($x, $y) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');

    $query = getQueryClosestPhoto($x, $y);
    processDBQuery($query);
}

/**
 * Retrieves a list of closest photos that has a given orientation. The list is
 * limited by $limit.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @param int $limit Maximal quantity of photos to return.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $img_dir or $img_delta are not valid
 * degrees.
 * @throws InvalidNumberException If $limit is not valid.
 */
function getClosestPhotosWithOrientation($x, $y, $img_dir, $img_delta, $limit) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($img_dir, 'image direction/orientation');
    validateDegree($img_delta, 'image delta direction/orientation');
    validatePostiveInteger($limit, 'limit');

    $query = getQueryClosestPhotosWithOrientation($x, $y, $img_dir, $img_delta,
    $limit);
    processDBQuery($query);
}

/**
 * Retrieves the closest photo that has a given orientation.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $img_dir or $img_delta are not valid
 * degrees.
 */
function getClosestPhotoWithOrientation($x, $y, $img_dir, $img_delta) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($img_dir, 'image direction/orientation');
    validateDegree($img_delta, 'image delta direction/orientation');

    $query = getQueryClosestPhotoWithOrientation($x, $y, $img_dir, $img_delta);
    processDBQuery($query);
}

/**
 * Retrieves the photos that are located over a given angle with delta from a
 * set of coordinates.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param int $limit Maximal quantity of photos to return.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $pos_dir or $pos_delta are not valid
 * degrees.
 * @throws InvalidNumberException If $limit is not valid.
 */
function getClosestPhotosOverDirection($x, $y, $pos_dir, $pos_delta, $limit) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($pos_dir, 'position direction/direction');
    validateDegree($pos_delta, 'position delta direction/orientation');
    validatePostiveInteger($limit, 'limit');

    $query = getQueryClosestPhotosOverDirection($x, $y, $pos_dir, $pos_delta,
    $limit);
    processDBQuery($query);
}

/**
 * Return the closest photo in a given angle with delta from a given set of
 * coordinates.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $pos_dir or $pos_delta are not valid
 * degrees.
 */
function getClosestPhotoOverDirection($x, $y, $pos_dir, $pos_delta) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($pos_dir, 'position direction/direction');
    validateDegree($pos_delta, 'position delta direction/orientation');

    $query = getQueryClosestPhotoOverDirection($x, $y, $pos_dir, $pos_delta);
    processDBQuery($query);
}

/**
 * Return a list of the closest photos that are located in a given angle with
 * delta with a given direction also with delta from a given set of coordinates.
 * The quantity of photos is delimited by $limit.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @param int $limit Max quantity of photos.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $pos_dir, $pos_delta, $img_dir or
 * $img_delta are not valid
 * @throws InvalidNumberException If $limit is not valid.
 */
function getClosestPhotosWithOrientationOverDirection($x, $y, $pos_dir,
$pos_delta, $img_dir, $img_delta, $limit) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($pos_dir, 'position direction/direction');
    validateDegree($pos_delta, 'position delta direction/orientation');
    validateDegree($img_dir, 'image direction/orientation');
    validateDegree($img_delta, 'image delta direction/orientation');
    validatePostiveInteger($limit, 'limit');

    $query = getQueryClosestPhotosWithOrientationOverDirection($x, $y, $pos_dir,
    $pos_delta, $img_dir, $img_delta, $limit);
    processDBQuery($query);
}

/**
 * Retrieves the closest photo that is located in a given angle with delta,
 * pointing to a given direction also with delta, from a given set of
 * coordinates.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @throws InvalidCoordinateException If $x or $y are not valid coordinates.
 * @throws InvalidDegreeException If $pos_dir, $pos_delta, $img_dir or
 * $img_delta are not valid
 */
function getClosestPhotoWithOrientationOverDirection($x, $y, $pos_dir,
$pos_delta, $img_dir, $img_delta) {
    validateCoordinate($x, 'longitude');
    validateCoordinate($y, 'latitude');
    validateDegree($pos_dir, 'position direction/direction');
    validateDegree($pos_delta, 'position delta direction/orientation');
    validateDegree($img_dir, 'image direction/orientation');
    validateDegree($img_delta, 'image delta direction/orientation');

    $query = getQueryClosestPhotoWithOrientationOverDirection($x, $y, $pos_dir,
    $pos_delta, $img_dir, $img_delta);
    processDBQuery($query);
}

if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}

?>
