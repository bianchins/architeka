<div class="box">
<h3> <?php echo LANG_INSERT_LINK;?></h3>
<form method="post" action="addentry.php" name="insert_link_form">
<input type="hidden" name="entry_type" value="2" /> 
<input type="hidden" name="action" value="addentry" /> 
<input type="text" class="field" name="entry_content" style="color: #dddddd; width: 200px;" value="http://" onClick="this.style.color='#666666'"> <br />
<textarea name="entry_description" class="field" style="color: #dddddd;" onClick="this.style.color='#666666';this.value=''"><?php echo LANG_DESCRIBE_LINK;?>...</textarea>
<br />
</form>
<button onClick="document.insert_link_form.submit();"><?php echo LANG_INSERT_BUTTON;?></button>
<button class="cancel" onClick="chiudi();"><?php echo LANG_CANCEL;?></button>
</div>