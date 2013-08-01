<div class="content">


<h3>Home di <?php echo $firstname." ".$lastname?></h3>
<p class="upd_on">Oggi, <?php echo date("l d F Y"); ?></p>
<h3>Progetti attivi</h3>
<div class="menu">
<?php
foreach($projectList as $project) {
	?>
<div class="descrip"><a
	href="board.php?idproject=<?php echo $project['idproject']?>"><img
	src="template/default/images/icons/tables.gif" align="absmiddle" border="0" />
	<?php echo $project['project_description']?></a>, cliente <?php echo $project['firstname']." ".$project['lastname']?><br />
</div>
	<?php } ?>
</div>

<hr />
</div>
