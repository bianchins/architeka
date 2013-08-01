<?php
require("startup.php");

$data = array();

$data['page']="reminder";


//Si salva il getCode in sessione
if($request->get['captcha']==1) {
	$c = new Captcha();
	$session->data['captcha_code'] = $c->getCode();
	$c->showImage();
	exit();
} else if ($request->post['action']=='reminder') {
	if($request->post['email']=='') {
		$data['feedback']=LANG_NOT_VALID_EMAIL;
	}
	else if($request->post['code']==$session->data['captcha_code']) {
		//Qui genero una nuova password per l'indirizzo email immesso
		$nuovapass = $user->regeneratePassword($request->post['email']);
		if($nuovapass) {
			$m = new Mail();
			$m->setTo($request->post['email']);
			$m->setSender('Architeka');
			$m->setFrom('no-reply@architeka.it');
			$m->setSubject(LANG_FORGOTTEN_PWD_MAIL_TITLE);
			$m->setText(LANG_FORGOTTEN_PWD_MAIL_FIRST_LINE.$m->newline.LANG_FORGOTTEN_PWD_MAIL_SECOND_LINE.$m->newline.$m->newline.'password: '.$nuovapass.$m->newline.$m->newline.$m->newline.'Architeca_ Simplenetworks s.r.l p.iva 00000000000 iscr. reg. imprese AABB');
			$m->send();
			$data['feedback']=LANG_FORGOTTEN_PWD_SUCCESS;
		} else {
			$data['feedback']=LANG_FORGOTTEN_PWD_ERROR;
		}
	}
	else {
		$data['feedback']=LANG_WRONG_CAPTCHA;
	}
}

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'reminder.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);
?>