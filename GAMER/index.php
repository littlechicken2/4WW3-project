<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GamerFriend</title>
  <link rel="stylesheet" href="project.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Styling for Footer - https://matthewjamestaylor.com/bottom-footer -->
  <style>
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

    <div class="neonbox">
      <h1 class="neonText animate__animated animate__backInDown">GamerFriend</h1>
      <h2 class="neonText animate__animated animate__backInDown animate__delay-1s">The Ultimate Gameshop Finder</h2>
      <p></p>
      <p class="neonText animate__animated animate__backInDown animate__delay-1s">Search for City or Province</p>
      <!-- Gamgle Search Bar -->
      <form role="search" id="form" class="form1 animate__animated animate__zoomInDown animate__delay-3s">
        <input type="search" id="query" name="search" class="input1" placeholder="Gamgle"
        aria-label="Search through site content" />>
      </form>
      <!-- Search Buttons -->
      <button class="button1 btn start animate__animated animate__bounceInLeft animate__delay-2s" type="submit" id="search1" onclick="search()"><span>Search </span></button>
      <button class="button1 btn start animate__animated animate__bounceInRight animate__delay-2s" type="submit" id="search2" onclick="search()"><span>Search nearby</span></button>
      
      <script type="text/javascript">
        function search(){
          input = document.getElementById("query").value;
          searchURL = 'http://18.223.27.232/GAMER/results_sample.php?search=' + input;
          window.location.replace(searchURL);
        }
      </script>
    </div>

    <p></p>

    <!-- Footer -->
    <?php include 'footer.inc'; ?>
  </div>
</body>
</html>
