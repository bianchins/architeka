<?php
/**
 * Caricamento librerie necessarie per il funzionamento
 */

//error_reporting(E_ALL ^ E_NOTICE);error_reporting(0);
DEFINE('ARCHITEKA_VERSION','2.0.5beta');
require("config.php");
//Per manutenzioni, settare SERVER_DOWN a true nel file config.php
if(SERVER_DOWN) {
	header("Location: maintenance/index.php");
}

require_once("engine/registry.php");
require_once("engine/request.php");
require_once("engine/mysql.php");
require_once("engine/template.class.php");
require_once("engine/session.php");
require_once("engine/user.php");
require_once("engine/language_detect.class.php");
require_once("engine/image.php");
require_once("engine/mail.php");
require_once("engine/entry.php");
require_once("engine/project.php");
require_once("engine/appointment.php");
require_once("engine/mobile.php");
require_once("engine/log.php");
require_once("engine/captcha.php");
require_once("engine/comune.php");
require_once("engine/forceDownload.php");
require_once("engine/iCalcreator.class.php");

// Registry
$registry = new Registry();

// Database
$db = new mysql(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

/*
 * Procedura di logging degli errori
 */
$log = new log('error.txt');
$registry->set('log',$log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log;

	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		//$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);

	return TRUE;
}

// Error Handler
//set_error_handler('error_handler');
/*
 * Fine Procedura
 */

// Magic Quotes Fix
if (ini_get('magic_quotes_gpc')) {
	function clean($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[clean($key)] = clean($value);
			}
		} else {
			$data = stripslashes($data);
		}

		return $data;
	}

	$_GET = clean($_GET);
	$_POST = clean($_POST);
	$_COOKIE = clean($_COOKIE);
}


// Request
$request = new Request();
$registry->set('request', $request);

// Session
$session = new Session();
$registry->set('session', $session);

//Language Section
$detect_language = new detect_language();
$preferred_lang = $detect_language->getLanguage();
if(isset($session->data['lang'])) $preferred_lang=$session->data['lang'];
//Cosi' la posso usare ovunque
DEFINE(PREFERRED_LANG,$preferred_lang);

switch($preferred_lang) {	
	case "it" : require_once("language/it.php"); break;
	//every language
	default: require_once("language/en.php");	
}
//End language section

// User
$user = new User($registry);
$registry->set('user', $user);
?>