<?php
session_start ();
if (! isset ( $_SESSION ['user'] )) {
	header ( 'Location: register' );
}
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
				<li><a href="luckybutton" id="luckyTab">LUCKY BUTTON</a></li>
				<li><a href="diceroll" id="diceTab">DICE ROLL</a></li>
				<li><a href="slotmachine" id="slotTab">SLOT MACHINE</a>			
				<li><a href="members" id="membersTab" class="active">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div>
	<br>

	<div id="membersDiv"></div>

	<script src="javascript/members.js"></script>

	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>

	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>

</body>

</html>