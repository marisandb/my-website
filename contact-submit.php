<?php
// set up error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// YOU SHOULD SET THESE TWO VARIABLES...
$admin_email = "";//MAKE SURE TO PUT YOUR EMAIL ADDRESS HERE!!!
$email_subject = "Your Website - Contact Form Submitted";

if(empty($admin_email)){
  die("You did not set the 'admin email' so I don't know who to send the email to!!!");
}

// variable for working with the form data
$first_name = "";
$last_name ="";
$email = "";
$comments = "";
$error_messages = array();
$confirmation_message = "";

// check to see if the form has been 'posted'
if($_SERVER['REQUEST_METHOD'] == "POST"){
  
  // get the values entered into the form
	$email = $_POST['email'] ?? null;
  $first_name = $_POST['firstName'] ?? null;
	$last_name = $_POST['lastName'] ?? null;
	$comments = $_POST['comments'] ?? null;

	// validate input
	if(empty($first_name)){
    	$error_messages['first_name'] = "firstName is required";
  }

  if(empty($last_name)){
      $error_messages['last_name'] = "lastName is required";
  }

	if(empty($comments)){
  	$error_messages['comments'] = "comments are required";
	}

	if(empty($email)){
  	$error_messages['email'] = "email is required";
	}elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
		$error_messages['email'] = "The email address entered is not valid";
	}



  // check for urls planted in the form
  if(url_exists_in_text($email) || url_exists_in_text($first_name) || url_exists_in_text($last_name) || url_exists_in_text($comments)){
    $error_messages['urls'] = "You cannot include URLs in any of the fields on the contact form.";
  }

  // check for other signs of spam
  $email = spam_scrubber($email);
  $first_name = spam_scrubber($first_name);
  $last_name = spam_scrubber($last_name);
  $comments = spam_scrubber($comments);

  if(empty($email) || empty($first_name) || empty($last_name) || empty($comments)){
    $error_messages['spam'] = "The data entered contains problematic characters";
  }



  // If there were or validation errors, then send the info
  // Otherwise show the validation errors
	if(empty($error_messages)){
    // send the email
		if(send_email($admin_email, $email_subject, $first_name, $last_name, $email, $comments)){
			$confirmation_message = "<h3>Thank you for contacting me. I will get back to you as soon as I can</h3>";
		}else{
			$confirmation_message = "<h3 class=\"validation\">There was an error submitting your information.</h3>";
    }
	}else{
    // There are input validation errors, so show them
    $confirmation_message = "<h3 class=\"validation\">There were input validation errors.</h3>";
    foreach($error_messages as $key => $value){
     $confirmation_message .= '<br><span class="validation">' . $value . '</span>';
    }
  }

}

function send_email($to, $subject, $first_name, $last_name, $from_email, $comments){

$body = <<<EOD
  <html>
  <head><title> CONTACT FORM</title></head>
  <body>  
  <b>Name:</b> {$first_name} {$last_name}<br>
  <b>Email:</b> {$from_email}<br>
  <b>Comment:</b> {$comments}
EOD;

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'To: Website Admin <'. $to .'>' . "\r\n";
  $headers .= 'From: '. $first_name . ' ' . $last_name .' <' .  $from_email . '>' . "\r\n";
  
	return mail($to, $subject, $body, $headers);

}


//I got this function from the Larry Ulman book: PHP and MySQL for Dynamic Websites
function spam_scrubber($value){

  // values that need to be remove...
  $very_bad = ["to:", "cc:", "bcc:", "content-type:", "mime-version:", "multipart-mixed:", "content-transfer-encoding:"];

  // if we find any very bad things in the $value, we'll just return an empty string
  foreach ($very_bad as $v) {
    if(strpos($value, $v) !== false){
      return "";
    }
  }

  // replace any new line characters with spaces:
  $value = str_replace(array("\r", "\n", "%0a", "%0d"), " ", $value);

  return trim($value);
}


function url_exists_in_text($text){

  // The Regular Expression filter
  //$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
  $reg_exUrl = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
  return preg_match($reg_exUrl, $text, $url);

}
?>
<!--

TODO: Replace the HTML below with your 'template' code here (update the title and meta/description tags).
Then paste this line of code inside your 'main' tag (it will display a 'thank you' message, or an error if there were problems):

  <?php echo($confirmation_message); ?>

-->
<!DOCTYPE html>
<html>
<head>

</head>
<body>
  <?php echo($confirmation_message); ?>  
</body>
</html>