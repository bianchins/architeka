<?php
error_reporting(0);

require("../config.php");
require_once("../startup.php");


// Registry
$registry = new Registry();

// Database
$db = new mysql(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Request
$request = new Request();
$registry->set('request', $request);

// Session
$session = new Session();
$registry->set('session', $session);

//if(!isset($session->data['user_id'])) {	
//	echo "ERROR";	
//} else {
	$check_query = $db->query("SELECT user_id FROM tab_user WHERE username='".$db->escape($request->post['username'])."'");
	if ($check_query->num_rows) {
		echo '<font color="red">'.LANG_USERNAME_NOT_AVALIABLE.'</font>';
	}
	else echo "OK";
//}