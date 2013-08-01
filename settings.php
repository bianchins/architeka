<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$data = array();

$data['lang'] = $session->data['lang'];

$data['page']="settings";

//Salvo le modifiche alle impostazioni del profilo personale
if($request->post['action']=="save" && $user->getUserName()!='architeka') {
	if($request->post['newpassword']==$request->post['newpasswordconfirm']) {
		$error_find=false;
		$birthdate = $request->post['year']."-".$request->post['month']."-".$request->post['day'];
				
		if($request->post['notify_on_entry']=='on') $notify_on_entry=1; else $notify_on_entry=0;
		if($request->post['notify_on_appointment']=='on') $notify_on_appointment=1; else $notify_on_appointment=0;
		$id_photo="";
		if(is_uploaded_file($request->files['photo']['tmp_name'])) {
			//cambio della foto dell'utente (con resize)		
			
			$t = getimagesize($request->files['photo']['tmp_name']);
			//var_dump($t);
			if(!$t)  {
				$error_find=true;
			}
			
			if (($t[2]!=1) && ($t[2]!=2) && ($t[2]!=3)) {
				$error_find=true;
			}
			
			if($error_find) { 
				$data['feedback']=LANG_SETTINGS_FORMAT_NOT_SUPPORTED;
			}
			else {
				$id_photo=md5(microtime());
				$imm = new Image($request->files['photo']['tmp_name']);
				$imm->resize(50,50);
				$imm->save(DIR_IMAGE.$id_photo.'.jpg');
				
				//Elimino la vecchia foto				if($user->getPhoto()!="user") {
					@unlink(DIR_IMAGE.$user->getPhoto().'.jpg');				}
			}
		}
		if(!$error_find) {
			if(!$user->update($user->getId(),$request->post['firstname'],$request->post['lastname'],$request->post['newpassword'],$request->post['oldpassword'],$request->post['phone'],$request->post['email'],$birthdate,$notify_on_entry,$id_photo,$request->post['title'])) {
				$data['feedback']=LANG_SETTINGS_ERROR_SAVING;
			}
			else {
				//Aggiornamento dati personali andato a buon fine, salvo i dati fatturazione
				if($user->clientOf()==0) {
					$user->updateBillInformation($user->getId(),$request->post['subscription_piva'],$request->post['subscription_intestatario_fattura'],$request->post['subscription_codfisc']);
				}
				$data['feedback']=LANG_SETTINGS_WELL_DONE;
			}
		
			//Aggiorno l'oggetto utente ricaricandolo
			$user = new User($registry);
			$registry->set('user', $user);	
		}	
	}
	else $data['feedback']=LANG_SETTINGS_PASSWORD_NOT_MATCH;
	
}
//Carico i dati di cui ho bisogno nel template$data['username'] = $user->getUserName();
$data['firstname'] = $user->getFirstname();
$data['lastname'] = $user->getLastname();
$data['email'] = $user->getEmail();
$data['phone'] = $user->getPhone();
$data['birthdate'] = $user->getBirthdate();
$data['photo'] = $user->getPhoto();
$data['title'] = $user->getTitle();
$data['piva'] = $user->getDatiFatturazione('piva');
$data['cod_fisc'] = $user->getDatiFatturazione('cod_fisc');
$data['intestatario_fattura'] = $user->getDatiFatturazione('intestatario_fattura');
$data['clientOf'] = $user->clientOf();

$data['day'] = substr($user->getBirthdate(),8,2);
$data['month'] = substr($user->getBirthdate(),5,2);
$data['year'] = substr($user->getBirthdate(),0,4);
$data['notify_on_entry'] = $user->getNotifyOnEntry();




//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

//$content = $template->load(DIR_TEMPLATE . 'left.php');

//$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'settings.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>