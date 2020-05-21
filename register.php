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
				<li><a href="register" id="homeTab" class="active">REGISTER</a></li>
				<li><a href="login" id="chatTab">LOGIN</a></li>
			</ul>
		</div>
	</div><br>
	<div id="errorPlaceholder">
		<?php 
			if(isset($_SESSION['registerError'])) {
				echo "<div id='errorMessage'>" . $_SESSION['registerError'] . "</div><br><br>";
				unset($_SESSION['registerError']);
			}
			else if(isset($_SESSION['registerSuccess'])) {
				echo "<div id='errorMessage'>" . $_SESSION['registerSuccess'] . "</div><br><br>";
				unset($_SESSION['registerSuccess']);
			}
			else {
				echo "<br><br>";
			}
		?>
	</div>
	<div id="registrationPlaceholder"></div><br><br><br><br><br>
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script>
		$(function(){
		  $("#registrationPlaceholder").load("forms/register.html"); 
		});
	</script>
	
	





	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
	
</body>

</html>