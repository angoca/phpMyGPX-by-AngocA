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

$dbqueries = array (

//! Retreives a list of the closest photo to a given set of coordinates.
'closestPhotos_1' => ''
.'SELECT * '
.'FROM '.$cfg['db_table_prefix'].'pois '
.'INNER JOIN ('
.'  SELECT id, distanceBtwPoints(',
'closestPhotos_2' => ', ',
'closestPhotos_3' => ', longitude, latitude) distance '
.'  FROM '.$cfg['db_table_prefix'].'pois '
.'  GROUP BY distance, id '
.') distances ON pois.id = distances.id'
.'ORDER BY distance '
.'LIMIT 0, ',

//! Retreives the closest photo to a given set of coordinates.
'closestPhoto_1' => ''
.'SELECT * '
.'FROM '.$cfg['db_table_prefix'].'pois '
.'INNER JOIN ('
.'  SELECT id, min(distance) min '
.'  FROM ( '
.'    SELECT id, distanceBtwPoints(',
'closestPhoto_2' => ', ',
'closestPhoto_3' => ', longitude, latitude) distance '
.'    FROM '.$cfg['db_table_prefix'].'pois '
.'    GROUP BY distance, id '
.'  ) distances'
.') mindist ON pois.id = mindist.id',
);
?>
