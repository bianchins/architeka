<div class="box">

<h3> <?php echo LANG_INSERT_PHOTO;?></h3>

<form method="post" action="addentry.php" name="insert_comment_form" ENCTYPE="multipart/form-data">
<input type="hidden" name="entry_type" value="1" />
<input type="hidden" name="action" value="addentry" />
<textarea name="entry_description"
	class="field" style="color: #dddddd;"
	onClick="this.style.color='#666666';this.value=''"><?php echo LANG_DESCRIBE_PHOTO;?>...</textarea>
<br />
<input type="file" name="attachment" class="field" style="color: #dddddd; width: 200px;">
<br />
</form>
<button onClick="document.insert_comment_form.submit();"><?php echo LANG_UPLOAD;?></button>
<button class="cancel" onClick="chiudi();"><?php echo LANG_CANCEL;?></button>

</div>