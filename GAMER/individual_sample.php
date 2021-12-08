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
</head>

<body>
  <img src="10.png" class="bg" alt="bg">
  <div id="container">
    <!-- NavBar Start -->
    <?php 
      // Initialize the session
      session_start();
      require_once "config.php";
      // Shows different NavBar depending on Logged In state
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        include 'notloggedin.inc';
      }
      else{
        include 'loggedin.inc';
      }
    ?>

    <!-- Header -->
    <div class="width">
      <h1 class = "neonText">EBGAMES</h1>
      <hr class="neon">
      <div class="row">
        <p></p>
        <div class="column2">
          <div class = "neonbox card">
        <!-- Location Details -->
          <?php
            require_once 'config.php';
            // Prepares a query where id is the same as the City or Province of a Store
            $stmt = $pdo->prepare('SELECT * FROM `Locations` WHERE `City` LIKE :id OR `Province` LIKE :id');
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->execute();

            // Generates the details of the store
            foreach($stmt as $row) {
              echo '<h2 class="neonText">' . $row['Name'] . '</h2>';
              echo '<hr class="neon">';
              echo '<p class="whitetext">' . $row['Address'] . "</p>";
              echo '<p class="whitetext">' . $row['City'] . ", " . $row['Province'] . ", " . $row['Postal_Code'] . "</p>";
              echo '<p class="whitetext">' . $row['Telephone']  . "</p>";
              echo '<p></p>';
              echo '<img src="r1.jpg" style="width:100%;" alt="shopimage">';
            }
            // Close stmt and connection
            unset($stmt);
            unset($pdo);
          ?>
        
          </div>
        </div>

        <div class="column2">
          <!-- Location on Map -->
          <div class = "neonbox card">
            <h2 class="neonText">LOCATION ON MAP</h2>
            <hr class="neon">
            <!-- <div> that our map will be loaded into -->
            <div id="map"></div>
          </div>
          <!-- Additional Details -->
          <div class = "neonbox card">
            <p class="neonText">Additional Information</p>
            <hr class="neon">
            <iframe width="420" height="315"
            src="https://www.youtube.com/embed/GbahxwcI11Y?autoplay=1&mute=1">
            </iframe>
          </div>
        </div>
      </div>
      <p></p>

      <script>
      // Initialize Map and OpenStreetMap Tile Layer
      var map = L.map('map').setView([43.258007,-79.942983], 15);
      L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' + '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
      }).addTo(map);

      // Gets data from database and converts it into AJAX to create a .json file
      // Only way I found to grab database information and use it in javascript to alter map information
      // Source used - https://adnan-tech.com/get-data-from-database-using-ajax-javascript-php-mysql/
      var ajax = new XMLHttpRequest();
      ajax.open("GET", "database.php", true);
      ajax.send();
      ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Gets response text and parses it into a .json format to get the entries
          console.log(this.responseText);
          var data = JSON.parse(this.responseText);
          console.log(data); 

          var html = "";
          for(var a = 0; a < data.length; a++){
              marker1(data[a]);
          }
        }
      };

      // generates a marker for the store and includes its info
      function marker1(store){
        map.panTo([store.Latitude,store.Longitude], 14);
        L.marker([store.Latitude, store.Longitude])
         .addTo(map)
         .bindPopup('<b><a href="http://www.ebgames.ca">EB Games</a></b> at ' + store.Name + ', ' + store.Address)
         .openPopup();
      }

      </script>

      <!-- Comments Area -->
      <div class="comment_area">
        <div class="neonbox">
          <p class="neonText" style="text-align:left;margin-left:30px">Sample user - Sample title</p>
          <div class="width" style="margin:10px"><hr class="neon"></div>
          <div class="fixrating">
            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
          </div>
          <p class="comment_text">yo this shop is da best!</p>
          <p class="timestamp" style="text-align:right">timestamp</p>
        </div>
        <p></p>
        <div class="neonbox">
          <p class="neonText" style="text-align:left;margin-left:30px">Me - Interesting</p>
          <div class="width" style="margin:10px"><hr class="neon"></div>
          <div class="fixrating">
            <span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>
          </div>
          <p class="comment_text">first time to know EBgames belong to Gamestop</p>
          <p class="timestamp" style="text-align:right">timestamp</p>
        </div>

        <form action="/html/tags/html_form_tag_action.cfm" method="post"> <!--https://www.quackit.com/html/codes/comment_box_code.cfm-->
          <h2 class="neonText">Comments Here!</h2>
          <div class="rating">
            <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
          </div>
          <div>
            <textarea name="comments" id="comments" style="width:96%;height:90px;padding:2%;font-size:1.2em;font-family:BB;">
            </textarea>
          </div>
          <input type="submit" class="button2" value="Submit">
        </form>
      </div>
    </div>

    <p>-</p>

    <!-- Footer -->
    <?php include 'footer.inc'; ?>
  </div>
</body>
</html>
