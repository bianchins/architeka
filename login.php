<?php
/*
 * Azioni di visualizzazione form login
 *
 * Azione di login
 *
 * Azione di logout
 *
 */

require("startup.php");

//if(mobile::isMobileRamo()) {
//	header("Location: mobile/");
//}

$data = array();

if($user->isLogged() && $request->get['action']=='logout') {
	//Azione di Logout
	$user->logout();
	$data['message_logout']=LANG_SUCCESSFULL_LOGOUT;
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
		$data['error']=LANG_WRONG_LOGOUT;
	}
}

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'login.php');

$template->render($content);

?>