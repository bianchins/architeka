<div class="box">
<h3>Inserisci Link</h3>
<form method="post" action="addentry.php" name="insert_link_form">
<input type="hidden" name="entry_type" value="2" /> 
<input type="hidden" name="action" value="addentry" /> 
<input type="text" class="field" name="entry_content" style="color: #dddddd; width: 200px;" value="http://" onClick="this.style.color='#666666'"> <br />
<textarea name="entry_description" class="field" style="color: #dddddd;" onClick="this.style.color='#666666';this.value=''">Descrivi questo link...</textarea>
<br />
</form>
<button onClick="document.insert_link_form.submit();">Inserisci</button>
<button class="cancel" onClick="chiudi();">Annulla</button>
</div>