<?php
/**
 * Vcard creator (tutti i parametri via POST)
 * @param firstname
 * @param lastname
 * @param title
 * @param phone
 * @param email
 * @param comune
 * @param indirizzo
 * @param cap
 * @param provincia
 */
error_reporting(0);

require("../config.php");
require_once("../startup.php");

header( "Content-type:text/x-vCard" );
header('Content-Disposition: attachment; filename="vCard.vcf"');

echo "BEGIN:VCARD\r\n";
echo "VERSION:2.1\r\n";
echo "N:".$request->post['lastname'].";".$request->post['firstname'].";;".$request->post['title'].";\r\n";
echo "FN:".$request->post['title']." ".$request->post['firstname']." ".$request->post['lastname']."\r\n";
echo "ADR;WORK:;;".$request->post['indirizzo'].";".$request->post['comune'].";".$request->post['provincia'].";".$request->post['cap'].";\r\n";
echo "TEL;WORK;VOICE:".$request->post['phone']."\r\n";
echo "EMAIL;PREF;INTERNET:".$request->post['email']."\r\n"; 
echo "REV:".date("Ymd")."T11:00:36Z\r\n";
echo "END:VCARD\r\n";
?>