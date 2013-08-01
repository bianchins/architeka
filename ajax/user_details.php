<?php
error_reporting(0);

require("../config.php");
require_once("../startup.php");

if(!isset($request->get['user_id'])) {	
	echo "ERROR";	
} else {
	
	//Devo controllare se l'utente e' un cliente del professionista
	
	$check_query = $db->query("SELECT * FROM tab_user WHERE user_id='".$db->escape($request->get['user_id'])."' AND client_of='".$user->getId()."'");
	if ($check_query->num_rows) {
		
		$cliente = $check_query->row;
		?>
		<div class="box">
		<h3><img src="template/default/images/icons/view.png"/> <?php echo LANG_USER_DETAIL?></h3>
		<b><?php echo LANG_FIRSTNAME?>, <?php echo LANG_LASTNAME?>:</b> <?php echo $cliente['title']?> <?php echo $cliente['firstname']?> <?php echo $cliente['lastname']?><br/>
		<b><?php echo LANG_PHONE?>:</b> <?php echo $cliente['phone']?><br/>
		<b><?php echo LANG_EMAIL?>:</b> <a href="mailto:<?php echo $cliente['email']?>"><?php echo $cliente['email']?></a><br/>
		<b><?php echo LANG_ADDRESS?>:</b> <?php echo $cliente['indirizzo']?> - <?php echo $cliente['cap']?> <?php echo $cliente['comune']?> - <?php echo $cliente['provincia']?><br/>   
		</div>
		<?php 
	}
	else echo "Ajax error";
}