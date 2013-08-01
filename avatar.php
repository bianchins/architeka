<?php
/**
 * avatar.php
 * @author Stefano Bianchini
 * 
 * classe wrapper per lo scaricamento (sicuro) delle immagini avatar degli utenti
 */

require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!$user->isLogged()) {
	header("Location: login.php");
	exit();
} 

 $download = new forceDownload(DIR_IMAGE.$request->get['name']);
 
 $download->_allowedExtensions = "jpg,gif,png";
 
 $download->_allowedPath = rtrim(DIR_IMAGE,'/');
  
 $download->DownloadWithFilter();
 
 ?>