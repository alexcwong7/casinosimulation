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
	<link href="css/slots.css" type="text/css" rel="stylesheet">
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
				<li><a href="slotmachine" id="slotTab" class="active">SLOT MACHINE</a>
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>
	
	<h1 id="slotHeader">SLOT MACHINE</h1><br>
	<div class="row">
		<div id="slot1">
			<ul class="list">
				<li data-roll="1"></li>
				<li data-roll="2"></li>
				<li data-roll="3"></li>
				<li data-roll="4"></li>
				<li data-roll="5"></li>
				<li data-roll="6"></li>					
			</ul>
		</div>

		<div id="slot2">
			<ul class="list">
				<li data-roll="1"></li>
				<li data-roll="2"></li>
				<li data-roll="3"></li>
				<li data-roll="4"></li>
				<li data-roll="5"></li>
				<li data-roll="6"></li>			
			</ul>
		</div>
		
		<div id="slot3">
			<ul class="list">
				<li data-roll="1"></li>
				<li data-roll="2"></li>
				<li data-roll="3"></li>
				<li data-roll="4"></li>
				<li data-roll="5"></li>
				<li data-roll="6"></li>					
			</ul>
		</div>
	</div><br>
	<div class="row2">
		<button id="spin">SPIN: $50</button><br>
		<br><div id="payoutMessage"><br></div>
		<img src="images/slotmachinepayout.png" id="payoutTable">
	</div>
	<input type="hidden" id="balance" value="<?php echo $_SESSION['balance']; ?>">
	<br><br><br><br><br><br><br><br>
	<script src="javascript/slotmachine.js"></script>
	
	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>
	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
</body>
</html>