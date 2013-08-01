<?php
/*
 * Azioni di visualizzazione form login
 *
 * Azione di login
 *
 * Azione di logout
 *
 */

require("../startup.php");

$data = array();

if($user->isLogged() && $request->get['action']=='logout') {
	//Azione di Logout
	$user->logout();
	$data['feedback']="Ti sei scollegato dal sistema con successo";
}
if(!$user->isLogged() && $request->post['username']!='' && $request->post['password']!='') {
	//Login
	if ($user->login($request->post['username'],$request->post['password'])) {
		//Login positivo
		header("Location: index.php");
		exit();
	}
	else {
		//Login negativo
		$data['feedback']="Accesso non avvenuto, nome utente o password sbagliate.";
	}
}

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE_MOBILE . 'login.php');

$template->render($content);

?>