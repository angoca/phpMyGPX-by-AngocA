<?php
/**
* @version $Id: waypoints.html.php 341 2010-08-22 20:59:49Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

include("./config.inc.php");

class HTML_waypoints {
    function viewWPTsTableHeader($url, $sort, $order) {
		echo "<table class='data'>";
        echo "<tr class='head'>";
        HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
        echo "<th>"._CMN_LAT."</th><th>"._CMN_LON."</th>";
        HTML::viewTabColHead($url, 2, $sort, $order, _CMN_ALT);
        HTML::viewTabColHead($url, 4, $sort, $order, _CMN_NAME);
		echo "<th>"._CMN_COMMENT."</th><th>"._CMN_DESCRIPTION."</th>";
		HTML::viewTabColHead($url, 1, $sort, $order, _CMN_GPX_ID);
		echo "</tr>\n";
	}

    function viewWPTsTableRow($tp) {
    	$lat = $tp['latitude']/1000000;
    	$lon = $tp['longitude']/1000000;
		echo "<tr><td>". strftime(_DATE_FORMAT_LC3, strtotime($tp['timestamp']) + $tp['timezone']*3600) ."</td>
			<td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lat</td>
			<td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lon</td>
			<td>$tp[altitude]</td>
			<td>$tp[name]</td><td>$tp[cmt]</td><td>$tp[desc]</td>
			<td>". HTML::getGpxLink($tp) ."</td>
			</tr>\n";
	}

    function viewWPTsTableFooter() {
		echo "</table>\n";
	}

	function searchWptForm($url) {
        echo "<form method='get' action='$url' class='filter'>\n";
        echo "<table border=0><tr><td colspan=4>";
		echo _TRC_CHOOSE_SEARCH_FILTER ."<br />\n";
		echo _TRC_SEARCH_PARAMS_LOGIC_AND ."<br />\n";
		echo _TRC_USE_DP_FOR_SEARCH ."<br />\n";
		echo _CMN_MOUSEOVER_FOR_TOOLTIP ."<br />\n";
		echo '<input type="hidden" name="task" value="view">';
		echo '<input type="hidden" name="option" value="search">';
		echo "</td></tr><tr>";
		echo '<td>'. _CMN_DATE .' [YYYY-MM-DD]: '. _CMN_FROM .'</td>
			<td><input type="text" name="date_from" title="[YYYY-MM-DD]"></td>
			<td><a href="javascript:copyDate();" title="'._CMN_COPY_DATE.'" >[&gt;&gt;]</a> '._CMN_TO.' </td>
			<td><input type="text" name="date_to" title="[YYYY-MM-DD]"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_LAT .': </td><td><input type="text" name="lat" title="[-90.0 ... +90.0]">&deg;</td>';
		echo '<td> +/- '. _CMN_RANGE .': </td><td><input type="text" name="lat_range">&deg;</td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_LON .': </td><td><input type="text" name="lon" title="[-180.0 ... +180.0]">&deg;</td>';
		echo '<td> +/- '. _CMN_RANGE .': </td><td><input type="text" name="lon_range">&deg;</td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_NAME .': </td><td colspan=3><input type="text" name="name" size="32"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_COMMENT .': </td><td colspan=3><input type="text" name="cmt" size="32"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_DESCRIPTION .': </td><td colspan=3><input type="text" name="desc" size="32"></td>';
		echo "</tr><tr>";
        echo "<td colspan=4><input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</td></tr></table>";
        echo "</form>\n";
	}

    function deleteForm($url, $id) {
        echo "<form method='post' action='$url' class='filter'>\n";
        echo "<h3 style='font-weight:bold;color:red;'>"._CMN_WARNING."</h3>\n";
		echo "<p>"._MENU_GPX." # $id:<br />"._TRC_REALLY_DELETE."</p>\n";
		echo "<p>"._TRC_CONFIRM_DELETE."</p>\n";
        echo "<input type='text' name='confirm' value='"._CMN_NO."'>\n";
        echo "<input type='submit' name='submit_btn' value='"._MENU_GPX_DELETE."' onClick='submit();'>\n";
        echo "<input type='hidden' name='submit' value='delete'>\n";
        echo "\n";
        echo "</form>\n";
    }
}
?>