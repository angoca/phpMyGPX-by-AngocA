<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Map Comparator v1.1</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="description" content="TODO" />
<link rel="shortcut icon" type="image/png"
    href="http://shared.gmapify.fr/images/favicon.png" />

<style type="text/css">
a {
    color: #f29400;
    text-decoration: none;
    font-weight: bold
}

a:hover {
    color: #ff4400
}

a:active {
    color: #f29400
}

html {
    height: 100%;
    overflow: hidden;
}

body {
    height: 100%;
    overflow: hidden;
}

table {
    width: 100%;
    height: 95%
}

td {
    width: 50%;
    padding: 5px
}

img {
    border: 0
}

.mainMap {
    background-color: #ff0000;
}
</style>
</head>
<body style="font-family: Arial, sans serif;" onunload="GUnload()">
    <p>Designed with Mapstraction. Click on a map to set it as reference
        before zoom in/out or pan. Only Google Maps and OpenStreetMap can
        currently be reference.</p>

    <table>
        <tr>
            <td id="gmap_cell" style='height: 50%;'>
                <div id="gmap"
                    style="width: 100%; height: 100%; border: 1px solid black;"></div>
            </td>
            <td id="ymap_cell" style='height: 50%;'>
                <div id="ymap"
                    style="width: 100%; height: 100%; border: 1px solid black;"></div>
            </td>
        </tr>
        <tr>
            <td id="mmap_cell" style='height: 50%;'>

                <div id="mmap"
                    style="width: 100%; height: 100%; border: 1px solid black;"></div>
            </td>
            <td id="omap_cell" style='height: 50%;'>
                <div id="omap"
                    style="width: 100%; height: 100%; border: 1px solid black;"></div>
            </td>
        </tr>
    </table>

</body>

<script type="text/javascript"
    src="http://shared.gmapify.fr/javascript/jquery-1.2.6.min.js">
    </script>

<!--YAHOO! MAP API-->
<script type="text/javascript"
    src="http://api.maps.yahoo.com/ajaxymap?v=3.7&appid=BlT9TJXV34GbVZsNRr43nCUtcVa0Jn6NL4jKKbQtHj0T.ztPxw1DjvAVavwNzCE-">
    </script>

<!--GOOGLE MAP API-->
<script type="text/javascript"
    src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAADJbfhH4n1uSXICGVGr5shRTAWSVwt_T5xlaLGDLe4TUb_efhmBSbrcCC-UT9JDE20_8w67pZvwDHig">
    </script>

<!--MICROSOFT MAP API-->
<script
    src="http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.2">
    </script>

<script type="text/javascript"
    src="http://shared.gmapify.fr/javascript/mapstraction-211.pack.js">
    </script>

<script type="text/javascript">
        function map(aProvider, aContainer, aMap){
            this.provider = aProvider;
            this.container = aContainer;
            this.mapstraction = aMap;
        }

        var maps = Array();
        maps.push(new map("yahoo", "ymap", null));
        maps.push(new map("google", "gmap", null));
        maps.push(new map("microsoft", "mmap", null));
        maps.push(new map("openstreetmap", "omap", null));
        var mainProvider = null;

        for (var iLoopMaps = 0; iLoopMaps < maps.length; iLoopMaps++) {
            maps[iLoopMaps].mapstraction = new Mapstraction(maps[iLoopMaps].container, maps[iLoopMaps].provider);
            maps[iLoopMaps].mapstraction.addControls({
                pan: true,
                zoom: 'small',
                map_type: true
            });
            maps[iLoopMaps].mapstraction.setCenterAndZoom(new LatLonPoint(4.59, -7.07), 10);
               if( ("google" == maps[iLoopMaps].mapstraction.api) || ("openstreetmap" == maps[iLoopMaps].mapstraction.api) )
                maps[iLoopMaps].mapstraction.addEventListener('click',fInitSynchronize, maps[iLoopMaps].mapstraction);
        };

        function fFindMapIndex(){
            for (iLoopMaps = 0; iLoopMaps < maps.length; iLoopMaps++)
                if (mainProvider == maps[iLoopMaps].provider)
                    return iLoopMaps;
        };//fFindMap

        function fInitSynchronize(){
            if (mainProvider != this.api) {
                fResetEvent();
                switch (this.api) {
                    /*
                    case 'yahoo':
                        mainProvider = 'yahoo';
                        break;*/
                    case 'google':
                        mainProvider = 'google';
                        break
                    /*
                    case 'microsoft':
                        mainProvider = 'microsoft';
                        break*/
                    case 'openstreetmap':
                        mainProvider = 'openstreetmap';
                        break
                }
                var mapIndex = fFindMapIndex();
                $("#" + maps[mapIndex].container+"_cell").addClass("mainMap");
                maps[mapIndex].mapstraction.addEventListener('moveend',fSynchronize);
            }
        };//fInitSynchronize

        function fResetEvent(){
            if (null != mainProvider) {
                var mapIndex = fFindMapIndex();
                $("#" + maps[mapIndex].container+"_cell").removeClass("mainMap");

                var native_map = maps[mapIndex].mapstraction.getMap();
                switch (mainProvider) {
                    /*
                    case 'yahoo':
                        //TODO
                        break;
                    */
                    case 'google':
                    case 'openstreetmap':
                        GEvent.clearListeners(native_map, "moveend");
                        break;
                    /*
                    case 'microsoft':
                        native_map.DetachEvent("onchangeview", fSynchronize);
                        break;
                    */
                }
            }
        };//fResetEvent

        function fSynchronize(){
            var zoom = null;
            var center = null;
            for (iLoopMaps = 0; iLoopMaps < maps.length; iLoopMaps++)
                if (mainProvider == maps[iLoopMaps].provider) {
                    center = maps[iLoopMaps].mapstraction.getCenter();
                    zoom = maps[iLoopMaps].mapstraction.getZoom();
                    break;
                }
            for (iLoopMaps = 0; iLoopMaps < maps.length; iLoopMaps++)
                if ((mainProvider != maps[iLoopMaps].provider) && (null != maps[iLoopMaps].mapstraction))
                    maps[iLoopMaps].mapstraction.setCenterAndZoom(center, zoom);
        };//fSynchronize

    </script>
</html>
