<?php
/**
 * attachment.php
 * @author Stefano Bianchini
 * 
 * classe wrapper per lo scaricamento (sicuro) di file allegati al progetto che si sta guardando
 */

require("../startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!$user->isLogged()) {
	header("Location: login.php");
	exit();
} 

 $download = new forceDownload(DIR_ATTACHMENT.$session->data['idproject'].'/'.$request->get['name']);
 
 //$download->_allowedExtensions = "pdf,txt";
 
 $download->_allowedPath = DIR_ATTACHMENT.$session->data['idproject'];
 
 $download->DownloadWithFilter();
 
 ?>