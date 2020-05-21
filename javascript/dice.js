
var isRolling;
function rollDice() {
	if(document.querySelector('input[name="diceBet"]:checked') != null && !isRolling) {
		isRolling = true;
		var value = document.querySelector('input[name="diceBet"]:checked').value;
		// Check if user has enough points
  		var ajax3 = new XMLHttpRequest();
	    ajax3.open("GET", "controller.php?info=true", true);
	    ajax3.send(); 
	
	    ajax3.onreadystatechange = function () {
		    if (ajax3.readyState == 4 && ajax3.status == 200) {
		    	var array = [];
		  	    array = JSON.parse(ajax3.responseText);
		        var currentBalance = array[0]['balance'];

				// User does not have enough points
		        if(parseInt(currentBalance) < parseInt(value)) {
					document.getElementById("showDice").innerHTML = "<h2 class='winMessage'>NOT ENOUGH BALANCE!!</h2>";
					// Unset radio button
					$('input[name="diceBet"]').attr('checked',false);
					isRolling = false;
		        }
		        // Game starts
		        else {
					var audio = new Audio("sound/diceroll.mp3");
					audio.play();
		        	$('input[name="diceBet"]').attr('checked',false);
			        var die1 = "&#x268" + Math.floor(Math.random() * 6) + ";";
					var die2 = "&#x268" + Math.floor(Math.random() * 6) + ";";
					var count = 0;
					var maxCount =  Math.floor(Math.random() * 4 + 8);
					console.log(maxCount);
			        var myVar = setInterval(function() {
						document.getElementById("showDice").innerHTML = "<div id='die'>" + die1 + die2 + "</div>";
			        	die1 = "&#x268" + Math.floor(Math.random() * 6) + ";";
						die2 = "&#x268" + Math.floor(Math.random() * 6) + ";";
						if(count == maxCount) {
							clearInterval(myVar);
							payout(die1,die2,value);
						}
						count++;
			        }, 200);						
		        }		        
			}
	  	}
	}
	
}
function payout(die1, die2,value) {
	var winLoseMsg = "";
	if(die1 == die2) {
		winLoseMsg = "<div class='winMessage'>YOU WON $" + value * 4 + "!</div>";
		// Add points to user account
		var ajax = new XMLHttpRequest();
	    ajax.open("GET", "controller.php?addBalance=" + value*4, true);
	    ajax.send(); 
  		// Update balance
  		var ajax2 = new XMLHttpRequest();
	    ajax2.open("GET", "controller.php?info=true", true);
	    ajax2.send(); 
	
	    ajax2.onreadystatechange = function () {
		    if (ajax2.readyState == 4 && ajax2.status == 200) {
		    	var array = [];
		  	    array = JSON.parse(ajax2.responseText);
		        // Set balance
		        str = "Balance: <span id='dollarSign'>$</span>" +array[0]['balance'];

		        document.getElementById("pointsDiv").innerHTML = str;
			}
	  	}
	}
	else {
		winLoseMsg = "<div class='winMessage'>YOU LOST $" + value + "!</div>";
		// TODO: subtract points from user account
		var ajax = new XMLHttpRequest();
	    ajax.open("GET", "controller.php?subtractBalance=" + value, true);
	    ajax.send(); 
  		// Update balance
  		var ajax2 = new XMLHttpRequest();
	    ajax2.open("GET", "controller.php?info=true", true);
	    ajax2.send(); 
	
	    ajax2.onreadystatechange = function () {
		    if (ajax2.readyState == 4 && ajax2.status == 200) {
		    	var array = [];
		  	    array = JSON.parse(ajax2.responseText);
		        // Set balance
		        str = "Balance: <span id='dollarSign'>$</span>" +array[0]['balance'];

		        document.getElementById("pointsDiv").innerHTML = str;
			}
	  	}
	}
	document.getElementById("showDice").innerHTML = "<div id='die'>" + die1 + die2 + "</div>" + winLoseMsg;
	// Unset radio button
	isRolling = false;
}