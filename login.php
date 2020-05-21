<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Final Project</title>
	<meta charset="utf=8">	
	<link href="css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
	<!-- Site Banner -->
	<div id="headerPlaceholder"></div>
	<div id="headerWrapper">
		<div id="banner"></div>
		<div id="accountWrapper">
			<div id="columnLeft">
				<br><br>
				<div id="welcomeDiv">Welcome GUEST!</div>
				<div id="pointsDiv">Please REGISTER or LOGIN</div>
			</div>
			<div id="columnRight">
	
			</div>	
		</div>
	</div>
	
	<!-- Site Navigation -->
	<div id="menu-outer">
		<div class="table">
			<ul id="horizontal-list">
				<li><a href="register" id="homeTab">REGISTER</a></li>
				<li><a href="login" id="chatTab" class="active">LOGIN</a></li>
			</ul>
		</div>
	</div><br>
	<div id="errorPlaceholder">	
		<?php 
			if(isset($_SESSION['loginError'])) {
				echo "<div id='errorMessage'>" . $_SESSION['loginError'] . "</div><br><br>";
				unset($_SESSION['loginError']);
			}
			else {
				echo "<br><br>";
			}
		?>
	</div>
	<div id="loginPlaceholder"></div><br><br><br><br><br>
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script>
		$(function(){
		  $("#loginPlaceholder").load("forms/login.html"); 
		});
		
	</script>
		
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
	
</body>

</html>