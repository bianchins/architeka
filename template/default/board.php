<div class="column main">
<?php if(!isset($error)) { ?>
 <h2 id="wall"></h2>
  <h4> 
<form method="get" action="board.php">
<?php echo LANG_PROJECT_NAME;?>
<select name="idproject">
<?php foreach($listaProgetti as $progetto) {
	echo ' <option value="'.$progetto['idproject'].'" ';
	if($actualidproject==$progetto['idproject']) echo 'SELECTED="SELECTED"';
	echo '>';
	echo $progetto['project_description'];

	echo '</option>'."\n";
	
} ?>
</select> <input type="submit" name="submit" value="<?php echo LANG_GO?>"/>
</form>

</h4>

 <p id="date"> <?php echo LANG_OF;?> <a href="#"><?php echo $firstname." ".$lastname?></a></p>

<?php
foreach($entries as $entry) {

	?>
<div class="column main entry">

<table id="post">

    <thead id="post">
        <tr>
        	<td>
            <h3><?php echo $entry['author'] ?> </h3>
            </td>
        	<td>
 			<p><?php echo $entry['publish_date'] ?>, <?php echo $entry['publish_time'] ?></p>
            </td>
        </tr>
      </thead>
	<tbody>
	<tr>
		<td valign="top"><img src="avatar.php?name=<?php echo $entry['photo']; ?>.jpg" /></td>
        
		<td>
		<blockquote><span><?php echo $entry['description'] ?></span></blockquote>
		<?php if ($entry['content']!="") echo $entry['content']."<br/>"; ?> 
        <!-- commenti -->
		<div class="comment_box"><?php 
			if($entry['comments_list']!=NULL)
			foreach($entry['comments_list'] as $comment) {
				?>
                
			<div class="comment_post">
				<span class="title_post"><?php echo LANG_COMMENT_OF;?> <a href="#" <?php /*echo $comment['comment_author_id']*/ ?>><?php echo $comment['comment_author'] ?></a></span>
				<span class="data_post"><?php echo LANG_ATTIME;?> <?php echo $comment['comment_time'] ?> <?php echo LANG_OFDAY;?> <?php echo $comment['comment_date'] ?></span>
				<p><span class="content_post"><?php echo $comment['comment_content'] ?></span></p>
			 <?php 
			 if ($comment['comment_author_id']==$user_id) {?>
            <form action="addentry.php" method="post">
            <input type="hidden" name="action" value="delete_comment"/>
            <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']?>"/>
            <input type="submit" value="<?php echo LANG_DELETE_COMMENT;?>" />
            </form>
            <?php } else echo '&nbsp;';?>
			</div>
			<?php } ?>
            
			<div class="comment_post">
			<form action="addentry.php" method="post">
			<input type="hidden" name="comment_entry_id" value="<?php echo $entry['entry_id']?>" /> 
			<input type="hidden" name="action" value="comment" /> 
				<textarea name="comment_content" onFocus="if (this.value=='<?php echo LANG_COMMENT_THIS;?>...') { this.value='';this.style.height='40px';}" onBlur="if (this.value=='') { this.value='<?php echo LANG_COMMENT_THIS;?>...';this.style.height='20px';}" /><?php echo LANG_COMMENT_THIS;?>...</textarea>
			<input type="submit" value="<?php echo LANG_COMMENT_BUTTON;?>" />
			</form>
			</div>
		</div>
		<!-- fine commenti -->
        </td>
	</tr>
    </tbody>
    
    <tfoot id="post">
        <tr>
        	<td colspan="2">
 			<?php if ($entry['author_id']==$user_id) {?>
            <form action="addentry.php" method="post">
            <input type="hidden" name="action" value="delete_entry"/>
            <input type="hidden" name="entry_id" value="<?php echo $entry['entry_id']?>"/>
            <input type="submit" value="<?php echo LANG_DELETE_POST;?>" class="elimin"/>
            </form>
            <?php } else echo '&nbsp;';?>
            </td>
        </tr>
      </tfoot>
    
</table>
</div>
		<?php } ?>
	<p><a href="board.php?viewall=true"><?php echo LANG_SHOW_PAST_ENTRIES;?></a></p>	
		</div>
				
		<?php } else { ?>
<div class="error"><?php echo $error?></div>
<?php } ?>
