// JavaScript Document
// checkform function is used to check in create user form to check if the inputs aren't blank and that follow simple rules
<!--
function checkform( form ){
	if (form.username.value == "") {
		alert( "Please enter a username." );
		form.username.focus();
		return false;
	}
	else if (!(/^(\w)([\w\s])([\w\s])*([\w])+$/.test(form.username.value))) {
		// At least 3 characters for a username, cannot start or end with a space
		alert( "Please enter a username with at least 3 characters.\r\nOnly use alphanumeric characters, underscore '_' or spaces.\r\nCannot start or end with a space" );
		form.username.focus();
		return false;
	}
	else if (form.password.value == "") {
		alert( "Please write a password." );
		form.password.focus();
		return false;
	}
	else if (!(/^(\w)(.){3}(.)*$/.test(form.password.value))) {
		// At least 4 characters for a password, must start with an alphanumeric character an can contain any kind of character
		alert( "Please enter a longer password, at least 4 characters.\r\nMust start with an alphanumeric character or underscore '_'" );
		form.password.focus();
		return false;
	}
	else if (form.name.value == "") {
		alert( "Please write your name." );
		form.name.focus();
		return false;
	}
	else if (!(/^\w{2}/.test(form.name.value))) {
		// at least 2 characters for a name
		alert( "Please write your name." );
		form.name.focus();
		return false;
	}
	else if (form.email.value == "") {
		alert( "Please write your email." );
		form.email.focus();
		return false;
	}
	else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email.value))) {
		// email validation
		alert( "Please write a valid email.\r\ne.g. name@domain.com" );
		form.email.focus();
		return false;
	}
	return true;
}
-->
