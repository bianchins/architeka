<?php
require("../startup.php");
if($user->isLogged()) {
	//E' un cliente
	if($user->clientOf()>0) { /*header("Location: board.php");*/ header("Location: home.php"); exit(); }
	//E' un professionista
	else { header("Location: home.php"); exit(); }
} else {
	header("Location: login.php");
	exit();
}
?>