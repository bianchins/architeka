<?php
require("startup.php");

$data = array();

$data['page']="credits";

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

//$content = $template->load(DIR_TEMPLATE . 'left.tpl');

//$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'credits.php');

$template->render($content);

//$content = $template->load(DIR_TEMPLATE . 'right.tpl');

//$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);
?>