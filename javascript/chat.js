//If user submits the form
$("#submitmsg").click(function() {
	// Input must not be empty
	var usermsg = document.getElementById("usermsg").value;
	if (usermsg != "") {
		// Call controller to insert user's message
		$.post("controller.php", {
			text : usermsg
		});

		// Clear input field
		$("#usermsg").attr("value", "");

		// Scroll to bottom of chat when submitted message
		var chatDiv = document.getElementById("chatbox");
		chatDiv.scrollTop = chatDiv.scrollHeight;

		// Update the chat
		loadLog();
	}
	return false;
});

// Load the chat log into the chat box
function loadLog() {
	$.ajax({
		url : "logs/chatlog.txt",
		cache : false,
		success : function(html) {
			document.getElementById("chatbox").innerHTML = html;
		},
	});
}

// Continuously updates the chat
setInterval(loadLog, 250);