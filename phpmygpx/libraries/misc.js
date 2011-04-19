/**
* @version $Id: misc.js 319 2010-07-23 21:38:57Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

var DEBUG = 0;

// map.php
function addBookmark() {
	bookmarkName = prompt(i18n_strings['_MAP_JS_BOOKM_NAME']);
	if(bookmarkName) {
		var bookmarkScript = "bookmark.php?task=add&name=" + 
			encodeURIComponent(bookmarkName) + "&url=";
		var bookmarkLink = String(document.getElementById('bookmarklink').value);
		document.location.href = bookmarkScript + encodeURIComponent(bookmarkLink);
	}
}

// traces.php waypoints.php
function copyDate() {
	document.getElementsByName('date_to')[0].value = 
		document.getElementsByName('date_from')[0].value;
}

// traces.php
function changeChartType(type) {
	if (type == 'dist') {
		type_old = 'time'
	}
	if (type == 'time') {
		type_old = 'dist'
	}
	var chart_count = 1;
	while(document.getElementById("chart_" + chart_count)) {
		var chart_src = document.getElementById("chart_" + chart_count).src;
		var chart_src_new = chart_src.replace(type_old, type);
		document.getElementById("chart_" + chart_count).src = chart_src_new;
		
		var chart_link = document.getElementById("chart_link_" + chart_count).href;
		var chart_link_new = chart_link.replace(type_old, type);
		document.getElementById("chart_link_" + chart_count).href = chart_link_new;
		chart_count++;
	}
}

// photos.php
function toggleGeoTaggingFields() {
	if (document.batch_import_form.elements['gpx_id'].value != 0) {
		document.batch_import_form.elements['tz'].disabled = false;
		document.batch_import_form.elements['offset'].disabled = false;
	} else {
		document.batch_import_form.elements['tz'].disabled = true;
		document.batch_import_form.elements['offset'].disabled = true;
	}
}

// html.classes.php
function changeResultLimit(limit, url) {
	location.href = url + '&l=' + limit;
}
