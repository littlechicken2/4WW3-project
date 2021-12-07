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
       height:60px;
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

    <!-- Search Bar and Search Buttons-->
    <h1 class = "neonText animate__animated animate__fadeIn" id="input"></h1>
    <button class="button1 btn start" type="submit" onclick="local()"><span>Search</span></button>
    <button class="button1 btn start" type="submit" onclick="getLocation()"><span>Search nearby</span></button>
    <div class="row">

      <script type="text/javascript">
        let url = window.location.href;
        for (let i = 0; i < url.length; i++) {
          if (url.substring(i, i+7) == "search="){
            searchterm = url.substring(i+7);
            break;
          }
        }
        document.getElementById("input").textContent = "Search results for: " + searchterm;
      </script>

      <!-- Sample Results -->
      <div class = "column3a">
        <a href="http://3.130.231.165/GAMER/individual_sample.html">
          <div class = "neonbox card">
            <h2 class="neonText">EB games</h2>
                <?php
                  require_once 'connect.php';
                  $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

                  //$search = $_GET["search"];
                  $stmt = $pdo->prepare('SELECT * FROM `Locations` WHERE `Name` LIKE :search OR `Address` LIKE :search OR `City` LIKE :search OR `Province` LIKE :search');
                  $stmt->bindValue(':search', $_GET['search']);
                  $stmt->execute();
                  foreach($stmt as $row) {
                    echo '<hr class="neon">';
                    echo '<img src="r1.jpg" style="width:50%; height:200px; float:left" alt="shopimage">';
                    echo '<p></p>';
                    echo '<p class="whitetext">' . $row['Name'] . "</p>";
                    echo '<p class="whitetext">' . $row['Address'] . "</p>";
                    echo '<p class="whitetext">' . $row['City'] . ", " . $row['Province'] . "</p>";
                    echo '<p class="whitetext">' . $row['Postal Code'] . "</p>";
                    echo '<p class="whitetext">' . $row['Telephone']  . "</p>";
                    echo '<p></p>';
                  }
                ?>
          </div>
        </a>
      </div>

      <!-- Map of Search Results -->
      <div class = "column3b">
        <div class="neonbox card">
          <h2 class="neonText">MAP</h2>
          <hr class="neon">
          <div id="map"></div>
          <!--<img src="l1.png" class="img" alt="location"> -->
        </div>
      </div>
    </div>

    <script>

      // Initialize Map and OpenStreetMap Tile Layer
      var map = L.map('map').setView([43.263,-79.919], 14);
      L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' + '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
      }).addTo(map);

      var ajax = new XMLHttpRequest();
      ajax.open("GET", "database.php", true);
      ajax.send();
      ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var data = JSON.parse(this.responseText);
          console.log(data);

          var html = "";
          for(var a = 0; a < data.length; a++){
            var name = data[a].Name;
            var address = data[a].Address;
            var city = data[a].City;
            html += "<tr>";
              html += "<td>" + name + "</td>";
              html += "<td>" + address + "</td>";
              html += "<td>" + city + "</td>";
            html += "</tr>";
            
            if (a == 0){
              local(data[a]);
              marker1(data[a]);
            }
            else{
              marker(data[a]);
            }
            
          }
        }
      };

      // local function to pan back to map with search results upon clicking "Search"
      function local(store){
        map.panTo([store.Latitude,store.Longitude], 14);  
      }

      // generates a marker from all the search results and includes its info
      function marker1(store){
        L.marker([store.Latitude, store.Longitude])
         .addTo(map)
         .bindPopup('<b><a href="http://www.ebgames.ca">EB Games</a></b> at ' + store.Name + ', ' + store.Address)
         .openPopup();
      }

      // generates a marker from all the search results and includes its info
      function marker(store){
        L.marker([store.Latitude, store.Longitude])
         .addTo(map)
         .bindPopup('<b><a href="http://www.ebgames.ca">EB Games</a></b> at ' + store.Name + ', ' + store.Address)
      }

      // getLocation Function to prompt for user's location upon clicking "Search Nearby"
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
          x.innerHTML = "Geolocation is not supported by this browser.";
        }
      }

      // showPosition function called from getLocation to display user's location and add a marker
      function showPosition(position) {
        map.panTo([position.coords.latitude, position.coords.longitude], 15);

        L.marker([position.coords.latitude, position.coords.longitude])
         .addTo(map)
         .bindPopup("You are <b>Here</b>")
         .openPopup();
      }

      /*
      // Marker 1 Location
      L.marker([43.258007, -79.942983])
       .addTo(map)
       .bindPopup("<b><a href='http://www.ebgames.ca'>EB Games</a></b> at University Plaza, 101 Osler Dr. Unit 134B")
       .openPopup();

      // Marker 2 Location
      L.marker([43.263344, -79.900986])
       .addTo(map)
       .bindPopup("<b><a href='http://www.ebgames.ca'>EB Games</a></b> at Westdale, 878 King Street West")
       .openPopup();

      function doSubmit(){
        request = new XMLHttpRequest();

        request.onload = function(){
          if (this.status == 200) {
            store = request.responseXML;
            document.getElementById("output").innerHTML = ", " + this.response;
          }            
        };

        request.open("POST", "database.php");
        request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        request.send("num=" + encodeURIComponent(document.getElementById("test").value));
      }
      */
      </script>

    <p>-</p>

    <!-- Footer -->
    <?php include 'footer.inc'; ?>
  </div>
</body>
</html>
