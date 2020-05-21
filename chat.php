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
	<link href="css/chat.css" type="text/css" rel="stylesheet">
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
				<li><a href="chat" id="chatTab" class="active">CHAT</a></li>
				<li><a href="luckybutton" id="luckyTab">LUCKY BUTTON</a></li>
				<li><a href="diceroll" id="diceTab">DICE ROLL</a></li>
				<li><a href="slotmachine" id="slotTab">SLOT MACHINE</a>
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>
	
	<div id="wrapper">
		<div id="menu">
			<p class="welcome">
				Welcome to the chat, <b class='myUser'><?php echo $_SESSION['user']; ?></b>
			</p>

			<div style="clear: both"></div>
		</div>
		<div id="chatbox">
		<?php
			// The chat
			if(file_exists("logs/chatlog.txt") && filesize("logs/chatlog.txt") > 0) {
				$handle = fopen("logs/chatlog.txt", "r");
				$contents = fread($handle, filesize("logs/chatlog.txt"));
				fclose($handle);
				
				echo $contents;
			}
		?>
		</div>


		<form name="message">
			<input type="text" name="usermsg" id="usermsg" maxlength="50" autocomplete="off"> 
			<input type="submit" name="submitmsg" id="submitmsg" value="Send">
		</form>
	</div><br><br><br>

	<script	src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script src="javascript/chat.js"></script>
	
	<!-- Scroll to top button -->
	<button onclick="topFunction()" id="scrollButton" title="Go to top">Top</button>
	
	<!-- Footer -->
	<div id="footer">© 2017 by Alex Wong and Kyle Van</div>
	
</body>

</html>