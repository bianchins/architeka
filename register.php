<?php
require("startup.php");

$data = array();

$data['page']="register";

//Si salva il getCode in sessione
if($request->get['captcha']==1) {
	$c = new Captcha();
	$session->data['captcha_code'] = $c->getCode();
	$c->showImage();
	exit();
}
else if($request->post['action']=='save') {
	//Funzione di registrazione utente
	
	if($request->post['accetto_terms']!="" && $request->post['accetto_privacy']!="" ) {
		if($user->check_email_mx($request->post['email'])) {
			if($request->post['code']==$session->data['captcha_code']) {
				//Immagine del default user
				$id_photo="user";
				//Controllo se la mail e' gia' negli archivi
				if (!$user->emailExist($request->post['email'])) {
					$architect_user_id = $user->insertArchitect($request->post['firstname'],$request->post['lastname'],$request->post['username'],$request->post['password'],$request->post['phone'],$request->post['email'],$request->post['year'].'-'.$request->post['month'].'-'.$request->post['day'],$id_photo,$request->post['title'],'2010-12-31',$request->post['piva']);
					if($architect_user_id>0) $data['feedback']=LANG_REGISTER_SUCCESS;
					else $data['feedback']=LANG_REGISTER_ERROR;
				}
				else $data['feedback']=LANG_REGISTER_MAIL_EXIST_ERROR;

			}
			else $data['feedback']=LANG_WRONG_CAPTCHA;
		}
		else $data['feedback']=LANG_NOT_VALID_EMAIL;
	}
	else $data['feedback']=LANG_REGISTER_ERROR_TERMS;
}

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'register.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);
?>