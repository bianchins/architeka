<?php
error_reporting(0);

require("../config.php");
require_once("../engine/mysql.php");
require_once("../engine/session.php");
require_once("../engine/registry.php");
require_once("../engine/request.php");


// Registry
$registry = new Registry();

// Database
$db = new mysql(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);
?>
Rimini, Italy