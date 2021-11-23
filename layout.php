<?php 


function build_query_string(array $params) {

    $query_string = http_build_query($params);

    //generates URL-encoded for a query string

    return $query_string;
}

function curl_get($url) {

    $client = curl_init($url);

    //Initializes a new CURL and prepares for next step

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    //Set an option for a CURL transfer

    $response = curl_exec($client);

    //it executes the CURL and return a string

    curl_close($client);

    //Closes a CURL session and frees all resources.

    return $response;
}

$url = "http://api.serri.codefactory.live/random/";

$result = curl_get($url);

$jokes = json_decode($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>


    #map {

        height: 80vh;

    }


    html, body {

        margin: auto 0;

        padding: 0;

    }

</style>

</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <p class="text-success"><?php echo $jokes->joke ?></p>
  </div>
</nav>

<h1>English</h1>
<p>The apprentice saves his boss from drowning. Says the boss:
"You have one wish for that! What do you wish for the most?"
The apprentice thinks for a while and finally says:
"Don't tell anyone in the factory that it was me who saved you..."</p>

<h1>German</h1>
<p>Der Lehrling rettet seinen Chef vor dem Ertrinken. Sagt der Chef:
„Dafür hast du einen Wunsch frei! Was wünschst du dir am meisten?“
Überlegt der Lehrling eine Weile und sagt schließlich:
„Erzählen Sie in der Fabrik niemandem, dass ich es war, der Sie gerettet hat…“

</p>

<img class="icon" src="laughing.gif">


<div class="container">

<div class="mb-3" id="map"></div>

<input type="text" class="w-50" id="address" placeholder="Enter address or city name">

<input type="button" class="btn btn-success" value="Add" onclick="getLocation()">

<input type="button" class="btn btn-warning" value="Hide" onclick="hidePins()">

<input type="button" class="btn btn-primary" value="Show" onclick="showPins()">

<input type="button" class="btn btn-danger" value="Delete all" onclick="deletePins()">

</div>

<script>

let geocoder;

let markers = [];


function initMap() {

    geocoder = new google.maps.Geocoder();

    var mlocation = {

        lat: 48.20849,

        lng: 16.37208

    };

    var nlocation = {

        lat: 48.20849,

        lng: 15.37208

    };

    map = new google.maps.Map(document.getElementById('map'), {

        center: mlocation,

        zoom: 8

    });

}


function getLocation() {

    let address = document.getElementById('address').value;

    geocoder.geocode({

        'address': address

        }, function(results, status) {

        if (status == 'OK') {

            map.setCenter(results[0].geometry.location);

            let marker = new google.maps.Marker({

                map: map,

                position: results[0].geometry.location

            });

            markers.push(marker);

            console.log(markers);

        } else {

            console.table(results);

            alert('It was not possible to perform your request due to ' + status);

        }

    })

};

function setMapOnAll(map) {

    for (let i = 0; i < markers.length; i++) {

        markers[i].setMap(map);

    }

}

function clearMarkers() {

    setMapOnAll(null);

}

function hidePins() {

    clearMarkers();

};

function showPins() {

    setMapOnAll(map);

};

function deletePins() {

    hidePins();

    markers = [];

}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtjaD-saUZQ47PbxigOg25cvuO6_SuX3M&callback=initMap" async defer></script>




</body>
</html>