<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Architeka - the customer social network for architects</title>

<link rel="icon" href="template/default/images/favicon.ico" />

<script src="template/javascript/jquery-1.4.min.js" type="text/javascript"></script>
<link href="template/javascript/ui_css/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="template/javascript/jquery-ui-1.8.4.custom.min.js"></script>
<link href="template/javascript/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="template/javascript/facebox/facebox.js" type="text/javascript"></script>

<!--[if IE]><script type="text/javascript" src="template/javascript/jquery.bgiframe.js"></script><![endif]-->

<!-- jquery timepicker -->
<link rel="stylesheet" type="text/css" href="template/javascript/jtimepicker/css/jquery.timepicker.css" />
<script type="text/javascript" src="template/javascript/jquery.jtimepicker.js"></script>

<link type="text/css" href="template/javascript/bouncebox.css" rel="stylesheet" media="all" />

<script type="text/javascript">
jQuery.noConflict(); 
jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox();
  
	//datepicker
  $('#appointment_date').datepicker({dateFormat: 'dd/mm/yy',minDate: 0,monthNames: ['<?php echo LANG_JANUARY?>','<?php echo LANG_FEBRUARY?>','<?php echo LANG_MARCH?>','<?php echo LANG_APRIL?>','<?php echo LANG_MAY?>','<?php echo LANG_JUNE?>','<?php echo LANG_JULY?>','<?php echo LANG_AUGUST?>','<?php echo LANG_SEPTEMBER?>','<?php echo LANG_OCTOBER?>','<?php echo LANG_NOVEMBER?>','<?php echo LANG_DECEMBER?>'], dayNamesMin: ['<?php echo LANG_SUNDAY_SHORT?>', '<?php echo LANG_MONDAY_SHORT?>', '<?php echo LANG_TUESDAY_SHORT?>', '<?php echo LANG_WEDNESDAY_SHORT?>', '<?php echo LANG_THURSDAY_SHORT?>', '<?php echo LANG_FRIDAY_SHORT?>', '<?php echo LANG_SATURDAY_SHORT?>']});
  

  //Notifiche
  $('#bouncebox').slideToggle("slow");

  $('#timepickerDate2').jtimepicker({
	  hourCombo: 'appointment_time_hour',
	  minCombo: 'appointment_time_minute'
  });
  
	$('#bouncebox').click(function(){
	$('#bouncebox').slideToggle("slow");
	});

	<?php if($page=='manager' || $page=='register' || $page=='collaborators' || $page=='customers') { ?>
	$("#username").change(function() { 

		var usr = $("#username").val();

		if(usr.length >= 3)
		{
		$("#status").html('<img src="ajax/loader.gif" align="absmiddle">&nbsp;Controllo la disponibilita&agrave;...');

		    $.ajax({  
		    type: "POST",  
		    url: "ajax/checkuser.php",  
		    data: "username="+ usr,  
		    success: function(msg){  
		   
		   $("#status").ajaxComplete(function(event, request, settings){ 
			//alert(msg);
			if(msg == 'OK')
			{ 
		        //$("#username").removeClass('object_error'); // if necessary
				//$("#username").addClass("object_ok");
				$(this).html('&nbsp;<img src="ajax/accepted.png" align="absmiddle" style="border:none; padding:1px; margin:1px;"/> <font color="Green"> <?php echo LANG_USERNAME_AVALIABLE;?> </font>  ');
			}  
			else  
			{  
				//$("#username").removeClass('object_ok'); // if necessary
				//$("#username").addClass("object_error");
				$(this).html(msg);
			}  
		   
		   });

		 } 
		   
		  }); 

		}
		else
			{
			$("#status").html('<font color="red">The username should have at least <strong>3</strong> characters.</font>');
			$("#username").removeClass('object_ok'); // if necessary
			$("#username").addClass("object_error");
			}

		});
	<?php } ?>

	   
});

function showbox(url) {
	  jQuery.facebox({ ajax: url });
}

function chiudi() {
	jQuery.facebox.close();
}
</script>

<link type="text/css" media="screen" rel="stylesheet" href="template/default/stylesheets/reset.css" />
<link type="text/css" media="screen" rel="stylesheet" href="template/default/stylesheets/main.css" />
<link type="text/css" media="screen" rel="stylesheet" href="template/default/stylesheets/banner.css" />
<script type="text/javascript" src="template/javascript/banner.js"></script>


</head>

<body>
<div id="header">
  <h1><a href="index.php">logo</a></h1>
  <ul>
    <li><a href="home.php" <?php if($page=="") { ?>class="active"<?php } ?>><?php echo LANG_HOME;?></a></li>
    <!--<li><a href="guide.php" <?php if($page=="guide") { ?>class="active"<?php } ?>><?php echo LANG_GUIDE;?></a></li>-->
    <li><a href="information.php" <?php if($page=="information") { ?>class="active"<?php } ?>><?php echo LANG_INFORMATION;?></a></li>
    <li><a href="advertising.php" <?php if($page=="advertising") { ?>class="active"<?php } ?>><?php echo LANG_ADV;?></a></li>
    <li><a href="contact.php" <?php if($page=="contact") { ?>class="active"<?php } ?>><?php echo LANG_CONTACTS;?></a></li>
  </ul>
    <fieldset>
    <p><?php echo LANG_FOLLOWUS;?></p>
     <a id="RSS" href="rss/news.xml">&nbsp;&nbsp;&nbsp;&nbsp;</a>
     <a id="twitter" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a>
     <a id="facebook" href="http://www.facebook.com/pages/Architeka/143504099007694" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;</a>
    </fieldset>
</div>
<!-- //#header -->

<!-- content -->
<div id="content" class="clearfix">
  <div id="content-inner">

<?php 
if (($page!="information") && ($page!="advertising") && ($page!="contact") && ($page!="reminder") && ($page!="register") && ($page!="credits") && ($page!="guide") && ($page!="privacy") && ($page!="terms")) {
?>
<!-- tabs -->
<div id="tabs">

    <div class="ftabs"><a id="fmpt_status" <?php if($page=="") { ?>class="active"<?php } ?> href="board.php"><img
        src="template/default/images/icons/icon_home.gif" /> <span><?php echo LANG_HOME;?></span></a> <a
        id="fmpt_recent" href="settings.php" <?php if($page=="settings") { ?>class="active"<?php } ?>><img
        src="template/default/images/icons/list_settings.gif" /> <span><?php echo LANG_SETTINGS;?></span></a>
    <?php  if ( $this->registry->get('user')->clientOf()==0 ) { ?>
    <a id="fmpt_everyone" href="manager.php" <?php if($page=="manager") { ?>class="active"<?php } ?>><img
        src="template/default/images/icons/tables.gif" /> <span><?php echo LANG_MANAGE_PROJECT;?></span></a>
    <a id="fmpt_everyone" href="customers.php" <?php if($page=="customers") { ?>class="active"<?php } ?>><img
        src="template/default/images/icons/customer.png" /> <span><?php echo LANG_MANAGE_USERS;?></span></a>
    <a id="fmpt_everyone" href="collaborators.php" <?php if($page=="collaborators") { ?>class="active"<?php } ?>><img
        src="template/default/images/icons/collaborator.png" /> <span><?php echo LANG_MANAGE_COLLABORATORS;?></span></a>        
         <?php } ?> <a id="fmpt_advanced" class="last"
        href="login.php?action=logout"><img
        src="template/default/images/icons/action_stop.gif" /> <span><?php echo LANG_LOGOUT;?></span></a>
    </div>

</div>
<!-- /tabs -->
<?php } ?>

