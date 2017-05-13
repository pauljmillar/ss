<?php
require_once("MailChimp.php");


if(isset($_POST['email'])) {
     
    // CHANGE THE TWO LINES BELOW
    $email_to = "paul.millar@gmail.com";
     
    $email_subject = "Sneaky Smart Comment";
     
     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(
        !isset($_POST['email']) ||
        !isset($_POST['email'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
    }
     
    $email_from = $_POST['email']; // required
    $comments = $_POST['comments']; // required
    $name = $_POST['name']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  //if(strlen($comments) < 2) {
  //  $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  //}
  if(strlen($error_message) > 0) {
    died($error_message);
  }

if(!isset($_POST['comments'])){
	$email_subject = "Sneaky Smart Signup";

//******************************
//Mail Chimp call
//******************************
$MailChimp = new \drewm\MailChimp('ef17632f27493eedd396c8be4ce03c4e-us3');
$result = $MailChimp->call('lists/subscribe', array(
                'id'                => '7fb212e7c1',
                'email'             => array('email'=>$email_from),
//                'merge_vars'        => array('FNAME'=>'Paul', 'LNAME'=>'Millar'),
                'double_optin'      => true,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => true,
            ));
}

//******************************
//Send paul notification
//******************************


    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
    $email_message .= "Name: ".clean_string($email)."\n";
    $email_message .= "Mail Chimp response: ".clean_string(serialize($result))."\n";

     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();

//echo($email_to);
//echo($email_subject);
//echo($email_message);

@mail($email_to, $email_subject, $email_message, $headers); 
?>
 
<!-- HTML SECTION IS LIKE THE INDEX.HTML SECTION :: JUST CHANGE WHAT YOU NEED TO CHANGE ! -->


<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <!-- Title and meta tag /-->
<META HTTP-EQUIV=Refresh CONTENT="10; URL=http://sneakysmart.co">
    <title>You're on your way to getting sneaky smart.</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <!-- Stylesheets /-->
    <link rel="stylesheet" href="css/gumby.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/libs/modernizr-2.6.2.min.js"></script>
    
</head>


<body>


<!-- CONTAINER EMAIL ############################################### -->


	<!-- TITLE -->
	
	    <div class="row">
	      <div class="twelve columns centered">
	      <br>
	      <br>
	      <?php if(!isset($_POST['comments'])){ ?>
	        <h2>Thanks. You're on your way to getting sneaky smart.</h2>
	        <h4>Please click the link in your confirmation email to receive you first email lesson tomorrow. You'll be directed back to the website after 10 seconds, or click the button to go there now.</h4>
	      <?php } else { ?>
	        <h2>Thanks for your comment.</h2>
	        <h4>We will respond to your comment within 48 hours.  You may also email feedback@sneakysmart.co directly.</h4>
	      <?php } ?>

	      </div> 
	    </div>

	    <div class="row" style="margin-top:35px;">
	    
	    <div class="twelve columns centered">
		      <a class="buttom" href="index.html" >Back to the website</a>
		  </div>
	    
	    </div>



	    


<!-- END CONTAINER EMAIL ############################################### -->


  <!-- Grab Google CDN's jQuery, fall back to local if offline -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.9.1.min.js"><\/script>')</script>


  </body>
</html>


<?php
}
die();
?>