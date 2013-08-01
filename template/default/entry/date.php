<?php if(isset($feedback)) {
<div class="column main">

<?php 
if (isset($datiAppuntamento)) {

?>
<h3><?php echo LANG_EVENT_OF.' '.$datiAppuntamento['appointment_date']?></h3>
<div class="menu">
		<table>
		<tr><td><?php echo LANG_EVENT_DESCRIPTION;?>:</td><td><?php echo $datiAppuntamento['appointment_description']?></td></tr>
		<tr><td><?php echo LANG_EVENT_PLACE;?>:</td><td><?php echo $datiAppuntamento['appointment_place']?></td></tr>
		<tr><td><?php echo LANG_EVENT_TIME;?>:</td><td> <?php echo $datiAppuntamento['appointment_time']?></td></tr>
		</table>
</div>
<?php 
 } 
 	echo '<h3>'.LANG_FUTURE_EVENTS_LIST.'</h3>';
 	echo '<div style="text-align:right;margin-bottom:10px;"><form action="date.php?action=ics" method="post"><input type="submit" value="'.LANG_EXPORT_ICS.'"/></form></div>';
 foreach($appointments as $app) {	
 	?>
	<table class="insert_table">
	<thead>
		<tr><td colspan="2"><?php echo $app['appointment_date']?></td></tr>
	</thead>
	<tbody>
	<tr><td width="20%"><?php echo LANG_EVENT_TIME;?>:</td><td><?php echo $app['appointment_time']?></td></tr>
	<tr><td><?php echo LANG_EVENT_DESCRIPTION;?>:</td><td><?php echo $app['appointment_description']?></td></tr>
	<tr><td><?php echo LANG_EVENT_PLACE;?>:</td><td><?php echo $app['appointment_place']?></td></tr>
	</tbody>
	</table>
	<br/><br/>
	<?php 
 } //for
} else {?>
<script type="text/javascript" src="template/javascript/architeka_date.js"></script>
 <h3><?php echo LANG_INSERT_NEW_EVENT;?></h3>
 	<div class="menu">
		<form action="addentry.php" method="post" name="insertForm">
		<input type="hidden" name="action" value="addAppointment" /> 
		<table class="insert_table">
		<tbody>
		<tr><td><?php echo LANG_EVENT_DATE;?>:</td><td><input type="text" name="appointment_date" style="width:90px;display:inline;" id="appointment_date"/></td></tr>
		<tr><td valign="top"><?php echo LANG_EVENT_DESCRIPTION;?>:</td><td> <textarea name="appointment_description" style="width:300px;height:40px"></textarea></td></tr>
		<tr><td><?php echo LANG_EVENT_PLACE;?>:</td><td> <input type="text" name="appointment_place"/></td></tr>
		<tr><td><?php echo LANG_EVENT_TIME;?>:</td><td> 
		<!--<input type="text" style="width:50px;" name="appointment_time"/> -->
		<div id="timepickerDate2"></div></td></tr>
		</tbody>
		<tfoot class="insert_table">
		<tr><td colspan="2"><input type="submit" name="submit" value="<?php echo LANG_SAVE;?>" onClick="return checkForm();"/></td></tr>
		</tfoot>
		</table>
		</form>
	<br/>
	<br/>
	<br/>
	</div>
<?php } ?>

</div>