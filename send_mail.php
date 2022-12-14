<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "contact.rahul81@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "contact.htm";
$error_page = "error_message.htm";
$thankyou_page = "contact.htm";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email_name = $_REQUEST['frm_name'] ;
$email_address = $_REQUEST['frm_address'] ;
$email_contact = $_REQUEST['frm_contact'] ;
$email_mail = $_REQUEST['frm_email'] ;
$comments = $_REQUEST['frm_msg'] ;
$all=
"Name: ".$email_name."\r\n".
"\r\n".
"Email: ".$email_address."\r\n".
"\r\n".
"Contact No: ".$email_contact."\r\n".
"\r\n".
"Message: ".$comments."\r\n";
/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email_address'])) {
header( "Location: $feedback_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($email_name) || empty($email_address) || empty($comments)) {
header( "Location: $error_page" );
}

// If email injection is detected, redirect to the error page.
elseif ( isInjected($email_address) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {
mail( "$webmaster_email", "Client's Feedback",
  $all, "From: $email_address" );
header( "Location: $thankyou_page" );
}
?>