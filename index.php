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
				<li><a href="index" id="homeTab" class="active">HOME</a></li>
				<li><a href="chat" id="chatTab">CHAT</a></li>
				<li><a href="luckybutton" id="luckyTab">LUCKY BUTTON</a></li>
				<li><a href="diceroll" id="diceTab">DICE ROLL</a></li>
				<li><a href="slotmachine" id="slotTab">SLOT MACHINE</a>
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>

	<div id="leaderboardWrapper">
		<div id="leaderboard"></div>
	</div>
	<div id="siteRules">Welcome to the gambling casino site. <br><br>Each player begins with $1000 and has the ability to gamble their balance through various games.<br><br>
						The first game is the Lucky Button, where players can play for free for a chance to increase, or reset their balance. <br><br>
						The second game is the Dice Roll, where players can gamble an amount of money for a chance to quadruple their balance
						if they roll doubles. <br><br>The last game is the Slot Machine, where players can pay a fee to spin the slot machine for a chance
						to win one of the jackpots.<br><br>
						The chat allows users to interact with each other through our integrated
						live chat system.<br><br>Users are also able to find other members through the members list, where players can
						post on other people's profile page to leave their friends a friendly comment.
	</div><br><br><br><br>
	<script>
		window.onload = function() {
			var ajax = new XMLHttpRequest();
		    ajax.open("GET", "controller.php?leaderboard=true", true);
		    ajax.send(); 
		
		    ajax.onreadystatechange = function () {
			    if (ajax.readyState == 4 && ajax.status == 200) {
			    	var array = [];
			  	    array = JSON.parse(ajax.responseText);
			        var str = "<u>CURRENT LEADERBOARD</u><br>";
			        for(var i = 0; i < array.length; i++) {				        
			        	str += +i+1 + ") " + array[i]['username'] + ": $" + array[i]['balance'] + "<br>";
			        }
			        document.getElementById("leaderboard").innerHTML = str;
				}
		  	}
		}
	</script>


	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>
	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
	
</body>

</html>