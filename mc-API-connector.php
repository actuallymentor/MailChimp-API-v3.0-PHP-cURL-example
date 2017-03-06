<?php

$action = $_POST["action"];
$email = $_POST["email"];
$fname = $_POST["fname"];
$interest = $_POST["interest"];
$debug = isset($_POST["debug"])?$_POST["debug"]:0;
$apikey = YOURAPIKEY;
$listid = $_POST["listid"];
$server = YOURSERVER WITH A . AFTER IT;

if ($debug) {
	echo "*Robot voice* : Bleep bleep. Debugging is on master. <br><br>";
}

if (!isset($email)) {
	echo "*Robot voice*: No email master, I don't know what to do now. <br><br>";
}

switch($action) {
	case "subscribe":
	if ($debug) {
		echo "*Robot voice* : Starting subscribe <br><br>";
	}
	mc_subscribe($email, $fname, $debug, $apikey, $listid, $server);
	if ($debug) {
		echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	}
	break;
	case "addinterest":
	if ($debug) {
		echo "*Robot voice* : Starting interest add <br><br>";
	}
	mc_addinterest($email, $interest, $debug, $apikey, $listid, $server);
	if ($debug) {
		echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	}
	break;
	case "reminterest":
	if ($debug) {
		echo "*Robot voice* : Starting interest removal <br><br>";
	}
	mc_reminterest($email, $interest, $debug, $apikey, $listid, $server);
	if ($debug) {
		echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	}
	break;
	case "changename":
	mc_changename($fname, $email, $debug, $apikey, $listid, $server);
	if ($debug) {
		echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	}
	break;
	case "checklist":
	mc_checklist($email, $debug, $apikey, $listid, $server);
	if ($debug) {
		echo "*Robot voice* : Function didn't complete for some reason.<br><br>";
	}
	break;
	default:
	echo "*JRobot voice* : Your action is not valid master.<br><br>";
	break;
}

function mc_subscribe($email, $fname, $debug, $apikey, $listid, $server) {
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
		die('<br><br>*Creepy etheral voice* : Mailchimp executed subscribe');
	}

	die();
};

function mc_changename($fname, $email, $debug, $apikey, $listid, $server) {
	$userid = md5( strtolower( $email ) );
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
		die('<br><br>*Creepy etheral voice* : Mailchimp executed interest add.');
	}

	die();
}


function mc_addinterest($email, $interest, $debug, $apikey, $listid, $server) {
	$userid = md5( strtolower( $email ) );
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
		die('<br><br>*Creepy etheral voice* : Mailchimp executed interest add.');
	}

	die();
}

function mc_reminterest($email, $interest, $debug, $apikey, $listid, $server) {
	$userid = md5( strtolower( $email ) );
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
		die('<br><br>*Creepy etheral voice* : Mailchimp executed interest removal');
	}

	die();
}

function mc_checklist($email, $debug, $apikey, $listid, $server) {
	$userid = md5( strtolower( $email ) );
	$auth = base64_encode( 'user:'. $apikey );

	$data = array(
		'apikey'        => $apikey,
		'email_address' => $email
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
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($ch);

	if ($debug) {
		var_dump($result);
	}

	$json = json_decode($result);

	echo $json->{'status'};

	die();
}

?>
