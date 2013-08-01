<div class="box">
<h3>Inserisci Messaggio</h3>
<form method="post" action="addentry.php" name="insert_comment_form">
<input type="hidden" name="entry_type" value="3" /> <input type="hidden"
	name="action" value="addentry" /> <textarea name="entry_description"
	class="field" style="color: #dddddd;"
	onClick="this.style.color='#666666';this.value=''">Digita qui il tuo messaggio...</textarea>
<br />
</form>
<button onClick="document.insert_comment_form.submit();">Inserisci</button>
<button class="cancel" onClick="chiudi();">Annulla</button>
</div>