<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Site Header</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link href="css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
	<!-- Site banner -->
	<div id="headerWrapper">
		<div id="banner"></div>
		<div id="accountWrapper">
			<div id="columnLeft">
				<div id="welcomeDiv">WELCOME!</div>
				<div id="wallDiv"><?php if(isset($_SESSION['user'])) { echo $_SESSION['user']; }?></div>
				<button id="viewWallButton" onclick="goToProfile()">VIEW YOUR WALL</button>	
			</div>
			<div id="columnRight">
				<div id="pointsDiv"></div>
				<div id="rankingDiv"></div>
				<form id='logout' action='controller.php' method='POST'>
					<input type='submit' id="logoutButton" name='logout' value='LOGOUT'>
				</form>
			</div>	
		</div>
	</div>
	<script>
		var ajax = new XMLHttpRequest();
	    ajax.open("GET", "controller.php?info=true", true);
	    ajax.send(); 
	
	    ajax.onreadystatechange = function () {
		    if (ajax.readyState == 4 && ajax.status == 200) {
		    	var array = [];
		  	    array = JSON.parse(ajax.responseText);
		  	  
		        // Set balance and ranking
		        var points = "Balance: <span id='dollarSign'>$</span>" +array[0]['balance'];
		        var ranking = "Ranking: #" + array[0]['rank'];
		        document.getElementById("pointsDiv").innerHTML = points;
		        document.getElementById("rankingDiv").innerHTML = ranking;
			}
	  	}
	</script>
	<script>
		function goToProfile() {
			var url = "<?php echo $_SESSION['user']; ?>";
			location.href = "profile.php?profile="+url;
		}
	</script>
</body>
</html>