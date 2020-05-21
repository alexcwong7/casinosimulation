// When the user scrolls down 200px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
	// Show button when not at the top
	if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
		document.getElementById("scrollButton").style.display = "block";
	} 
	// Hide button when close to the top
	else {
		document.getElementById("scrollButton").style.display = "none";
	}
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
	document.body.scrollTop = 0; 
	document.documentElement.scrollTop = 0;
}