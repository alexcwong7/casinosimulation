
// Load members
window.onload = function() {
	var ajax = new XMLHttpRequest();
    ajax.open("GET", "controller.php?members=true", true);
    ajax.send(); 

    ajax.onreadystatechange = function () {
	    if (ajax.readyState == 4 && ajax.status == 200) {
	    	var array = [];
	  	    array = JSON.parse(ajax.responseText);
	        var str = "<table id='myTable'><tr id='tableHeaders'><th onclick='sortTable(0)' class='sortArrows'>ID</th>";
	        str +=    "<th onclick='sortTable(1)' class='sortArrows'>Username</th>";
	        str +=    "<th onclick='sortTable(2)' class='sortArrows'>Balance</th>";
	        str +=    "<th onclick='sortTable(3)' class='sortArrows'>Ranking</th></tr>";
	        for(var i = 0; i < array.length; i++) {	
		        str += "<tr><td>" + (+i+1) + "</td>";
		        str += "<td><a href='profile.php?profile=" + array[i]['username'] + "' class='profileLink'>" +array[i]['username']+ "</a></td>";
		        str += "<td><span id='dollarSign'>$</span>" + array[i]['balance'] + "</td>";
		        str += "<td>" + array[i]['rank'] + "</td></tr>"; 			        
	        }
	        str += "</table><br><br><br>";
	        document.getElementById("membersDiv").innerHTML = str;
		}
  	}
}

// Sorts table columns: thanks to w3school's tutorial
function sortTable(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("myTable");
	switching = true;
	dir = "asc";

	while (switching) {
		switching = false;
		rows = table.getElementsByTagName("TR");
		// Table row iteration
		for (i = 1; i < (rows.length - 1); i++) {
			shouldSwitch = false;
			// Comparison elements
			x = rows[i].getElementsByTagName("TD")[n];
			y = rows[i + 1].getElementsByTagName("TD")[n];

			// Determine if string or int comparison
			var xVar, yVar;
			// Convert to int if ID or ranking
			if (n == 0 || n == 3) {
				xVar = parseInt(x.innerHTML);
				yVar = parseInt(y.innerHTML);
			}
			// Remove $ sign and convert to int if balance
			else if (n == 2) {
				xVar = parseInt(x.innerHTML.substring(30));
				yVar = parseInt(y.innerHTML.substring(30));
			}
			// Convert to string if username
			else {
				xVar = x.innerHTML.toLowerCase();
				yVar = y.innerHTML.toLowerCase();
			}
			// Ascending
			if (dir == "asc") {
				if (xVar > yVar) {
					shouldSwitch = true;
					break;
				}
			}
			// Descending
			else if (dir == "desc") {
				if (xVar < yVar) {
					shouldSwitch = true;
					break;
				}
			}
		}
		// Switch
		if (shouldSwitch) {
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			switchcount++;
		}
		// Continue
		else {
			if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			}
		}
	}
}