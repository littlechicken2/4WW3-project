<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GamerFriend</title>
  <link rel="stylesheet" href="project.css">
  <!-- Leaflet API -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
  <!-- Animation Library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Initiate Map Size and Styling for Footer - https://matthewjamestaylor.com/bottom-footer -->
  <style>
    #map{
      height: 500px;
      width: 100%;
    }
    html,body {
       height:100%;
    }
    #container {
       min-height:100%;
       position:relative;
    }
    #footer {
       position:absolute;
       bottom:0;
       width:100%;
       height:60px;   /* Height of the footer */
    }
  </style>
</head>
<body>

  <img src="10.png" class="bg" alt="bg">
  <div id="container">
    <!-- NavBar -->
    <?php 
      // Initialize the session
      session_start();
      require_once "config.php";
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        include 'notloggedin.inc';
      }
      else{
        include 'loggedin.inc';
      }
    ?>

    <!-- Header -->
    <div class="width">
      <h1 class = "neonText">NEW LOCATION</h1>
      <hr class="neon">
      <p></p>

      <!-- Location Submission Form -->
      <form class="modal-content animate" method="post">
        <div class="neonbox container">
          <p></p>
          <label id="name"><b>Location Name: </b></label>
          <input type="text" placeholder="Enter Location Name" id="inputname" required>
          <p></p>
          <label id="address"><b>Street Address: </b></label>
          <input type="text" placeholder="Enter Street Address" id="inputaddress" required>
          <p></p>
          <label id="city"><b>City: </b></label>
          <input type="text" placeholder="Enter City" id="inputcity" required>
          <p></p>
          <label id="province"><b>Province: </b></label>
          <input type="text" placeholder="Enter Province" id="inputprovince" required>
          <p></p>
          <label id="postal code"><b>Postal Code: </b></label>
          <input type="text" placeholder="Enter Postal Code" id="inputpostalcode" required>
          <p></p>
          <label id="phone"><b>Phone Number: </b></label>
          <input type="text" placeholder="Enter Phone Number" id="inputphone" required>
          <p></p>
          <label id="coordinate"><b>(Latitude,Longtitude): </b></label>
          <input type="number" placeholder="43.263" id="latitude" required min="-90" max="90" step="0.001">
          <input type="number" placeholder="-79.919" id="longitude" required min="-180" max="180" step="0.001">
          <p></p>
          <button id = "show" onclick="showPosition2()"> Show </button>
          <p></p>
          <div id="map"></div>
          <p></p>
          <button>Upload a picture or video</button>
          <p></p>
          <button type="submit">Submit</button>
        </div>
      </form>
    </div>

    <script>
      // Initialize Map and OpenStreetMap Tile Layer
      var map = L.map('map').setView([43.263,-79.919], 15);
      L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' + '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
      }).addTo(map);

      // prompt for user's location
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }

      // showPosition function called from prompt to display user's location and add a marker
      function showPosition(position) {
        map.panTo([position.coords.latitude, position.coords.longitude], 15);

        L.marker([position.coords.latitude, position.coords.longitude])
         .addTo(map)
         .bindPopup("You are <b>Here </b> at "  + position.coords.latitude + ", " + position.coords.longitude )
         .openPopup();
      }

      // showPosition function called from prompt to display user's location and add a marker
      function showPosition2() {
        inputname = document.getElementById("inputname").value;
        lat = document.getElementById("latitude").value;
        lon = document.getElementById("longitude").value;
        if (inputname == ""){
          name = "";
        }
        else{
          name = inputname + ": ";
        }
        if (lat != "" && lon != ""){
          map.panTo([lat, lon], 15);

          L.marker([lat, lon])
           .addTo(map)
           .bindPopup(name + lat + ", " + lon )
           .openPopup();
        }
        else{
          lat = 43.263;
          lon = -79.919;
          map.panTo([lat, lon], 15);
          L.marker([lat, lon])
           .addTo(map)
           .bindPopup("McMaster University: " + lat + ", " + lon )
           .openPopup();
        }
      }

      // Display a popup when the user clicks on the map
      var popup = L.popup();
      function onMapClick(e) {
        popup.setLatLng(e.latlng)
         .setContent("You clicked the map at " + e.latlng.toString())
         .openOn(map);
      }
      map.on('click', onMapClick);
    </script>

    <p>-</p>

    <!-- Footer -->
    <?php include 'footer.inc'; ?>
  </div>
</body>
</html>
