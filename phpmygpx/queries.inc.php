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

//! Retreives the closer photo to a given set of coordinates.
$dbqueries['closerPhoto_1'] = ''
.'SELECT id, min(distance) '
.'FROM ( '
.'    SELECT id, distanceBtwPoints(';
$dbqueries['closerPhoto_2'] = ',';
$dbqueries['closerPhoto_3'] = ''
.', longitude, latitude) distance '
.'    FROM '.$cfg['db_table_prefix'].'pois '
.'    GROUP BY distance, id '
.') distances';