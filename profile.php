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
<body onload="loadinfo('<?php echo $_GET['profile'] ?>')">
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
				<li><a href="members" id="membersTab">MEMBERS LIST</a></li>
			</ul>
		</div>
	</div><br>
	
	<div id="info"></div>
	<br>
	<div id="wall" class="wall">WALL POSTS:<hr><br></div><br><br><br>
	
	
	<script type="text/javascript">
	function loadinfo(username){
		var ajax = new XMLHttpRequest();
		var info = document.getElementById("info");
		
		ajax.open("GET", "controller.php?profile="+username, true);
		ajax.send();

		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				var desc = ajax.responseText;
				info.innerHTML = desc;
			}
		}
		loadwall(username);

	}
	function loadwall(username){
		var ajax = new XMLHttpRequest();
		var wall = document.getElementById("wall");
		
		ajax.open("GET", "controller.php?wall="+username, true);
		ajax.send();

		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				var desc = ajax.responseText;
				wall.innerHTML = desc;
			}
		}
	}
	function addOne(id, username){
		var ajax = new XMLHttpRequest();

		ajax.open("GET", "controller.php?arg=rateUp&id="+id, true);
		ajax.send();
					
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				loadwall(username);
			}
		}
	}
	function subOne(id, username){
		var ajax = new XMLHttpRequest();

		ajax.open("GET", "controller.php?arg=rateDown&id="+id, true);
		ajax.send();
					
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				loadwall(username);
			}
		}
	}
	function flag(id, username){
		var ajax = new XMLHttpRequest();

		ajax.open("GET", "controller.php?arg=flag&id="+id, true);
		ajax.send();
					
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				loadwall(username);
			}
		}
	}
	function newpost(username){
		var ajax = new XMLHttpRequest();
		var text = document.getElementById("thepost").value;
		
		ajax.open("GET", "controller.php?thepost="+text+"&toUser="+username, true);
		ajax.send();
					
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {
				loadwall(username);
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