<?php if(isset($feedback)) {
?>
<div id="bouncebox">
<p><b><?php echo LANG_NOTIFY;?>: </b><?php echo $feedback;?></p>
</div>
<?php 	
}
?>
<div class="column main">

<?php if($showFormModifyProject) {?>
	<form action="manager.php" method="post">
	<input type="hidden" name="action" value="saveClientsProject"/>
	<input type="hidden" name="idproject" value="<?php echo $idproject;?>"/>
	<table class="insert_table">
	<thead class="insert_table"><tr><td colspan="2"><?php echo LANG_MANAGER_ADD_CUSTOMER_TITLE;?>: <?php echo $nomeProgetto?></td></tr></thead>
	<tbody class="insert_table">
	<?php 
	if (sizeof($listaUtenti)>0) {
		foreach ($listaUtenti as $cliente) { ?>
		<tr><td><input type="checkbox" name="clients[]" id="cli_<?php echo $cliente['user_id']?>" value="<?php echo $cliente['user_id']?>"<?php if(in_array($cliente['user_id'], $listaClienti)) { echo "CHECKED"; }?> /></td><td><label for="cli_<?php echo $cliente['user_id']?>"><?php echo $cliente['firstname']." ".$cliente['lastname']?></label></td></tr>
		<?php 
		} 
	} else {
		echo '<tr><td colspan="2" align="center">'.LANG_MANAGER_NO_CUSTOMER.'</td></tr>';	
	}
	?>
	</tbody>
	<tfoot class="insert_table">
	<tr>
		<td colspan="2" align="center">
		<?php if (sizeof($listaUtenti)>0) {?>
		<input type="submit" name="submit" value="<?php echo LANG_SAVE;?>"/>
		<?php } ?>
		</td>
	</tr>
    </tfoot>
	</table>
	</form>
<?php } else if($showFormModifyCollaboratorProject) { ?>
	<form action="manager.php" method="post">
	<input type="hidden" name="action" value="saveCollaboratorsProject"/>
	<input type="hidden" name="idproject" value="<?php echo $idproject;?>"/>
	<table class="insert_table">
	<thead class="insert_table"><tr><td colspan="2"><?php echo LANG_MANAGER_ADD_COLLABORATOR_TITLE;?>: <?php echo $nomeProgetto?></td></tr></thead>
	<tbody class="insert_table">
	<?php 
	if (sizeof($listaCollaboratori)>0) {
		foreach ($listaCollaboratori as $collaboratore) { ?>
		<tr><td><input type="checkbox" name="collaborators[]" id="col_<?php echo $collaboratore['user_id']?>" value="<?php echo $collaboratore['user_id']?>"<?php if(in_array($collaboratore['user_id'], $listaCollaboratoriAlProgetto)) { echo "CHECKED"; }?> /></td><td><label for="col_<?php echo $collaboratore['user_id']?>"><?php echo $collaboratore['firstname']." ".$collaboratore['lastname']?></label></td></tr>
		<?php 
		} 
	} else {
		echo '<tr><td colspan="2" align="center">'.LANG_MANAGER_NO_COLLABORATOR.'</td></tr>';	
	}
	?>
	</tbody>
	<tfoot class="insert_table">
	<tr>
		<td colspan="2" align="center">
		<?php if (sizeof($listaCollaboratori)>0) {?>
		<input type="submit" name="submit" value="<?php echo LANG_SAVE;?>"/>
		<?php } ?>
		</td>
	</tr>
    </tfoot>
	</table>
	</form>
<?php } else { ?>
<script language="JavaScript">
function checkNewProject() {
	if(window.document.newproject.project_description.value=='') {
		alert('<?php echo LANG_MANAGER_PROJECT_MUST_HAVE_NAME;?>');
		window.document.newproject.project_description.focus();
		return false;
	}
	return true;
}
</script>
<!-- Lista Progetti -->
<h3><img src="template/default/images/icons/tables.gif"/> <?php echo LANG_MANAGER_PROJECT_NUMBER_TITLE1;/*.$this->registry->get('user')->getProjectLimit().LANG_MANAGER_PROJECT_NUMBER_TITLE2;*/?> </h3>
<table class="insert_table">
<thead><tr><td><?php echo LANG_PROJECT_NAME;?></td><td style="width:130px;"><?php echo LANG_MANAGER_ACTIONS;?></td></tr></thead>
<tbody>
<?php 
if(sizeof($listaProgetti)>0) {
	foreach ($listaProgetti as $progetto) {?>
	<tr><td><?php echo $progetto['project_description']; ?>
	<?php 
		if($progetto['clienti']>0) echo ' ( '.LANG_MANAGER_NUM_CUSTOMERS.': '.$progetto['clienti'].')'; 
		//if($progetto['collaboratori']>0) echo ' ( '.LANG_MANAGER_NUM_COLLABORATORS.': '.$progetto['collaboratori'].')';
		else echo ' <a href="manager.php?action=modifyProject&idproject='.$progetto['idproject'].'"><span style="color:red;">'.LANG_MANAGER_NO_CUSTOMER_CLICK_HERE.'</span></a>';
	?>
	</td><td class="operazioni">
	<a href="manager.php?action=modifyProject&idproject=<?php echo $progetto['idproject'];?>" title="<?php echo LANG_MANAGER_USER_PROJECT_RELATION_MODIFY;?>"><img style="padding:3px; border:1px solid #ccc;" src="template/default/images/icons/customer_add.png"/></a>
	<a href="manager.php?action=modifyProjectCustomer&idproject=<?php echo $progetto['idproject'];?>" title="<?php echo LANG_MANAGER_COLLABORATOR_PROJECT_RELATION_MODIFY;?>"><img style="padding:3px; border:1px solid #ccc;" src="template/default/images/icons/collaborator_add.png"/></a>
	<a href="manager.php?action=storeProject&idproject=<?php echo $progetto['idproject'];?>" title="<?php echo LANG_MANAGER_PROJECT_STORE;?>" onClick="alert('Non ancora disponibile - Not yet available');return false;"><img style="padding:3px; border:1px solid #ccc;" src="template/default/images/icons/lock.png"/></a>
	<a href="manager.php?action=deleteProject&idproject=<?php echo $progetto['idproject'];?>" title="<?php echo LANG_MANAGER_PROJECT_DELETE;?>" onClick="return confirm('<?php echo LANG_MANAGER_PROJECT_DELETE_QUESTION?>');"><img style="padding:3px; border:1px solid #ccc;" src="template/default/images/icons/page_cross.gif"/></a>
	</td></tr>
	<?php 
	} 
} else {
		echo '<tr><td colspan="2" align="center">'.LANG_MANAGER_NO_PROJECT.'</td></tr>';	
	}

?>
</tbody>
<tfoot class="insert_table">
<tr><td colspan="2"><?php echo LANG_MANAGER_PROJECT_HELP1;?> <a href="mailto:info@architeka.it?subject=<?php echo LANG_MANAGER_HELP_PROJECT_ID;?>: <?php echo $progetto['idproject'];?>"><?php echo LANG_MANAGER_HELP_CONTACT_US;?></a> <?php echo LANG_MANAGER_HELP_SOON;?></td></tr>
</tfoot>
</table>

<br/>

<h3><?php echo LANG_MANAGER_NEW_PROJECT;?></h3>

<form action="manager.php" method="post" name="newproject" enctype="multipart/form-data">
<input type="hidden" name="action" value="insertProject"/>
<table class="insert_table">
	<tbody class="insert_table">
	<tr>
		<td><?php echo LANG_PROJECT_DESCRIPTION;?></td>
		<td><input type="text" size="30" name="project_description"/></td>
	</tr>
	
	<tr>
		<td><?php echo LANG_MANAGER_PLACE_PROJECT;?></td>
		<td>
		<select name="project_comune">
		<?php 
		foreach($comuni as $comune) {
			echo '<option value="'.$comune['istat_num'].'">'.$comune['denominazione'].' ('.$comune['sigla'].')</option>';	
		}
		?>
		</select>
		</td>
	</tr>
	<tr><td><?php echo LANG_MANAGER_NO_ITALY;?></td>
	<td><input type="checkbox" name="othercountry"/>
	</td>
	</tr>
    </tbody>
    <tfoot class="insert_table">
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SAVE;?>" onClick="return checkNewProject();"/></td>
	</tr>
    </tfoot>
</table>
</form>

<?php } ?>

</div>