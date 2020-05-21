//Problem: Hints are shown even when form is valid
//Solution: Hide and show them at appropriate times
var $username = $("#usernameReg");
var $password = $("#passwordReg");
var $confirmPassword = $("#confirm_passwordReg");

var $firstname = $("#firstname");
var $lastname = $("#lastname");

// Hide hints
$("form span").hide();

function isUsernameValid() {

	return $username.val().length >= 4 && /^\w+$/.test($username.val());;
}

function isFirstNameValid() {
	return $firstname.val().length >= 1;
}

function isLastNameValid() {
	return $lastname.val().length >= 1;
}


function isPasswordValid() {
	return $password.val().length >= 6;
}

function arePasswordsMatching() {
	return $password.val() === $confirmPassword.val();
}

function canSubmit() {
	return isUsernameValid() && isPasswordValid() && arePasswordsMatching() 
			&& isFirstNameValid() && isLastNameValid();
}

function usernameEvent() {
	if (isUsernameValid()) {
		$username.next().hide();
	} else {
		$username.next().show();
	}
}

function firstnameEvent() {
	if (isFirstNameValid()) {
		$firstname.next().hide();
	} else {
		$firstname.next().show();
	}
}

function lastnameEvent() {
	if (isLastNameValid()) {
		$lastname.next().hide();
	} else {
		$lastname.next().show();
	}
}


function passwordEvent() {
	// Find out if password is valid
	if (isPasswordValid()) {
		// Hide hint if valid
		$password.next().hide();
	} else {
		// else show hint
		$password.next().show();
	}
}

function confirmPasswordEvent() {
	// Find out if password and confirmation match
	if (arePasswordsMatching()) {
		// Hide hint if match
		$confirmPassword.next().hide();
	} else {
		// else show hint
		$confirmPassword.next().show();
	}
}

function enableSubmitEvent() {
	$("#submitReg").prop("disabled", !canSubmit());
}

// When event happens on username input
$username.focus(usernameEvent).keyup(usernameEvent).keyup(enableSubmitEvent);

// When event happens on password input
$password.focus(passwordEvent).keyup(passwordEvent).keyup(confirmPasswordEvent)
		.keyup(enableSubmitEvent);

// When event happens on confirmation input
$confirmPassword.focus(confirmPasswordEvent).keyup(confirmPasswordEvent).keyup(
		enableSubmitEvent);

//When event happens on confirmation input
$firstname.focus(firstnameEvent).keyup(firstnameEvent).keyup(
		enableSubmitEvent);

//When event happens on confirmation input
$lastname.focus(lastnameEvent).keyup(lastnameEvent).keyup(
		enableSubmitEvent);


enableSubmitEvent();