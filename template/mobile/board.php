
<div class="content">
	<h3>Bacheca di <?php echo $project_description;?></h3>
<?php
foreach($entries as $entry) {

	?>
	<div class="entry">
	<?php echo $entry['author'] ?> <span class="dataora"><?php echo $entry['publish_date'] ?>,
		<?php echo $entry['publish_time'] ?></span><br/>
	<blockquote><span><?php echo $entry['description'] ?></span></blockquote>	
	
	<?php if ($entry['content']!="") echo $entry['content']."<br/>"; ?>
	
		<div class="comment_box"><?php 
		if($entry['comments_list']!=NULL)
		foreach($entry['comments_list'] as $comment) {
			?>
		<div class="comment_post"><span class="titolo_post">Commento di <a
			href="profile.php?userid=<?php echo $comment['comment_author_id'] ?>"><?php echo $comment['comment_author'] ?></a></span>
		<span class="datapost">alle <?php echo $comment['comment_time'] ?> del <?php echo $comment['comment_date'] ?></span>
		<p><?php echo $comment['comment_content'] ?></p>
		</div>
		<?php } ?>
	
	<div class="comment_post">
		<form action="addentry.php" method="post"><input type="hidden"
			name="comment_entry_id" value="<?php echo $entry['entry_id']?>" /> <input
			type="hidden" name="action" value="comment" /> Commenta: <input type="text"
			name="comment_content" style="width: 16em; height: 16px;"/>
		<div align="right" style="margin-top: 10px;"><input type="submit"
			value="Commenta" /></div>
		</form>
		</div>
	
		</div>
	</div>
	<?php } ?>
</div>
