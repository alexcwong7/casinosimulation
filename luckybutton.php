<?php
session_start();
if(!isset($_SESSION['user'])) {
	header('Location: register');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Final Project</title>
	<meta charset="utf=8">	
	<link href="css/styles.css" type="text/css" rel="stylesheet">
	<link href="css/lucky.css" type="text/css" rel="stylesheet">
</head>
<body>
	<!-- Site Banner -->
	<div id="headerPlaceholder"></div>
	<script src="javascript/scrollToTop.js"></script>
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script>
		$(function(){
		  $("#headerPlaceholder").load("header.php"); 
		});
	</script>
	
	<!-- Site Navigation -->
	<div id="menu-outer">
		<div class="table">
			<ul id="horizontal-list">
				<li><a href="index" id="homeTab">HOME</a></li>
				<li><a href="chat" id="chatTab">CHAT</a></li>
				<li><a href="luckybutton" id="luckyTab" class="active">LUCKY BUTTON</a></li>
				<li><a href="diceroll" id="diceTab">DICE ROLL</a></li>
				<li><a href="slotmachine" id="slotTab">SLOT MACHINE</a>
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>
	
	<h1 id="luckyHeader">THE LUCKY BUTTON</h1>	
	<div id="luckyButton">COST: FREE</div><br>
	<div id="buttonOutput"><br></div><br><br>
	<div id="buttonRules">
		Win money from $1-$1000<br>
		DISCLAIMER: You have a 5% chance to reset your balance to 0.
	</div>
	<br><br><br><br>
	<script src="javascript/luckybutton.js"></script>
	
	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>
	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
</body>
</html>