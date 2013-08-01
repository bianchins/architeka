<?php if(isset($feedback)) {
?>
<div id="bouncebox">
<p><b><?php echo LANG_NOTIFY;?>: </b><?php echo $feedback;?></p>
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
      cusername = username;
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
   else if(trim(clastname.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTLASTNAME;?>');
      clastname.focus();
      return false;
   }
   else if(trim(cusername.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERT_VALID_USER;?>');
      cusername.focus();
      return false;
   }
   else if(!isEmail(trim(cemail.value)))
   {
      alert('<?php echo LANG_JAVASCRIPT_NOTVALIDEMAIL;?>');
      cemail.focus();
      return false;
   }
   else if(trim(cphone.value) == '')
   {
      alert('<?php echo LANG_JAVASCRIPT_INSERTPHONE;?>');
      cphone.focus();
      return false;
   }
   else
   {
      firstname.value    = trim(cfirstname.value);
      email.value   = trim(cemail.value);
      lastname.value = trim(clastname.value);
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


<h3><img src="template/default/images/icons/collaborator.png"/> <?php echo LANG_MANAGER_COLLABORATORS_LIST?></h3>
<table class="insert_table">
<thead class="insert_table"><tr><td><?php echo LANG_MANAGER_NAME_AND_SURNAME;?></td><td><?php echo LANG_MANAGER_ACTIONS;?></td></tr></thead>

<tbody class="insert_table">
<?php 

if(sizeof($listaCollaboratori)>0) {
	foreach ($listaCollaboratori as $collaboratore) {?>
	<tr><td><?php echo $collaboratore['title'].' '.$collaboratore['firstname'].' '.$collaboratore['lastname']?></td>
	<td style="width:180px;">
	<div style="float:left; margin-right:10px;">
	<form method="post" action="collaborators.php" >
	<input type="hidden" name="action" value="deleteCollaborator"/>
	<input type="hidden" name="user_id" value="<?php echo $collaboratore['user_id']?>"/>
	<input type="image" src="template/default/images/icons/collaborator_remove.png" onClick="return confirm('<?php echo LANG_MANAGER_DELETE_COLLABORATOR_QUESTION;?>');"/></form>
	</div>
	<div style="float:left; margin-right:10px;">
	<form method="post" action="ajax/vcard.php">
	<input type="hidden" name="user_id" value="<?php echo $collaboratore['user_id']?>"/>
	<input type="hidden" name="firstname" value="<?php echo $collaboratore['firstname']?>"/>
	<input type="hidden" name="lastname" value="<?php echo $collaboratore['lastname']?>"/>
	<input type="hidden" name="title" value="<?php echo $collaboratore['title']?>"/>
	<input type="hidden" name="phone" value="<?php echo $collaboratore['phone']?>"/>
	<input type="hidden" name="email" value="<?php echo $collaboratore['email']?>"/>
	<input type="hidden" name="indirizzo" value="<?php echo $collaboratore['indirizzo']?>"/>
	<input type="hidden" name="comune" value="<?php echo $collaboratore['comune']?>"/>
	<input type="hidden" name="provincia" value="<?php echo $collaboratore['provincia']?>"/>
	<input type="hidden" name="cap" value="<?php echo $collaboratore['cap']?>"/>
	<input type="image" src="template/default/images/icons/vcard.png" title="<?php echo LANG_EXPORT_VCARD?>" /></form>
	</div>
	<div style="float:left; margin-right:10px;">
	<form method="get">
	<input type="image" src="template/default/images/icons/view.png" onClick="showbox('ajax/user_details.php?user_id=<?php echo $collaboratore['user_id']?>');return false;"/>
	</form>	
	</div>
	<div style="float:clear;">
	<form method="post" action="customers.php">
	<input type="hidden" name="action" value="modifyClient"/>
	<input type="hidden" name="user_id" value="<?php echo $collaboratore['user_id']?>"/>
	<input type="image" src="template/default/images/icons/edit_gray.png" onClick="alert('Non ancora disponibile - Not yet available');return false;"/></form>
	</div>
	</td></tr>
	<?php 
	} 
} else {
		echo '<tr><td colspan="2" align="center">'.LANG_MANAGER_NO_COLLABORATORS.'</td></tr>';	
	}
?>
</tbody>
</table>


<br/>
<h3><img src="template/default/images/icons/collaborator_add.png"/> <?php echo LANG_MANAGER_NEW_COLLABORATOR_TITLE;?></h3>

<form action="collaborators.php" method="post" enctype="multipart/form-data" name="insertform">
<input type="hidden" name="action" value="insertCollaborator"/>
<table class="insert_table">
	<tbody class="insert_table">
	<tr>
		<td><?php echo LANG_SETTINGS_USER_TITLE;?></td>
		<td><select name="title">
			<option value="<?php echo LANG_TITLE_PEOPLE1?>"><?php echo LANG_TITLE_PEOPLE1?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE2?>"><?php echo LANG_TITLE_PEOPLE2?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE3?>"><?php echo LANG_TITLE_PEOPLE3?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE4?>"><?php echo LANG_TITLE_PEOPLE4?></option>
			<option value="<?php echo LANG_TITLE_PEOPLE5?>"><?php echo LANG_TITLE_PEOPLE5?></option>
			</select></td>
	</tr>
	<tr>
		<td><?php echo LANG_FIRSTNAME;?></td>
		<td><input type="text" size="30" name="firstname"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_LASTNAME;?></td>
		<td><input type="text" size="30" name="lastname"/></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" size="15" name="username" id="username"/> <div id="status" style="display:inline; border: none;"></div></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" size="15" name="password"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_EMAIL;?></td>
		<td><input type="text" size="30" name="email"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_PHONE;?></td>
		<td><input type="text" size="15" name="phone"/> <img src="template/default/images/icons/cellphone.png" alt="" style="border:0px; margin:0px; padding:1px;"/></td>
	</tr>
	<tr>
		<td><?php echo LANG_BIRTHDATE;?></td>
		<td><select name="day">
		<option value=""><?php echo LANG_DAY;?></option>
		<?php 
		for($i=1;$i<=31;$i++) {
			echo '<option value="'.$i.'">'.$i.'</option>';
		}		
		?>
		</select> 
		<select name="month">
			<option value=""><?php echo LANG_MONTH;?></option>
			<option value="1"><?php echo LANG_JANUARY;?></option>
			<option value="2"><?php echo LANG_FEBRUARY;?></option>
			<option value="3"><?php echo LANG_MARCH;?></option>
			<option value="4"><?php echo LANG_APRIL;?></option>
			<option value="5"><?php echo LANG_MAY;?></option>
			<option value="6"><?php echo LANG_JUNE;?></option>
			<option value="7"><?php echo LANG_JULY;?></option>
			<option value="8"><?php echo LANG_AUGUST;?></option>
			<option value="9"><?php echo LANG_SEPTEMBER;?></option>
			<option value="10"><?php echo LANG_OCTOBER;?></option>
			<option value="11"><?php echo LANG_NOVEMBER;?></option>
			<option value="12"><?php echo LANG_DECEMBER;?></option>
		</select> 
		<select name="year">
			<option value=""><?php echo LANG_YEAR;?></option>
			<?php 
				
			for($i=1920;$i<=1990;$i++) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}		
			?>
		</select>
		</td>
	</tr>
    </tbody>
	<tfoot class="insert_table">
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SAVE?>" onClick="return checkForm();"/></td>
	</tr>
    </tfoot>
</table>
</form>
</div>