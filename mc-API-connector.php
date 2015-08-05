<?php

$action = $_POST["action"];
$email = $_POST["email"];
$fname = $_POST["fname"];
$interest = $_POST["interest"];
$debug = isset($_POST["debug"])?$_POST["debug"]:0;
$apikey = YOUR API KEY GOES HERE;
$listid = YOUR LIST ID GOES HERE; This is not the one in the URL, see http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id
$server = MAILCHIMP SERVER PREFIX; Example: us1, us3 etc. Log into mailchimp and look at the URL

if ($debug) {
	echo "*Robot voice* : Bleep bleep. Debugging is on master. <br><br>";
} elseif (!$debug) {
	echo "*Robot voice* : Blip blip, Debugging is off master. <br> <br>";
}

if (!isset($email)) {
	echo "*Robot voice*: No email master, I don't know what to do now. <br><br>";
}

switch($action) {
	case "subscribe":
	echo "*Robot voice* : Starting subscribe <br><br>";
	mc_subscribe($email, $fname, $debug, $apikey, $listid);
	echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	break;
	case "addinterest":
	echo "*Robot voice* : Starting interest add <br><br>";
	mc_addinterest($email, $interest, $debug, $apikey, $listid);
	echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	break;
	case "reminterest":
	echo "*Robot voice* : Starting interest removal <br><br>";
	mc_reminterest($email, $interest, $debug, $apikey, $listid);
	echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	break;
	case "changename":
	mc_changename($fname, $email, $debug, $apikey, $listid);
	echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	break;
	default:
	echo "*JRobot voice* : Your action is not valid master.<br><br>";
	break;
}

function mc_subscribe($email, $fname, $debug, $apikey, $listid) {
	$auth = base64_encode( 'user:'.$apikey );
	$data = array(
		'apikey'        => $apikey,
		'email_address' => $email,
		'status'        => 'subscribed',
		'merge_fields'  => array(
			'FNAME' => $fname
			)
		);
	$json_data = json_encode($data);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic '.$auth));
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($ch);

	if ($debug) {
		var_dump($result);
	}

	die('<br><br>*Creepy etheral voice* : Mailchimp executed subscribe');
};

function mc_changename($fname, $email, $debug, $apikey, $listid) {
	$userid = md5($email);
	$auth = base64_encode( 'user:'. $apikey );
	$data = array(
		'apikey'        => $apikey,
		'email_address' => $email,
		'merge_fields'  => array(
			'FNAME' => $fname
			)
		);
	$json_data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/' . $userid);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic '. $auth));
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($ch);

	if ($debug) {
		var_dump($result);
	}

	die('<br><br>*Creepy etheral voice* : Mailchimp executed interest add.');
}


function mc_addinterest($email, $interest, $debug, $apikey, $listid) {
	$userid = md5($email);
	$auth = base64_encode( 'user:'. $apikey );
	$data = array(
		'apikey'        => $apikey,
		'email_address' => $email,
		'interests' => array(
			$interest => true
			)
		);
	$json_data = json_encode($data);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/' . $userid);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic '. $auth));
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($ch);

	if ($debug) {
		var_dump($result);
	}

	die('<br><br>*Creepy etheral voice* : Mailchimp executed interest add.');
}

function mc_reminterest($email, $interest, $debug, $apikey, $listid) {
	$userid = md5($email);
	$auth = base64_encode( 'user:'. $apikey );

	$data = array(
		'apikey'        => $apikey,
		'email_address' => $email,
		'interests' => array(
			$interest => false
			)
		);
	$json_data = json_encode($data);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/' . $userid);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic '. $auth));
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($ch);

	if ($debug) {
		var_dump($result);
	}

	die('<br><br>*Creepy etheral voice* : Mailchimp executed interest removal');
}

?>