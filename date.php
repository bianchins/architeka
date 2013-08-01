<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$data = array();

$appoint = new appointment($registry);
if($request->get['action']=='delete') {		$appoint->deleteAppointment($request->post['appointment_id'], $user->getId());	$data['feedback']=LANG_EVENT_DELETE_OK;	$request->get['action']='list';}
if($request->get['action']=='ics') {
	$vCal = new vcalendar();
	$vCal->setConfig( 'unique_id', 'architeka.it' );
	$vCal->setProperty( 'method', 'PUBLISH' ); 
	$vCal->setProperty( "x-wr-calname", "Calendario Architeka" );  
	$vCal->setProperty( "X-WR-CALDESC", "Elenco Appuntamenti Architeka" ); 
	$vCal->setProperty( "X-WR-TIMEZONE", "Europe/Rome" );
	
	//Se ho selezionato un determinato progetto, faccio vedere solo gli appuntamenti del progetto selezionato
	if($session->data['idproject']>0) $appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id='".$session->data['idproject']."'");
	//Altrimenti faccio vedere tutti gli appuntamenti
	else $appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id IN (SELECT idproject FROM tab_project JOIN tab_user_project ON idproject=corr_project_id WHERE corr_user_id='".$user->getId()."' OR project_authorid='".$user->getId()."')");
	
	//Scorro gli appuntamenti uno per uno
	foreach($appointmentArray as $app) {
		//Estraggo i singoli dati (giorno, mese eccetera) dalla data e dal time
		$day=substr($app['appointment_date'],0,2);
		$month=substr($app['appointment_date'],3,2);
		$year=substr($app['appointment_date'],6,4);
		$hour=substr($app['appointment_time'],0,2);
		$min=substr($app['appointment_time'],3,2);
		// Creo un oggetto evento calendario e lo popolo 
		$vevent = new vevent(); 
		$vevent->setProperty( 'dtstart', array( 'year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$hour, 'min'=>$min, 'sec'=>0 )); 
		$vevent->setProperty( 'dtend', array( 'year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>($hour+1), 'min'=>$min, 'sec'=>0 )); 
		$vevent->setProperty( 'LOCATION', $app['appointment_place'] ); 
		$vevent->setProperty( 'summary', substr($app['appointment_description'],0,10).'...'); 
		$vevent->setProperty( 'description', $app['appointment_description'] );  
		
		// Aggiungo l'evento al calendario 
		$vCal->setComponent ( $vevent );  
	}
	//Lo sparo al browser :-)
	$vCal->returnCalendar();
	exit();
}
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
foreach($appointmentArray as $app) {
	$appList[] = array(
	'appointment_id' => $app['appointment_id'],
	'appointment_date' => $app['appointment_date'],
	'appointment_description' => $app['appointment_description'],
	'appointment_time' => $app['appointment_time']
	);
}
 */
$data['appointments'] = $appointmentArray; //$appList;

$data['action'] = $request->get['action'];
$data['user_id'] = $user->getId();
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

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'left.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'entry/date.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>
