<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}


$project=new project($registry);

//Accesso alla pagina consentito solo ai professionisti, cioe' con client_of=0
if($user->clientOf()>0) {
	header("Location:index.php");
} 

$data = array();

/*
 * Inserimento nuovo cliente
 */
if($request->post['action']=="insertClient") {
	$id_photo="user";
		$client_user_id = $user->insert($user->getID(),$request->post['firstname'],$request->post['lastname'],$request->post['username'],$request->post['password'],$request->post['phone'],$request->post['email'],$request->post['year'].'-'.$request->post['month'].'-'.$request->post['day'],$id_photo,$request->post['title']);
		if($client_user_id>0) $data['feedback']=LANG_MANAGER_NEW_CUSTOMER_SUCCESS;
		else $data['feedback']=LANG_MANAGER_NEW_CUSTOMER_ERROR;
}
/* * Salvataggio modifiche cliente */if($request->post['action']=="saveEditClient") {	$client_user_id = $user->updateCustomer($request->post['user_id'], $request->post['firstname'], $request->post['lastname'], $request->post['email'], $request->post['year'].'-'.$request->post['month'].'-'.$request->post['day'], $request->post['title'], $request->post['indirizzo'], $request->post['cap'], $request->post['comune'], $request->post['provincia'], $request->post['phone']);		if($client_user_id>0) $data['feedback']=LANG_MANAGER_EDIT_CUSTOMER_SUCCESS;		else $data['feedback']=LANG_MANAGER_EDIT_CUSTOMER_ERROR;}/** * Visualizzazione form modifiche cliente */$data['showEditForm']=false;if($request->post['action']=="editClient") {	//Cerco i dati	$data['selectedCustomerInfo'] = $user->getSpecificUser($request->post['user_id']);	if(sizeof($data['selectedCustomerInfo'])>0)		$data['showEditForm']=true;	else 		$data['feedback']=LANG_MANAGER_CUSTOMER_NOT_FOUND;}
/*
 * Ottengo la lista dei clienti del professionista
 */
$data['listaUtenti'] = $user->getClients();
$listaUserId = array();
foreach($data['listaUtenti'] as $ut) {
	$listaUserId[] = $ut['user_id'];
}

/*
 * Cancellazione cliente
 */
if($request->post['action']=="deleteClient") {
	//Controllo se il professionista ha i diritti per farlo
	if(in_array($request->post['user_id'],$listaUserId)) {
		$user->delete($request->post['user_id']);
		$data['feedback']=LANG_MANAGER_DELETE_CUSTOMER_SUCCESS;
	}		/*		 * li ricarico se ho cancellato qualche cliente		 */		$data['listaUtenti'] = $user->getClients();		$listaUserId = array();		foreach($data['listaUtenti'] as $ut) {			$listaUserId[] = $ut['user_id'];		}
}


$data['page']="customers";

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'customers.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>