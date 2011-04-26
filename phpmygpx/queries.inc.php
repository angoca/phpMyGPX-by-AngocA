<?php
/**
 * This file contains the database queries. This externalized file
 * permits to implement a new database access modifying less files.
 *
 * @version $Id$
 * @package phpmygpx
 * @copyright Copyright (C) 2011 Andres Gomez Casanova.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

include("./config.inc.php");

/**
 * Query for the list of the closest photos to the given point. The quantity is
 * determined by $limit.
 * @global array $cfg Configuration.
 * @param float $x Point's longitude.
 * @param float $y Point's latitude.
 * @param int $limit Max quantity of photos to return.
 */
function getQueryClosestPhotos($x, $y, $limit) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ( '
    .'  SELECT id, '
    .'  distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'  FROM '.$cfg['db_table_prefix'].'pois '
    .'  GROUP BY distance, id '
    .') photos ON pois.id = photos.id '
    .'ORDER BY distance '
    .'LIMIT 0, '.$limit;

    return $ret;
}

/**
 * Query for the closest photo to the given coordinates.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 */
function getQueryClosestPhoto($x, $y) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ('
    .'  SELECT id, min(distance) min '
    .'  FROM ( '
    .'    SELECT id, '
    .'    distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'    FROM '.$cfg['db_table_prefix'].'pois '
    .'    GROUP BY distance, id '
    .'  ) distances '
    .') photo ON pois.id = photo.id';

    return $ret;
}

/**
 * Query for the list of closest photos that has a given orientation. The list
 * is limited by $limit.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @param int $limit Maximal quantity of photos to return.
 */
function getQueryClosestPhotosWithOrientation($x, $y, $img_dir, $img_delta, $limit) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ( '
    .'  SELECT id, '
    .'  distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'  FROM '.$cfg['db_table_prefix'].'pois '
    .'  WHERE photoInRange(image_dir, '.$img_dir.', '.$img_delta.') > 0 '
    .'  GROUP BY distance, id '
    .') photos ON pois.id = photos.id '
    .'ORDER BY distance '
    .'LIMIT 0, '.$limit;

    return $ret;
}

/**
 * Query for the closest photo that has a given orientation.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 */
function getQueryClosestPhotoWithOrientation($x, $y, $img_dir, $img_delta) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ('
    .'  SELECT id, min(distance) min '
    .'  FROM ( '
    .'    SELECT id, '
    .'    distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'    FROM '.$cfg['db_table_prefix'].'pois '
    .'    WHERE photoInRange(image_dir, '.$img_dir.', '.$img_delta.') > 0 '
    .'    GROUP BY distance, id '
    .'  ) distances '
    .') photo ON pois.id = photo.id';

    return $ret;
}

/**
 * Query for the photos that are located over a given angle with delta from a
 * set of coordinates.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param int $limit Maximal quantity of photos to return.
 */
function getQueryClosestPhotosOverDirection($x, $y, $pos_dir, $pos_delta, $limit) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ( '
    .'  SELECT id, '
    .'  degreesFromPoint('.$x.', '.$y.', longitude, latitude) degrees, '
    .'  distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'  FROM '.$cfg['db_table_prefix'].'pois '
    .'  WHERE photoInRange(degreesFromPoint('.$x.', '.$y.', longitude, '
    .'  latitude), '.$pos_dir.', '.$pos_delta.') > 0 '
    .'  GROUP BY distance, degrees, id '
    .'  ORDER BY distance, degrees '
    .') photos ON pois.id = photos.id '
    .'ORDER BY distance '
    .'LIMIT 0, '.$limit;

    return $ret;
}

/**
 * Query for the closest photo in a given angle with delta from a given set of
 * coordinates.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 */
function getQueryClosestPhotoOverDirection($x, $y, $pos_dir, $pos_delta) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ('
    .'  SELECT id, min(distance) min '
    .'  FROM ( '
    .'    SELECT id, '
    .'    degreesFromPoint('.$x.', '.$y.', longitude, latitude) degrees, '
    .'    distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'    FROM '.$cfg['db_table_prefix'].'pois'
    .'    WHERE photoInRange(degreesFromPoint('.$x.', '.$y.', longitude, '
    .'    latitude), '.$pos_dir.', '.$pos_delta.') > 0 '
    .'    GROUP BY distance, degrees, id '
    .'  ) distances '
    .') photo ON pois.id = photo.id';

    return $ret;
}

/**
 * Query for the list of the closest photos that are located in a given angle
 * with delta with a given direction also with delta from a given set of
 * coordinates. The quantity of photos is delimited by $limit.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 * @param int $limit Max quantity of photos.
 */
function getQueryClosestPhotosWithOrientationOverDirection($x, $y, $pos_dir,
$pos_delta, $img_dir, $img_delta, $limit) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ( '
    .'  SELECT id, '
    .'  degreesFromPoint('.$x.', '.$y.', longitude, latitude) degrees, '
    .'  distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'  FROM '.$cfg['db_table_prefix'].'pois '
    .'  WHERE photoInRange(degreesFromPoint('.$x.', '.$y.', longitude, '
    .'  latitude), '.$pos_dir.', '.$pos_delta.') > 0 '
    .'  AND photoInRange(image_dir, '.$img_dir.', '.$img_delta.') > 0 '
    .'  GROUP BY distance, degrees, id '
    .'  ORDER BY distance, degrees '
    .') photos ON pois.id = photos.id '
    .'ORDER BY distance '
    .'LIMIT 0, '.$limit;

    return $ret;
}

/**
 * Query for the closest photo that is located in a given angle with delta,
 * pointing to a given direction also with delta, from a given set of
 * coordinates.
 * @global array $cfg Configuration.
 * @param float $x Longitude.
 * @param float $y Latitude.
 * @param float $pos_dir Position direction/orientation.
 * @param float $pos_delta Delta of the position direction/orientation.
 * @param float $img_dir Image direction/orientation.
 * @param float $img_delta Delta of the image direction/orientation.
 */
function getQueryClosestPhotoWithOrientationOverDirection($x, $y, $pos_dir,
$pos_delta, $img_dir, $img_delta) {
    global $cfg;
    $ret = ''
    .'SELECT * '
    .'FROM '.$cfg['db_table_prefix'].'pois '
    .'INNER JOIN ('
    .'SELECT id, min(distance) min '
    .'FROM ( '
    .'  SELECT id, '
    .'  distanceBtwPoints('.$x.', '.$y.', longitude, latitude) distance '
    .'  FROM '.$cfg['db_table_prefix'].'pois '
    .'  WHERE photoInRange(degreesFromPoint('.$x.', '.$y.', longitude, '
    .'  latitude), '.$pos_dir.', '.$pos_delta.') > 0 '
    .'  AND photoInRange(image_dir, '.$img_dir.', '.$img_delta.') > 0 '
    .') distances '
    .') photo ON pois.id = photo.id';

    return $ret;
}
?>
