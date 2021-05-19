<?php
function getLatLonWithAdress($adress)
{
    // url encode the address
    // adds special characters instead of spaces
    $adress = urlencode($adress);

    // using nomination tool to search data by adress (geocoding)
    $url = "http://nominatim.openstreetmap.org/search?email=contact.citinterests@gmail.com&q=$adress&format=json&polygon=1&addressdetails=1";

    // get the json response
    $resp_json = file_get_contents($url);

    // decode the json
    $resp = json_decode($resp_json, true);

    return array($resp[0]['lat'], $resp[0]['lon']); // gets latitude and longitude from the json decode
}

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">

    <style>
        html,
        body {
            height: 100%;
            padding: 0;
            margin: 0;
        }

        #map {
            /* configure the size of the map */
            width: 100%;
            height: 400px;
        }
    </style>
</head>

<body class="bg-gradient-primary" style="background: #81c5c1;">
<div id="map"></div>
    <script>

        // initialize map
        var map = L.map('map', {
            center: [46.2044, 6.1432], // centers on Geneva
            zoom: 10
        });

        // -- Functions --
        // add a marker on a given lat and long with a description
        function addMarker(latitude, longitude, description) {
            L.marker({
                lat: latitude,
                lon: longitude
            }).bindPopup(description).addTo(map);
        }

        // change the map's center view
        function moveMapCenter(latitude, longitude) {
            map.panTo(new L.LatLng(latitude, longitude));
            map.zoomIn(2); // zoom in +5
        }

        // initialize map
        function initializeMap(latitude, longitude) {

            moveMapCenter(latitude, longitude); // refresh map center state to sight's position

            // add the OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
            }).addTo(map);

            // show the scale bar on the lower left corner
            L.control.scale().addTo(map);

            // add a marker on sight's position
            addMarker(latitude, longitude, "Your location");
        }
    </script>
</body>

</html>