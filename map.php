<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}

$data = array();
/*
 * Carico la lista appuntamenti (necessaria per left.tpl)
 */
$appoint = new appointment($registry);
$appointmentArray = $appoint->getAllAppointment(" AND appointment_date >= CURRENT_DATE AND appointment_project_id='".$session->data['idproject']."'");
foreach($appointmentArray as $app) {
	$appList[] = array(
	'appointment_id' => $app['appointment_id'],
	'appointment_date' => $app['appointment_date'],
	'appointment_description' => $app['appointment_description'],
	'appointment_time' => $app['appointment_time']
	);
}
$data['appointments'] = $appList;
/*
 * Fine carico lista appuntamenti
 */


//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'left.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'entry/mappa.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>