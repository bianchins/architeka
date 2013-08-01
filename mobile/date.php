<?php
require("../startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$data = array();

$appoint = new appointment($registry);

/*
 * Se ho richiesto l'azione "list", e in sessione ho l'id del progetto,
 * mostro gli appuntamenti futuri solo del progetto selezionato
 */
if(($session->data['idproject']>0) && ($request->get['action']!='list')) {
	$appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id='".$session->data['idproject']."'");
} else {
	/*
	 * Altrimenti faccio vedere tutti gli appuntamenti di tutti i progetti seguiti
	 */
	$appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id IN (SELECT idproject FROM tab_project JOIN tab_user_project ON idproject=corr_project_id WHERE corr_user_id='".$user->getId()."' OR project_authorid='".$user->getId()."')");
}
/*
 * Strutturo l'array degli appuntamenti da dare in pasto al template
 */
foreach($appointmentArray as $app) {
	$appList[] = array(
	'appointment_id' => $app['appointment_id'],
	'appointment_date' => $app['appointment_date'],
	'appointment_description' => $app['appointment_description'],
	'appointment_time' => $app['appointment_time']
	);
}
$data['appointments'] = $appList;

$data['action'] = $request->get['action'];

/*
 * Nel caso gli passo l'appointment_id vuol dire che sto visualizzando un appuntamento in particolare
 * Carico quindi i dati dell'appuntamento in una variabile, che poi viene utilizzata dal template
 */
if ((is_numeric($request->get['appointment_id'])) && ($request->get['appointment_id']>0)) {
	$data['datiAppuntamento'] = $appoint->getAppointment($request->get['appointment_id']);
}

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE_MOBILE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE_MOBILE . 'entry/date.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE_MOBILE . 'footer.php');

$template->render($content);

?>
