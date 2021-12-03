<!-- NavBar Start -->

<ul>
	<li><a href="http://3.130.231.165/GAMER/index.html">Home</a></li>
	<li class="lii"><header class="neonText animate__animated animate__fadeIn animate__delay-2s"> GamerFriend - The Ultimate Gameshop Finder</header></li>
	<li class="ri"><button class="button2 animate__animated animate__fadeIn animate__delay-2s" onclick="document.getElementById('id01').style.display='block'">Login</button></li>
	<li class="ri"><button class="button2 animate__animated animate__fadeIn animate__delay-2s" onclick="location.href='http://3.130.231.165/GAMER/submit_location.html'">Submit Location</button></li>
</ul>

<!-- Login Popup -->

<div id="id01" class="modal"> 
  <form class="modal-content animate"  method="post" name="login" onsubmit ="return validateForm()"> <!--action="/action_page.php"-->
    <div class="container">
      <label id="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname">
      <label id="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw">
      <button type="submit">Login/register</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>
    
    <div class="text" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw"> <a href="#">Forgot password?</a></span>
    </div>
  </form>
</div>

<!-- Script to Exit Login Popup -->

<script>
// Get the login_tab
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  else if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
</script>

<p></p> <!-- add this for add spacing -->