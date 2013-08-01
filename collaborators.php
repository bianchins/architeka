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

if($request->post['action']=="insertCollaborator") {

	

	$id_photo="user";

	

	$client_user_id = $user->insert($user->getID(),$request->post['firstname'],$request->post['lastname'],$request->post['username'],$request->post['password'],$request->post['phone'],$request->post['email'],$request->post['year'].'-'.$request->post['month'].'-'.$request->post['day'],$id_photo,$request->post['title'],'1');

	

	if($client_user_id>0) $data['feedback']=LANG_MANAGER_NEW_COLLABORATOR_SUCCESS;

	else $data['feedback']=LANG_MANAGER_NEW_COLLABORATOR_ERROR;

	

}



/*
 * Cancellazione collaboratore
 */

if($request->post['action']=="deleteCollaborator") {

	//Controllo se il professionista ha i diritti per farlo

	/*
	
	 * Ottengo la lista dei collaboratori del professionista
	
	 */
	
	$data['listaCollaboratori'] = $user->getCollaborators();
	
	$listaUserId = array();
	
	foreach($data['listaCollaboratori'] as $ut) {
	
		$listaUserId[] = $ut['user_id'];
	
	}	
	if(in_array($request->post['user_id'],$listaUserId)) {

		$user->delete($request->post['user_id']);

		$data['feedback']=LANG_MANAGER_DELETE_COLLABORATOR_SUCCESS;

	}

}

$data['page']="collaborators";

/*

 * Ottengo la lista dei collaboratori del professionista

 */

$data['listaCollaboratori'] = $user->getCollaborators();

$listaUserId = array();
if(sizeof($data['listaCollaboratori'])>0) {
	foreach($data['listaCollaboratori'] as $ut) {
	
		$listaUserId[] = $ut['user_id'];
	
	}
}


//Template

$template = new template($registry);



$template->data=& $data;



$content = $template->load(DIR_TEMPLATE . 'header.php');



$template->render($content);



$content = $template->load(DIR_TEMPLATE . 'collaborators.php');



$template->render($content);



$content = $template->load(DIR_TEMPLATE . 'right.php');



$template->render($content);



$content = $template->load(DIR_TEMPLATE . 'footer.php');



$template->render($content);



?>