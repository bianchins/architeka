<?php
require("startup.php");

if (isset($request->get['lang'])) $session->data['lang']=$request->get['lang'];

if($user->isLogged()) {
	//E' un cliente
	if($user->clientOf()>0) { /*header("Location: board.php");*/ header("Location: home.php"); exit(); }
	//E' un professionista
	else { header("Location: home.php"); exit(); }
} else {
	//L'utente non e' loggato, lo mando al login
	header("Location: login.php");
	exit();
}
?>