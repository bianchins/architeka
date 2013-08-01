<?php
require("../startup.php");

if(!$user->isLogged()) {
	header("Location: login.php");
	exit();
}

$data = array();

$p=new project($registry);

$projectArray = $p->getAllWithClients($user->getId());

foreach($projectArray as $project) {
	$projectList[] = array(
	'idproject'=>$project['idproject'],
	'project_description'=>$project['project_description'],
	'corr_user_id'=>$project['corr_user_id'],
	'firstname'=>$project['firstname'],
	'lastname'=>$project['lastname'],
	);
}

$data['firstname'] = $user->getFirstname();
$data['lastname'] = $user->getLastname();

$data['projectList']=$projectList;

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE_MOBILE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE_MOBILE . 'home.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE_MOBILE . 'footer.php');

$template->render($content);


?>