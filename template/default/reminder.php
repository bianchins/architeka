<?php if(isset($feedback)) {
?>
<div id="bouncebox">
<p><b><?php echo LANG_NOTIFY;?></b><?php echo $feedback;?></p>
</div>
<?php 	
}
?>
<div class="column main">
<form action="reminder.php" method="post">
	<input type="hidden" name="action" value="reminder"/>
	<h3><?php echo LANG_FORGOTTEN_PWD_TITLE;?></h3>
	<table class="insert_table">
		<thead class="insert_table"><tr><td colspan="2"><?php echo LANG_FORGOTTEN_PWD_CONTENT;?></td></tr></thead>
		<tbody class="insert_table">
		<tr><td><?php echo LANG_FORGOTTEN_PWD_YOUR_EMAIL;?> </td><td><input type="text" name="email"/></td></tr>
		<tr><td><?php echo LANG_FORGOTTEN_PWD_CAPTCHA;?></td><td> <input type="text" name="code"/> </td></tr>
		<tr><td colspan="2" align="center"><img src="reminder.php?captcha=1"/></td></tr>
		</tbody>
		<tfoot class="insert_table">
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo LANG_SEND_NEW_PASSWORD;?>"/></td>
		</tr>
	    </tfoot>
	</table>
</form>
</div>