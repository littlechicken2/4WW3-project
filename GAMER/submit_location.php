<?php
            require_once 'config.php';

            // Define variables and initialize with empty values
            $inputname = $inputaddress = $inputcity = $inputprovince = $inputpostalcode = $inputphone = $latitude = $longitude = "";
            $inputname_err = $inputaddress_err = $inputcity_err = $inputprovince_err = $inputpostalcode_err = $inputphone_err = $latitude_err = $longitude_err = "";

            if($_SERVER["REQUEST_METHOD"] == "POST"){
              // Validate name
              if(empty(trim($_POST["inputname"]))){
                $inputname_err = "Please enter a username.";
              } elseif(!preg_match('/^[a-zA-Z0-9.]+$/', trim($_POST["inputname"]))){  //my old form validation is so much worse than this example, i decide to use the better one instead
                $inputname_err = "Username can only contain letters, numbers, and period.";
              } else{
                // Prepare a select statement
                $sql = "SELECT Name FROM Locations WHERE inputname = :inputname";
                
                if($stmt = $pdo->prepare($sql)){                  
                    
                  // Attempt to execute the prepared statement
                  if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                      $inputname_err = "This name is already taken.";
                    } else{
                      $username = trim($_POST["inputname"]);
                    }
                    } else{
                      echo "Oops! Something went wrong. Please try again later.";
                    }
                  // Close statement
                  unset($stmt);
                }
              }

              // Validate address
              if(empty(trim($_POST["inputaddress"]))){
                $inputaddress_err = "Please enter an Address.";     
              } else{
                $inputaddress_err = trim($_POST["inputaddress"]);
              }

              // Validate city
              if(empty(trim($_POST["inputcity"]))){
                $inputcity_err = "Please enter a City.";     
              } else{
                $inputcity_err = trim($_POST["inputcity"]);
              }

              // Validate province
              if(empty(trim($_POST["inputprovince"]))){
                $inputprovince_err = "Please enter a Province.";     
              } else{
                $inputprovince_err = trim($_POST["inputprovince"]);
              }

              // Validate postal code
              if(empty(trim($_POST["inputpostalcode"]))){
                  $inputpostalcode_err = "Please enter a Postal Code.";     
              } else{
                  $inputpostalcode_err = trim($_POST["inputpostalcode"]);
              }

              // Validate phone
              if(empty(trim($_POST["inputphone"]))){
                  $inputphone_err = "Please enter a Phone Number.";     
              } else{
                  $inputphone_err = trim($_POST["inputphone"]);
              }

              // Validate latitude
              if(empty(trim($_POST["latitude"]))){
                  $latitude_err = "Please enter a Latitude.";     
              } else{
                  $latitude_err = trim($_POST["latitude"]);
              }

              // Validate longitude
              if(empty(trim($_POST["longitude"]))){
                  $longitude_err = "Please enter an Longitude.";     
              } else{
                  $longitude_err = trim($_POST["longitude"]);
              }
            }


            // If all are not null, then submit
            if(empty($inputname_err) && empty($inputaddress_err) && empty($inputcity_err) && empty($inputprovince_err) && empty($inputpostalcode_err) && empty($inputphone_err) && empty($latitude_err) && empty($longitude_err)){

              // Prepare an insert statement
              $sql = "INSERT INTO Locations (Name, Address, City, Province, Postal Code, Latitude, Longitude, Phone) VALUES (:inputname, :inputaddress, :inputcity, :inputprovince, :inputpostalcode, :latitude, :longitude, :inputphone)";

              if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":inputname", $param_inputname, PDO::PARAM_STR);
                $stmt->bindParam(":inputaddress", $param_inputaddress, PDO::PARAM_STR);
                $stmt->bindParam(":inputcity", $param_inputcity, PDO::PARAM_STR);
                $stmt->bindParam(":inputprovince", $param_inputprovince, PDO::PARAM_STR);
                $stmt->bindParam(":inputpostalcode", $param_inputpostalcode, PDO::PARAM_STR);
                $stmt->bindParam(":latitude", $param_latitude, PDO::PARAM_STR);
                $stmt->bindParam(":longitude", $param_longitude, PDO::PARAM_STR);
                $stmt->bindParam(":inputphone", $param_inputphone, PDO::PARAM_STR);
                
                // Set parameters
                $param_inputname = $inputname;
                $param_inputaddress = $inputaddress;
                $param_inputcity = $inputcity;
                $param_inputprovince = $inputprovince;
                $param_inputpostalcode = $inputpostalcode;
                $param_latitude = $latitude;
                $param_longitude = $longitude;
                $param_inputphone = $inputphone;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    header("location: submit_location.php");
                } 
                else{
                    echo "Something went wrong.";
                }
              }
            }

            unset($stmt);
            // Close connection
            unset($pdo);
          ?>
          
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
    input[type="text"]::placeholder {
      color: grey;
    }
    input[type="number"]::placeholder {
      color: grey;
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
      <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="neonbox container">
          <p></p>

          <label id="name"><b>Location Name: </b></label>
          <input type="text" placeholder="Limeridge Mall" class="form-control <?php echo (!empty($inputname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputname; ?>" 
          id="inputname" required>
          <span class="invalid-feedback"><?php echo $inputname_err; ?></span>
          <p></p>

          <label id="address"><b>Street Address: </b></label>
          <input type="text" placeholder="999 Upper Wentworth" class="form-control <?php echo (!empty($inputaddress)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputaddress; ?>" 
          id="inputaddress" required>
          <span class="invalid-feedback"><?php echo $inputaddress_err; ?></span>
          <p></p>

          <label id="city"><b>City: </b></label>
          <input type="text" placeholder="Hamilton" class="form-control <?php echo (!empty($inputcity)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputcity; ?>"
          id="inputcity" required>
          <span class="invalid-feedback"><?php echo $inputcity_err; ?></span>
          <p></p>

          <label id="province"><b>Province: </b></label>
          <input type="text" placeholder="Ontario" class="form-control <?php echo (!empty($inputprovince)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputprovince; ?>"
          id="inputprovince" required>
          <span class="invalid-feedback"><?php echo $inputprovince_err; ?></span>
          <p></p>

          <label id="postal code"><b>Postal Code: </b></label>
          <input type="text" placeholder="L9A 4X5" class="form-control <?php echo (!empty($inputpostalcode)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputpostalcode; ?>"
          id="inputpostalcode" required>
          <span class="invalid-feedback"><?php echo $inputpostalcode_err; ?></span>
          <p></p>

          <label id="phone"><b>Phone Number: </b></label>
          <input type="text" placeholder="905-318-6089" class="form-control <?php echo (!empty($inputphone)) ? 'is-invalid' : ''; ?>" value="<?php echo $inputphone; ?>"
          id="inputphone" required>
          <span class="invalid-feedback"><?php echo $inputphone_err; ?></span>
          <p></p>

          <label id="coordinate"><b>(Latitude,Longtitude): </b></label>
          <input type="number" placeholder="43.217627" class="form-control <?php echo (!empty($latitude)) ? 'is-invalid' : ''; ?>" value="<?php echo $latitude; ?>"
          id="latitude" required min="-90" max="90" step="0.001">
          <span class="invalid-feedback"><?php echo $latitude_err; ?></span>
          
          <input type="number" placeholder="-79.863722" class="form-control <?php echo (!empty($longitude)) ? 'is-invalid' : ''; ?>" value="<?php echo $longitude; ?>"
          id="longitude" required min="-180" max="180" step="0.001">
          <span class="invalid-feedback"><?php echo $longitude_err; ?></span>
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
