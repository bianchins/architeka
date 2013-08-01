<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!$user->isLogged()) {
	header("Location: login.php");
	exit();
}

$data = array();
$p=new project($registry);
$projectArray = $p->getAllWithClients($user->getId());
$actual_id_project="";
$i=0;
foreach($projectArray as $project) {	
	if($project['idproject']!=$actual_id_project) {		if($project['corr_isCollaborator']) $tipo = LANG_COLLABORATOR; else $tipo = LANG_CUSTOMER;		
	$projectList[$i] = array(
	'idproject'=>$project['idproject'],
	'project_description'=>$project['project_description'],
	'corr_user_id'=>$project['corr_user_id'],	
	'customer'=>$tipo.' '.$project['firstname'].' '.$project['lastname'],
	);
	$actual_id_project = $project['idproject'];
	$i++;
	}
	else {		if($project['corr_isCollaborator']) $tipo = LANG_COLLABORATOR; else $tipo = LANG_CUSTOMER;
		$projectList[$i-1]['customer'].=', '.$tipo.' '. $project['firstname'].' '. $project['lastname'];
	}
}

$data['userclientOf'] = $user->clientOf();$data['isCollaborator'] = $user->isCollaborator();

$data['firstname'] = $user->getFirstname();
$data['lastname'] = $user->getLastname();

$data['projectList']=$projectList;
$data['userProjectLimit'] = $user->getProjectLimit();

//Template
$template = new template($registry);
$template->data=& $data;
$content = $template->load(DIR_TEMPLATE . 'header.php');
$template->render($content);
$content = $template->load(DIR_TEMPLATE . 'left.php');
$template->render($content);
$content = $template->load(DIR_TEMPLATE . 'home.php');
$template->render($content);
$content = $template->load(DIR_TEMPLATE . 'right.php');
$template->render($content);
$content = $template->load(DIR_TEMPLATE . 'footer.php');
$template->render($content);
?>