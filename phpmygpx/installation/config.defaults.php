<?php
/**
* @version $Id: config.defaults.php 320 2010-07-24 21:02:57Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/


// This file contains just default values of all config vars.
// To change your REAL configuration, please edit "config.inc.php" one dir level up! 

$cfg['db_host']				= 'localhost';	// MySQL server, in general 'localhost'
$cfg['db_name'] 			= 'osm';		// name of database to be used
$cfg['db_table_prefix'] 	= '';			// can be empty
$cfg['db_user'] 			= 'username';	// MySQL user name
$cfg['db_password']			= 'password';	// MySQL user password

$cfg['admin_password']		= 'pass';		// admin password for public hosting 
$cfg['public_host']			= TRUE;			// disable write access to database
$cfg['embedded_mode']		= FALSE;		// disable menue etc. to use within web sites
$cfg['use_local_libs']		= TRUE;			// use bundled OpenLayers + OSM JS libraries
$cfg['local_tile_proxy']	= TRUE;			// enable local cache proxy for map tiles
$cfg['check_updates']		= TRUE;			// check for software updates

$cfg['photo_features']      = TRUE;			// enable all photo related features
$cfg['photo_thumb_width']	= 150;			// thumbnail width (pixel)
$cfg['photo_jpeg_quality']	= 80;			// JPEG compression/quality level [0...100]

$cfg['pma_app_path']        = '../phpMyAdmin';// web server path to 'phpMyAdmin'
$cfg['pma_app_show_link']   = FALSE;		// show link to 'phpMyAdmin' database tool

$cfg['validate_gpx_xml']	= TRUE;         // validate XML structure of GPX files on import
$cfg['chmod_on_import']		= FALSE;		// try to chmod files to 0644 on import 
$cfg['max_timediff_import']	= 30;			// max time diff (trkpt/cam) for photo import (seconds)

$cfg['max_file_size']		= 4194304;		// max file size (bytes) for uploading (4 MB)
$cfg['image_size']			= 170;			// image size (pixel) of track preview
$cfg['image_big_size']		= 600;			// image size (pixel)
$cfg['map_height']			= 500;			// map height (pixel)
$cfg['page_width']			= 900;			// page width (pixel)
$cfg['chart_width']			= 900;			// chart width (pixel), should be the same as page width
$cfg['chart_height']		= 250;			// chart height (pixel)
$cfg['chart_big_width']		= 1200;			// chart width (pixel)
$cfg['chart_big_height']	= 600;			// chart height (pixel)
$cfg['chart_altitude_type']	= 'time';		// chart type: altitude against 'time' or 'dist'

$cfg['pref_cookie_lifetime']= 720;			// lifetime of preferences cookie (hours)
$cfg['result_table_limit']	= 25;			// max number of result table rows to display
$cfg['result_datalayer_limit'] = 150;		// max number of pois to draw on map
$cfg['show_exec_time']      = TRUE;			// show execution time of scripts

$cfg['config_language']     = 'german';		// frontend language; see "languages" directory
$cfg['config_locale']		= 'de_DE.UTF-8';// locale, value depends on OS (Linux, Win)
$cfg['timezone_offset']		= 1;			// timezone offset to GMT [-12...12] hours

$cfg['home_latitude']		= 51.00;		// default map center lat/lon (degrees)
$cfg['home_longitude']		= 10.00;		// - just set to your home location
$cfg['home_zoom']			= 6;			// default zoom for map home location [1...17]
$cfg['dist_threshold'] 		= .5;			// th. for distance calculation (in kilometers)
$cfg['time_threshold'] 		= 600;			// th. for distance calculation (in seconds)
$cfg['alt_data_filter_mva']	= 15;			// moving average filter param for altitude data
?>