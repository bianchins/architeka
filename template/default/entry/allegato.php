<div class="box">
<h3> <?php echo LANG_INSERT_ATTACHMENT;?></h3>
<form method="post" action="addentry.php" name="insert_comment_form" ENCTYPE="multipart/form-data">
<input type="hidden" name="entry_type" value="4" />
<input type="hidden" name="action" value="addentry" />
<textarea name="entry_description"
	class="field" style="color: #393;"
	onClick="this.style.color='#666666';this.value=''"><?php echo LANG_DESCRIBE_ATTACHMENT;?>...</textarea>
<br />
<input type="file" name="attachment" class="field" style="color: #393; width: 200px;"> <?php echo LANG_MAXSIZE;?>: 16MB 
<br />
</form>
<button onClick="document.insert_comment_form.submit();"><?php echo LANG_UPLOAD;?></button>
<button class="cancel" onClick="chiudi();"><?php echo LANG_CANCEL;?></button>

</div>