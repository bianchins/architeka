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
 * Inserimento progetto
 */
if($request->post['action']=="insertProject") {

	//Qui controllo quanti progetti ha fatto
	$num_attuale = $project->getProjectNumbers($user->getId());
	//Qui quanti ne ha come limite massimo
	$limiteProgetti = $user->getProjectLimit();
	
	//Per retrocompatibilita' con le prime versioni di architeka, dove il limite
	//non esisteva (era a zero)	
	if($limiteProgetti==0) $limiteProgetti=DEFAULT_PROJECT_LIMIT;
		//Nick's fix 
	if($num_attuale<99) {		//if($num_attuale<$limiteProgetti) {		$comune=$request->post['project_comune'];	if($request->post['othercountry']) {		$comune="0";			}				
	if($project->insert($request->post['project_description'],$user->getId(),$comune))
			$data['feedback']=LANG_MANAGER_NEW_PROJECT_SUCCESS;
	}
	else $data['feedback']=LANG_MANAGER_ERROR_LIMIT_PROJECT1.$user->getProjectLimit().LANG_MANAGER_ERROR_LIMIT_PROJECT2;
}

if($request->get['action']=="deleteProject") {
	//Controllo che abbia i diritti per modificare il progetto	
	if($project->getAuthorId($request->get['idproject'])==$user->getId()) {
		$nomeProgetto=$project->getName($request->get['idproject']);
		$project->delete($request->get['idproject']);
		$data['feedback']=LANG_PROJECT_DELETED.': '.$nomeProgetto;
	}
}

//Inizializzo le variabili a false
$data['showFormModifyProject']=false;$data['showFormModifyCollaboratorProject']=false;
/*
 * Associo i clienti al progetto
 */
if($request->get['action']=="modifyProject") {
	//Controllo che abbia i diritti per modificare il progetto	
	if($project->getAuthorId($request->get['idproject'])==$user->getId()) {
		$data['nomeProgetto']=$project->getName($request->get['idproject']);
		$data['idproject'] = $request->get['idproject'];
		$l=$project->getClients($request->get['idproject']);
		foreach($l as $lt) {
			$data['listaClienti'][]=$lt['user_id'];
		}
		//La metto a true in modo che nel template mi mostri il form di modifica 
		//delle associazioni cliente - progetto
		$data['showFormModifyProject']=true;
	}}
if($request->get['action']=="modifyProjectCustomer") {	//Controllo che abbia i diritti per modificare il progetto		if($project->getAuthorId($request->get['idproject'])==$user->getId()) {		$data['nomeProgetto']=$project->getName($request->get['idproject']);		$data['idproject'] = $request->get['idproject'];		$l=$project->getCollaborators($request->get['idproject']);		foreach($l as $lt) {			$data['listaCollaboratoriAlProgetto'][]=$lt['user_id'];		}				//La metto a true in modo che nel template mi mostri il form di modifica 		//delle associazioni cliente - progetto		$data['showFormModifyCollaboratorProject']=true;	}
}
/*
 * Ottengo la lista dei clienti del professionista
 * lo faccio qui perche' mi serve per controllare
 * se i clienti selezionati SONO del professionista
 */
$data['listaUtenti'] = $user->getClients();$data['listaCollaboratori'] = $user->getCollaborators();

$listaUserId = array();
foreach($data['listaUtenti'] as $ut) {
	$listaUserId[] = $ut['user_id'];
}foreach($data['listaCollaboratori'] as $ut) {	$listaCollaboratoriUserId[] = $ut['user_id'];}

/*
 * Salvo l'associazione cliente - progetto
 */
if($request->post['action']=="saveClientsProject") {
	//Controllo che abbia i diritti per modificare il progetto	
	if($project->getAuthorId($request->post['idproject'])==$user->getId()) {		
		//CONTROLLO CHE I CLIENTI SIANO DEL PROFESSIONISTA
		$error=false;
		foreach($request->post['clients'] as $cliente) {
			if(!in_array($cliente,$listaUserId)) {
				$error=true;
			}
		}
		if(!$error) {
			$project->updateClients($request->post['clients'],$request->post['idproject']);
			$data['feedback']=LANG_MANAGER_MODIFY_TO.': '.$project->getName($request->post['idproject']);
		}
	}
}/* * Salvo l'associazione collaboratore - progetto */if($request->post['action']=="saveCollaboratorsProject") {	//Controllo che abbia i diritti per modificare il progetto		if($project->getAuthorId($request->post['idproject'])==$user->getId()) {				//CONTROLLO CHE I COLLABORATORI SIANO DEL PROFESSIONISTA		$error=false;		foreach($request->post['collaborators'] as $collaboratore) {			if(!in_array($collaboratore,$listaCollaboratoriUserId)) {				$error=true;			}		}		if(!$error) {			$project->updateCollaborators($request->post['collaborators'],$request->post['idproject']);			$data['feedback']=LANG_MANAGER_MODIFY_TO.': '.$project->getName($request->post['idproject']);		}	}}

$com = new comune($registry);
$data['comuni'] = $com->loadList();

$data['page']="manager";

/*
 * Ottengo la lista dei progetti seguiti dal professionista
 */
$data['listaProgetti'] = $project->getAll($user->getId());

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'manager.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>