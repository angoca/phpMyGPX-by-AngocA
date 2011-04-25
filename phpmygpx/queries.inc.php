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

//! Retreives the closer photo to a given set of coordinates.
'closerPhoto_1' => ''
.'SELECT * '
.'FROM '.$cfg['db_table_prefix'].'pois '
.'INNER JOIN ('
.'  SELECT id, min(distance) min '
.'  FROM ( '
.'    SELECT id, distanceBtwPoints(',
'closerPhoto_2' => ', ',
'closerPhoto_3' => ', longitude, latitude) distance '
.'    FROM '.$cfg['db_table_prefix'].'pois '
.'    GROUP BY distance, id '
.'  ) distances'
.') mindist ON pois.id = mindist.id',
);
?>
