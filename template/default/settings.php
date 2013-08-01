<?php if(isset($feedback)) {
?>
<div id="bouncebox">
<p><b><?php echo LANG_NOTIFY;?></b><?php echo $feedback;?></p>
</div>
<?php 	
}
?>

<div class="column main">
<script language="JavaScript">
function checkForm()
{
   var cname, cemail, clastname, cphone;
   with(window.document.insertform)
   {
      cfirstname    = firstname;
      cemail   = email;
      clastname = lastname;
      cphone = phone;
   }

   if(trim(cfirstname.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTNAME;?>');
      cfirstname.focus();
      return false;
   }
   else if(trim(cemail.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_VALIDEMAIL;?>');
      cemail.focus();
      return false;
   }
   else if(!isEmail(trim(cemail.value)))
   {
      alert('<?php echo LANG_JAVASCRIPT_NOTVALIDEMAIL;?>');
      cemail.focus();
      return false;
   }
   else if(trim(clastname.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTLASTNAME;?>');
      clastname.focus();
      return false;
   }
   else if(trim(cphone.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTPHONE;?>');
      cphone.focus();
      return false;
   }
   else if(window.document.insertform.newpassword.value != window.document.insertform.newpasswordconfirm.value)
   {
      alert('<?php echo LANG_SETTINGS_PASSWORD_NOT_MATCH;?>');
      window.document.insertform.newpassword.focus();
      return false;
   }
   else
   {
      //firstname.value    = trim(cfirstname.value);
      //email.value   = trim(cemail.value);
      //lastname.value = trim(clastname.value);
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}

function isEmail(str)
{
	var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(str)) return false;
	else return true;

}
</script>


<h3><?php echo LANG_SETTINGS_PROFILE_TITLE;?></h3>

<form action="settings.php" method="post" name="insertform" enctype="multipart/form-data">
<input type="hidden" name="action" value="save" />
<table class="insert_table">
	<tbody>
	
	<tr>
		<td><?php echo LANG_SETTINGS_USER_TITLE;?></td>
		<td><select name="title">
			<option value="<?php echo LANG_TITLE_PEOPLE1?>" <?php if ($title==LANG_TITLE_PEOPLE1) echo "SELECTED=\"SELECTED\""?>>Arch.</option>
			<option value="<?php echo LANG_TITLE_PEOPLE2?>" <?php if ($title==LANG_TITLE_PEOPLE2) echo "SELECTED=\"SELECTED\""?>>Ing.</option>
			<option value="<?php echo LANG_TITLE_PEOPLE3?>" <?php if ($title==LANG_TITLE_PEOPLE3) echo "SELECTED=\"SELECTED\""?>>Geom.</option>
			<option value="<?php echo LANG_TITLE_PEOPLE4?>" <?php if ($title==LANG_TITLE_PEOPLE4) echo "SELECTED=\"SELECTED\""?>>Sig.</option>
			<option value="<?php echo LANG_TITLE_PEOPLE5?>" <?php if ($title==LANG_TITLE_PEOPLE5) echo "SELECTED=\"SELECTED\""?>>Sig.ra</option>
			</select></td>
	</tr>
	
	<tr>
		<td><?php echo LANG_FIRSTNAME;?></td>
		<td><input type="text" size="30" name="firstname" value="<?php echo $firstname;?>"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_LASTNAME;?></td>
		<td><input type="text" size="30" name="lastname" value="<?php echo $lastname;?>"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_SETTINGS_ACTUAL_PWD;?></td>
		<td><input type="password" size="30" name="oldpassword" <?php if($username=='architeka') echo 'DISABLED="DISABLED"';?>/></td>
	</tr>
	<tr>
		<td><?php echo LANG_SETTINGS_NEWPWD;?></td>
		<td><input type="password" size="30" name="newpassword" <?php if($username=='architeka') echo 'DISABLED="DISABLED"';?>/></td>
	</tr>
	<tr>
		<td><?php echo LANG_SETTINGS_NEWPWD_CONFIRM;?></td>
		<td><input type="password" size="30" name="newpasswordconfirm" <?php if($username=='architeka') echo 'DISABLED="DISABLED"';?>/></td>
	</tr>
	<tr>
		<td><?php echo LANG_EMAIL;?></td>
		<td><input type="text" size="30" name="email" value="<?php echo $email;?>" <?php if($username=='architeka') echo 'DISABLED="DISABLED"';?>/></td>
	</tr>
	<tr><td><?php echo LANG_SETTINGS_ACTUALPHOTO;?></td>
		<td><img src="avatar.php?name=<?php echo $photo ?>.jpg" /><br/></td>
	</tr>
	<tr>
		<td><?php echo LANG_SETTINGS_NEWPHOTO;?></td>
		<td><input type="file" class="field" name="photo" style="color: #dddddd; width: 200px;" <?php if($username=='architeka') echo 'DISABLED="DISABLED"';?>/></td>
	</tr>
	<tr>
		<td><?php echo LANG_PHONE;?></td>
		<td><input type="text" size="30" name="phone" value="<?php echo $phone;?>"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_BIRTHDATE;?></td>
		<td><select name="day">
		<option value=""><?php echo LANG_DAY;?></option>
		<?php 
		for($i=1;$i<=31;$i++) {
			echo '<option value="'.$i.'"';
			if($i==$day) echo 'SELECTED';
			echo '>'.$i.'</option>';
		}		
		?>
		</select> 
		<select name="month">
			<option value=""><?php echo LANG_MONTH;?></option>
			<option value="1" <?php if($month==1) echo "SELECTED";?>><?php echo LANG_JANUARY;?></option>
			<option value="2" <?php if($month==2) echo "SELECTED";?>><?php echo LANG_FEBRUARY;?></option>
			<option value="3" <?php if($month==3) echo "SELECTED";?>><?php echo LANG_MARCH;?></option>
			<option value="4" <?php if($month==4) echo "SELECTED";?>><?php echo LANG_APRIL;?></option>
			<option value="5" <?php if($month==5) echo "SELECTED";?>><?php echo LANG_MAY;?></option>
			<option value="6" <?php if($month==6) echo "SELECTED";?>><?php echo LANG_JUNE;?></option>
			<option value="7" <?php if($month==7) echo "SELECTED";?>><?php echo LANG_JULY;?></option>
			<option value="8" <?php if($month==8) echo "SELECTED";?>><?php echo LANG_AUGUST;?></option>
			<option value="9" <?php if($month==9) echo "SELECTED";?>><?php echo LANG_SEPTEMBER;?></option>
			<option value="10" <?php if($month==10) echo "SELECTED";?>><?php echo LANG_OCTOBER;?></option>
			<option value="11" <?php if($month==11) echo "SELECTED";?>><?php echo LANG_NOVEMBER;?></option>
			<option value="12" <?php if($month==12) echo "SELECTED";?>><?php echo LANG_DECEMBER;?></option>
		</select> 
		<select name="year">
			<option value=""><?php echo LANG_YEAR;?></option>
			<?php 
				
			for($i=1920;$i<=1990;$i++) {
					echo '<option value="'.$i.'"';
					if($i==$year) echo 'SELECTED';
					echo '>'.$i.'</option>';
				}		
			?>
		</select>
		</td>
	</tr>
   </tbody>
	<tfoot class="insert_table">
    <tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SAVE;?>" onClick="return checkForm();"/></td>
	</tr>
	</tfoot>
</table>

<h3><?php echo LANG_SETTINGS_NOTIFY;?></h3>
<table class="insert_table">
<tbody class="insert_table">
<tr><td>
<input type="checkbox" id="notify_on_entry" name="notify_on_entry" <?php if ($notify_on_entry) echo "CHECKED";?>/> <label for="notify_on_entry"><?php echo LANG_SETTINGS_NOTIFY_OPTION;?></label><br/>
<!-- <input type="checkbox" id="notify_on_appointment" name="notify_on_appointment"/> <label for="notify_on_appointment">Notifica via email su ogni nuovo appuntamento</label><br/>  -->

</td></tr>
</tbody>
</table>
<?php if($clientOf==0) {?>
<br/><br/>
<h3><?php echo LANG_SETTINGS_BILL_TITLE;?></h3>
<table class="insert_table">
	<tbody class="insert_table">
		<tr>
			<td><?php echo LANG_SETTINGS_BILL_HEADER;?></td>
			<td><textarea name="subscription_intestatario_fattura" rows="5" cols="50"><?php echo $intestatario_fattura?></textarea>
			</td>
		</tr>
		<?php 
		//Piva e codice fiscale mi servono solo in Italia!!!
		if(PREFERRED_LANG=='it') { ?>
		<tr>
			<td><?php echo LANG_PIVA;?></td>
			<td><input type="text" name="subscription_piva" value="<?php echo $piva?>"/></td>
		</tr>
		<tr>
			<td>Codice fiscale</td>
			<td><input type="text" name="subscription_codfisc" value="<?php echo $cod_fisc?>"/></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot class="insert_table">
    <tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SAVE;?>" onClick="return checkForm();"/></td>
	</tr>
	</tfoot>
</table>
<?php } ?>
</form>
</div>