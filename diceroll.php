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
				<li><a href="index" id="homeTab">HOME</a></li>
				<li><a href="chat" id="chatTab">CHAT</a></li>
				<li><a href="luckybutton" id="luckyTab">LUCKY BUTTON</a></li>
				<li><a href="diceroll" id="diceTab" class="active">DICE ROLL</a></li>
				<li><a href="slotmachine" id="slotTab">SLOT MACHINE</a>
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>

	<h1>Dice Roll</h1>
	<div id="diceWrapper">
		<div id="diceRollBet">
			<div>Bet amount:</div>
			<input type="radio" id="dice1" name="diceBet" value="1"><label for="dice1">$1 </label><br>
			<input type="radio" id="dice2" name="diceBet" value="5"><label for="dice2">$5 </label><br>
			<input type="radio" id="dice5" name="diceBet" value="10"><label for="dice5">$10 </label><br>
			<input type="radio" id="dice10" name="diceBet" value="25"><label for="dice10">$25 </label><br>
			<input type="radio" id="dice20" name="diceBet" value="100"><label for="dice20">$100</label><br>
			<button id="rollDiceButton" onclick="rollDice()">ROLL DICE!</button>
		</div>
		<div id="showDice"><div id="die">&#x2680;&#x2680;</div></div>
	</div>
	<input type="hidden" id="balance" value="<?php echo $_SESSION['balance']; ?>">
	<h2>Rules:</h2>
	<p id="diceRollRules">
		1. Select amount to bet<br>
		2. Click the dice roll button<br>
		3. If you roll doubles you win 4x the amount betted<br>
		4. Otherwise you lose the amount betted
	</p>
	<br><br><br><br><br>
	
	<!-- Roll dice function -->
	<script src="javascript/dice.js"></script>

	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>
	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
	
</body>

</html>