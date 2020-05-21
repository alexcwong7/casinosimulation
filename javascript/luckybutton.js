$("#luckyButton").click(function() {
	// Determine which category
	var categoryNum = Math.floor(Math.random() * 100 + 1);
	// 5% chance to reset balance
	if(categoryNum <= 5) {
		$("#buttonOutput").html("<div class='fail'>YOUR BALANCE WAS RESET!</div>");	
		// Call controller to update balance
		$.get("controller.php", {
			resetBalance : "true"
		}); 
		console.log("reset");
	}
	// 60% chance to win money between $1-$10
	else if(categoryNum >= 6 && categoryNum <= 65) {
		var generatedNum = Math.floor(Math.random() * 10 + 1);
		$("#buttonOutput").html("<div class='success'>YOU WON: $"+generatedNum+"</div>");
		// Call controller to update balance
		$.get("controller.php", {
			addBalance : generatedNum
		});
	}
	// 30% chance to win money between $10-$100
	else if(categoryNum >= 66 && categoryNum <= 95) {
		var generatedNum = Math.floor(Math.random() * 90 + 11);
		$("#buttonOutput").html("<div class='success'>YOU WON: $"+generatedNum+"</div>");
		// Call controller to update balance
		$.get("controller.php", {
			addBalance : generatedNum
		});
	}
	// 5% chance to win money between $100-$1000
	else {
		var generatedNum = Math.floor(Math.random() * 900 + 101);
		$("#buttonOutput").html("<div class='success'>YOU WON: $"+generatedNum+"</div>");
		// Call controller to update balance
		$.get("controller.php", {
			addBalance : generatedNum
		});
	}
	
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

});
