<?php
/**
 * board.php
 * @author Stefano Bianchini
 */
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$data = array();
/*
 * Creazione oggetti
 */
$e = new entry($registry);
$appoint = new appointment($registry);
$p=new project($registry);

/*
 * Se ho richiesto uno specifico idproject, lo salvo in sessione (cosi' non me lo devo
 * portare dietro via get
 */
if ($request->get['idproject']>0) {
	
	$session->data['project_description']=$p->getName($request->get['idproject']);
	$data['project_description']=$session->data['project_description'];
	$session->data['idproject']=$request->get['idproject'];
} else {
	//Da capire se serve questo codice, probabilmente no!
	$request->get['idproject']=$session->data['idproject'];
	$session->data['project_description']=$p->getName($session->data['idproject']);
	$data['project_description']=$session->data['project_description'];
}
//Se non ho l'id del progetto in sessione, vado alla pagina di scelta progetto
if($session->data['idproject']=="") {header("Location:home.php");}
$data['actualidproject'] = $session->data['idproject'];
//Setto il mio user_id in sessione
$data['user_id']=$user->getId();
//Setto il mio nome e cognome in sessione
$data['name']=$user->getFirstname()." ".$user->getLastname();

$filter="";


//!QUA FARE TUTTI I CONTROLLI DI DIRITTI PER IL PROGETTO SELEZIONATO
//e' un cliente
if($user->clientOf()>0) {
	//!Controllare che il cliente ci sia in corr_user_id
	if($session->data['idproject']>0) {
		$filter=" AND entry_project_id='".$session->data['idproject']."'";
	}
} else {
	//non e' un cliente, e' il professionista
	//Controllo che il professionista sia il project_authorid
	if($session->data['idproject']>0) {
		if($p->getAuthorId($session->data['idproject'])==$user->getId()) {
			$filter=" AND entry_project_id='".$session->data['idproject']."'";
		}
		else $filter=" AND 0";
	}
}
//Qui carico la lista progetti seguiti per il menu a tendina$data['listaProgetti'] = $p->getAll($user->getId());


//Qui decido quanti farne vedere (e quali)

if($request->get['viewall']=='true') $limit="";	
//Ne visualizzo normalmente solo 10 (gli ultimi)
else $limit="LIMIT 0,10";

//Scorro tutti i post, filtrandoli

/*
 * Carico gli appuntamenti futuri
 */
$entryArray = $e->getAllEntry($filter,$limit);
//$appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id='".$session->data['idproject']."'");
/*
 * Strutturo l'array delle entry da passare al template
 */
foreach($entryArray as $entry) {

	$entryList[] = array(
	'content'=>$e->elaborateContent($entry['entry_content'],$entry['entry_type']),
	'entry_id'=>$entry['entry_id'],
	'photo'=>$entry['photo'],
	'description'=>$entry['entry_description'],
	'author'=> $entry['title'].' '.$entry['firstname'].' '.$entry['lastname'], //$e->getAuthorName($entry['entry_author_id']),
	'author_id'=>$entry['entry_author_id'],
	'publish_time'=>$entry['entry_publish_time'],
	'publish_date'=>$e->getPublishDate($entry['entry_publish_date']),
	'comments_list'=>$e->getComments($entry['entry_id'])
	);

}
/*
 * Strutturo l'array degli appuntamenti da passare al template
 *//*
foreach($appointmentArray as $app) {
	$appList[] = array(
	'appointment_id' => $app['appointment_id'],
	'appointment_date' => $app['appointment_date'],
	'appointment_description' => $app['appointment_description'],
	'appointment_time' => $app['appointment_time']
	);
}*/

$data['entries'] = $entryList;
//$data['appointments'] = $appList;

$data['firstname'] = $user->getFirstname();
$data['lastname'] = $user->getLastname();

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'left.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'board.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);


?>