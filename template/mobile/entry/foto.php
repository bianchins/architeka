<div class="box">

<h3> Inserisci Foto</h3>

<form method="post" action="addentry.php" name="insert_comment_form" ENCTYPE="multipart/form-data">
<input type="hidden" name="entry_type" value="1" />
<input type="hidden" name="action" value="addentry" />
<textarea name="entry_description"
	class="field" style="color: #dddddd;"
	onClick="this.style.color='#666666';this.value=''">Digita qui una descrizione dell'immagine...</textarea>
<br />
<input type="file" name="attachment" class="field" style="color: #dddddd; width: 200px;">
<br />
</form>
<button onClick="document.insert_comment_form.submit();">Carica</button>
<button class="cancel" onClick="chiudi();">Annulla</button>

</div>