<!-- NavBar -->
<!-- Shows Home, Submit Location, Register and Login when Logged In-->

<ul>
	<li><a href="http://localhost/GAMER/index.php">Home</a></li>
	<li class="ri"><button class="button2 animate__animated animate__fadeIn animate__delay-2s" onclick="location.href='http://18.223.27.232/GAMER/logout.php'"><?php echo htmlspecialchars($_SESSION["username"]); ?></button></li>
	<li class="ri"><button class="button2 animate__animated animate__fadeIn animate__delay-2s" onclick="location.href='http://18.223.27.232/GAMER/logout.php'">Logout</button></li>
	<li class="ri"><button class="button2 animate__animated animate__fadeIn animate__delay-2s" onclick="location.href='http://18.223.27.232/GAMER/submit_location.php'">Submit Location</button></li>
</ul>

<p></p>