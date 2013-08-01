<?php
/**
 * addentry.php
 * @author Stefano Bianchini
 */
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$e = new entry($registry);
$appoint = new appointment($registry);

switch($request->post['action']) {
	/*
	 * Inserimento di un commento
	 */
	case "comment":
		//! Da fare: ho i diritti di commentare quella determinata entry?
		$e->insertComment($request->post['comment_entry_id'],$user->getId(),$request->post['comment_content']);
		header("Location: board.php");
		exit();
		break;
	/*
	 * Inserimento di una entry
	 */
	case "addentry":
		$e->insertEntry($user->getId(),0,$session->data['idproject'],$request->post['entry_description'],$request->post['entry_content'],$request->post['entry_type']);
		/*
		 * Codice relativo all'invio delle mail di notifica
		 */
		$p=new project($registry);
		$listaPartecipanti = $p->getClientsMailWithNotify($session->data['idproject']);
		//Se i partecipanti al progetto hanno richiesto la notifica via email, la devo mandare 		
		foreach($listaPartecipanti as $us) {
			
			$e->sendNotifyMail($us->email,$request->post['entry_description'],$request->post['entry_content']);
		}
		//Devo mandarla anche all'autore del progetto (il professionista)
		$mailAuthor = $p->getAuthorIdMail($session->data['idproject']);
		
		if($mailAuthor) {
			
			$e->sendNotifyMail($mailAuthor,$request->post['entry_description'],$request->post['entry_content']);
		}
		/*
		 * Fine codice invio notifica
		 */	
		header("Location: board.php");
		exit();
		break;
	/*
	 * Inserimento di un appuntamento
	 */
	case "addAppointment":
		$appoint->insertAppointment($user->getId(),$session->data['idproject'],$request->post['appointment_description'],$request->post['appointment_place'],$request->post['appointment_date'],$request->post['appointment_time_hour'].':'.$request->post['appointment_time_minute']);		
		header("Location: date.php?action=list");
		exit();
		break;
	/*
	 * Eliminazione di un appuntamento
	 */
	case "delete_entry":
		//! Da fare: ho i diritti per eliminarlo?
		$e->deleteEntry($request->post['entry_id']);
		break;	case "delete_comment":		//! Da fare: ho i diritti per eliminarlo?		$e->deleteComment($request->post['comment_id']);		break;		
}


$data = array();

//Template

$specificTemplate='entry/messaggio.php';
/*
 * Carico il template a seconda del tipo passato
 */
switch($request->get['type']) {
	case "1": $specificTemplate='entry/foto.php'; break;
	case "2": $specificTemplate='entry/link.php'; break;
	case "3": $specificTemplate='entry/messaggio.php'; break;
	case "4": $specificTemplate='entry/allegato.php'; break;
	default: header("Location: board.php"); break;
}

$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . $specificTemplate);

$template->render($content);

?>