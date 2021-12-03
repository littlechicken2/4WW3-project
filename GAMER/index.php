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

    <div class="neonbox">
      <h1 class="neonText animate__animated animate__backInDown">GamerFriend</h1>
      <h2 class="neonText animate__animated animate__backInDown animate__delay-1s">The Ultimate Gameshop Finder</h2>
      <!-- Gamgle Search Bar -->
      <form role="search" id="form" class="form1 animate__animated animate__zoomInDown animate__delay-3s">
        <input type="search" id="query" name="q" class="input1"
        placeholder="Gamgle"
        aria-label="Search through site content">
      </form>
      <!-- Search Buttons -->
      <button class="button1 btn start animate__animated animate__bounceInLeft animate__delay-2s" type="submit" onclick="location.href='http://3.130.231.165/GAMER/results_sample.html';"><span>Search</span></button>
      <button class="button1 btn start animate__animated animate__bounceInRight animate__delay-2s" type="submit" onclick="location.href='http://3.130.231.165/GAMER/results_sample.html';"><span>Search nearby</span></button>
    </div>

    <p></p>

    <!-- Footer -->
    <?php include 'footer.inc'; ?>
  </div>
</body>
</html>
