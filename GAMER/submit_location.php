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

  <!-- Validate Form Script -->
  <script>
    function validateForm() {
      let x = document.forms["login"]["uname"].value;  //the html5 types are so much better
      let y = document.forms["login"]["psw"].value;
      if (x == "") {
        alert("Enter Name");
        return false;
      }
      if(y == "") {   //https://www.javatpoint.com/confirm-password-validation-in-javascript
        alert("Enter Password");
        return false;  
      }  
      if(y.length < 8) {  
        alert("Password length must be atleast 8 characters");
        return false;  
      }  
      if(y.length > 15) {  
        alert("Password length must not exceed 15 characters");
        return false;  
      }
    }
  </script>
</head>
<body>

  <img src="10.png" class="bg" alt="bg">
  <div id="container">
    <!-- NavBar Start -->
    <?php include 'navbar.inc'; ?>

    <!-- Header -->
    <div class="width">
      <h1 class = "neonText">NEW LOCATION</h1>
      <hr class="neon">
      <p></p>

      <!-- Location Submission Form -->
      <form class="modal-content animate" method="post">
        <div class="neonbox container">
          <p></p>
          <label id="locationname"><b>Location Name</b></label>
          <input type="text" placeholder="Enter location Name" name="locationname" required>
          <p></p>
          <label id="coordinate"><b>(Latitude,Longtitude)</b></label>
          <input type="number" placeholder="Enter coordinate latitude" name="latitude" required min="-90" max="90" step="0.001">
          <input type="number" placeholder="Enter coordinate longtitude" name="longtitude" required min="-180" max="180" step="0.001">
          <p></p>
          <div id="map"></div>
          <p>Description</p>
          <textarea name="description" style="width:80%; height:160px"></textarea>
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
         .bindPopup("You are <b>Here</b>")
         .openPopup();
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
  </div> <!-- background -->
</body>
</html>