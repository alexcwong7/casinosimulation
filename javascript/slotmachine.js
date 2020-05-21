var count = 0;

function slotRoller(slotNum) {
	var firstChild = $(".list li:first-child");

	// Slot machine individual slot animations
	$(slotNum).animate({ marginTop: "500px" }, 200, 
		function() {
			firstChild = $("li:first-child", this);
			$(this).append(firstChild);
			$(this).css({ marginTop: "-250px"});
			
			// Values of landed slot elements
			var slotVal1 = $('li:nth-child(2)', '#slot1').attr('data-roll');
			var slotVal2 = $('li:nth-child(2)', '#slot2').attr('data-roll');
			var slotVal3 = $('li:nth-child(2)', '#slot3').attr('data-roll');
			
			count--;
			// All slots ended, return payout, if any
			if(count == 0) {
				payout(slotVal1,slotVal2,slotVal3);
			}
			
		});
}

// Check if slots had matches
// Values: 1 = HTML, 2 = CSS, 3 = JavaScript, 4 = PHP, 5 = SQL, 6 = Mercer
var interval
function payout(slotVal1, slotVal2, slotVal3) {
	var winnings = 0;
	// 3 Mercers = $5000
	if(slotVal1 == 6 && slotVal2 == 6 && slotVal3 == 6) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON THE JACKPOT OF $5000!";
		winnings = 5000;
	    interval = setInterval(function(){
			    $('#slot1').toggleClass('active');
			    $('#slot2').toggleClass('active');
			    $('#slot3').toggleClass('active');
			  }, 250);
	} 
	// 3 SQL = $1000
	else if(slotVal1 == 5 && slotVal2 == 5 && slotVal3 == 5) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $1000!";
		winnings = 1000;
	    interval = setInterval(function(){
		    $('#slot1').toggleClass('active');
		    $('#slot2').toggleClass('active');
		    $('#slot3').toggleClass('active');
		  }, 250);
	}
	// 3 PHP = $1000
	else if(slotVal1 == 4 && slotVal2 == 4 && slotVal3 == 4) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $1000!";
		winnings = 1000;
	    interval = setInterval(function(){
		    $('#slot1').toggleClass('active');
		    $('#slot2').toggleClass('active');
		    $('#slot3').toggleClass('active');
		  }, 250);
	}
	// 2 Mercers = $750
	else if((slotVal1 == 6 && slotVal2 == 6) || (slotVal1 == 6 && slotVal3 == 6) || (slotVal2 == 6 && slotVal3 == 6)) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $750!";
		winnings = 750;
	    interval = setInterval(function(){
			    if(slotVal1 == 6) $('#slot1').toggleClass('active');
			    if(slotVal2 == 6) $('#slot2').toggleClass('active');
			    if(slotVal3 == 6) $('#slot3').toggleClass('active');
			  }, 250);
	}
	// 3 JavaScript = $500
	else if(slotVal1 == 3 && slotVal2 == 3 && slotVal3 == 3) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $500!";
		winnings = 500;
	    interval = setInterval(function(){
		    $('#slot1').toggleClass('active');
		    $('#slot2').toggleClass('active');
		    $('#slot3').toggleClass('active');
		  }, 250);
	}
	// 3 CSS = $250
	else if(slotVal1 == 2 && slotVal2 == 2 && slotVal3 == 2) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $250!";
		winnings = 250;
	    interval = setInterval(function(){
		    $('#slot1').toggleClass('active');
		    $('#slot2').toggleClass('active');
		    $('#slot3').toggleClass('active');
		  }, 250);
	}
	// 3 HTML = $100
	else if(slotVal1 == 1 && slotVal2 == 1 && slotVal3 == 1) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $100!";
		winnings = 100;
	    interval = setInterval(function(){
		    $('#slot1').toggleClass('active');
		    $('#slot2').toggleClass('active');
		    $('#slot3').toggleClass('active');
		  }, 250);
	}
	// 1 Mercer = $50
	else if(slotVal1 == 6 || slotVal2 == 6 || slotVal3 == 6) {
		document.getElementById("payoutMessage").innerHTML = "YOU WON $50!";
		winnings = 50;
		interval = setInterval(function(){
		    if(slotVal1 == 6) $('#slot1').toggleClass('active');
		    if(slotVal2 == 6) $('#slot2').toggleClass('active');
		    if(slotVal3 == 6) $('#slot3').toggleClass('active');
		  }, 250);

	}
	// Not a winner
	else {
		document.getElementById("payoutMessage").innerHTML = "NOT A WINNER.";

	}

	var ajax = new XMLHttpRequest();
    ajax.open("GET", "controller.php?addBalance=" + winnings, true);
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

// Number of times to spin
function slot(slotNum) {
	this.spin = function(){
		var rand = Math.round(Math.random() * 10 + 10);
		for (var i = 0; i < rand; i++) {
			slotRoller(slotNum);
			count++;
		}
	}		
}

// Variables for each slot
var slot1 = new slot('#slot1 .list');
var slot2 = new slot('#slot2 .list');
var slot3 = new slot('#slot3 .list');

// Play game when button clicked
$('#spin').on( "click", function() {
	clearInterval(interval);
	$('#slot1').removeClass('active');
	$('#slot2').removeClass('active');
	$('#slot3').removeClass('active');

	document.getElementById("payoutMessage").innerHTML = "<br>";
	var ajax3 = new XMLHttpRequest();
    ajax3.open("GET", "controller.php?info=true", true);
    ajax3.send(); 

    ajax3.onreadystatechange = function () {
	    if (ajax3.readyState == 4 && ajax3.status == 200) {
			// Check if user has enough money
			var array = [];
			array = JSON.parse(ajax3.responseText);
			var currentBalance = array[0]['balance'];
			if(parseInt(currentBalance) < 50) {
				document.getElementById("payoutMessage").innerHTML = "<h2 class='winMessage'>NOT ENOUGH BALANCE!!</h2>";
			}
			else {
				// Spin only when all slots are not spinning
				if($('#slot1 .list').is(':not(:animated)') && $('#slot2 .list').is(':not(:animated)') && $('#slot3 .list').is(':not(:animated)')){
					// Pay game fee
					var ajax = new XMLHttpRequest();
				    ajax.open("GET", "controller.php?subtractBalance=50", true);
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
					
					// Play slot machine sound effect
					var audio = new Audio("sound/slotmachine.mp3");
					audio.play();

					// Randomly spin each slot
					slot1.spin();
					slot2.spin();
					slot3.spin();
				}
			}
	    }
    }
});