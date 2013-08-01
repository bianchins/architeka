<div class="box">
<h3><?php echo LANG_INSERT_MESSAGE;?></h3>
<form method="post" action="addentry.php" name="insert_comment_form">
<input type="hidden" name="entry_type" value="3" /> <input type="hidden"
	name="action" value="addentry" /> <textarea name="entry_description"
	class="field" style="color: #dddddd;"
	onClick="this.style.color='#666666';this.value=''"><?php echo LANG_DIGIT_MESSAGE;?>...</textarea>
<br />
</form>
<button onClick="document.insert_comment_form.submit();"><?php echo LANG_INSERT_BUTTON;?></button>
<button class="cancel" onClick="chiudi();"><?php echo LANG_CANCEL;?></button>
</div>