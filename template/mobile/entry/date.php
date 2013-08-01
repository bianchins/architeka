
<div class="column main">

<?php 
if (isset($datiAppuntamento)) {

?>
<h3>Appuntamento del <?php echo $datiAppuntamento['appointment_date']?></h3>
<div class="menu">
		<table>
		<tr><td>Descrizione Evento:</td><td><?php echo $datiAppuntamento['appointment_description']?></td></tr>
		<tr><td>Luogo Evento:</td><td><?php echo $datiAppuntamento['appointment_place']?></td></tr>
		<tr><td>Ora Evento:</td><td> <?php echo $datiAppuntamento['appointment_time']?></td></tr>
		</table>
</div>
<?php 
 } else if ($action=="list") {
 	echo '<h3>Lista dei futuri incontri</h3>';
 	echo '<div style="text-align:right;margin-bottom:10px;"><form action="date.php?action=ics" method="post"><input type="submit" value="Esporta Calendario ICS"/></form></div>';
 foreach($appointments as $app) {	
 	?>
	<table class="insert_table">
	<thead>
		<tr><td colspan="2"><?php echo $app['appointment_date']?></td></tr>
	</thead>
	<tbody>
	<tr><td width="20%">Ora evento:</td><td><?php echo $app['appointment_time']?></td></tr>
	<tr><td>Descrizione:</td><td><?php echo $app['appointment_description']?></td></tr>
	<tr><td>Luogo:</td><td><?php echo $app['appointment_place']?></td></tr>
	</tbody>
	</table>
	<br/><br/>
	<!-- 
	<div class="eachappointment";>
	<h3><?php echo $app['appointment_date']?></h3>	
 	Ora evento: <?php echo $app['appointment_time']?><br/>
 	Descrizione: <?php echo $app['appointment_description']?><br/>
 	Luogo: <?php echo $app['appointment_place']?><br/>
 	</div>
 	 -->
	<?php 
 }
} else {?>
<script language="JavaScript">
  	/**
  	 * DHTML date validation script for dd/mm/yyyy. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
  	 */
  	// Declaring valid date character, minimum year and maximum year
  	var dtCh= "/";
  	var minYear=1900;
  	var maxYear=2100;

  	function isInteger(s){
  		var i;
  	    for (i = 0; i < s.length; i++){   
  	        // Check that current character is number.
  	        var c = s.charAt(i);
  	        if (((c < "0") || (c > "9"))) return false;
  	    }
  	    // All characters are numbers.
  	    return true;
  	}

  	function stripCharsInBag(s, bag){
  		var i;
  	    var returnString = "";
  	    // Search through string's characters one by one.
  	    // If character is not in bag, append to returnString.
  	    for (i = 0; i < s.length; i++){   
  	        var c = s.charAt(i);
  	        if (bag.indexOf(c) == -1) returnString += c;
  	    }
  	    return returnString;
  	}

  	function daysInFebruary (year){
  		// February has 29 days in any year evenly divisible by four,
  	    // EXCEPT for centurial years which are not also divisible by 400.
  	    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
  	}
  	function DaysArray(n) {
  		for (var i = 1; i <= n; i++) {
  			this[i] = 31
  			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
  			if (i==2) {this[i] = 29}
  	   } 
  	   return this
  	}

  	function isDate(dtStr){
  		var daysInMonth = DaysArray(12)
  		var pos1=dtStr.indexOf(dtCh)
  		var pos2=dtStr.indexOf(dtCh,pos1+1)
  		var strDay=dtStr.substring(0,pos1)
  		var strMonth=dtStr.substring(pos1+1,pos2)
  		var strYear=dtStr.substring(pos2+1)
  		strYr=strYear
  		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
  		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
  		for (var i = 1; i <= 3; i++) {
  			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
  		}
  		month=parseInt(strMonth)
  		day=parseInt(strDay)
  		year=parseInt(strYr)
  		if (pos1==-1 || pos2==-1){
  			return false
  		}
  		if (strMonth.length<1 || month<1 || month>12){
  			return false
  		}
  		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
  			return false
  		}
  		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
  			return false
  		}
  		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
  			return false
  		}
  	return true
  	}

function checkForm()
{
   var cappointment_date, cemail, clastname, cphone;
   with(window.document.insertForm)
   {
      cappointment_date    = appointment_date;
      cappointment_description   = appointment_description;
      cappointment_place = appointment_place;
      cappointment_time = appointment_time;
   }

   if(trim(cappointment_date.value) == '')
   {
      alert('Inserire una data valida');
      cappointment_date.focus();
      return false;
   }
   else if(trim(cappointment_description.value) == '')
   {
      alert('Inserire una descrizione dell\'appuntamento');
      cappointment_description.focus();
      return false;
   }
   else if(trim(cappointment_place.value) == '')
   {
      alert('Inserire un luogo');
      cappointment_place.focus();
      return false;
   }
   else if(trim(cappointment_time.value) == '')
   {
      alert('Inserire l\'ora dell\'appuntamento');
      cappointment_time.focus();
      return false;
   }
   else if(!isDate(cappointment_date.value))
   {
      alert('Inserire una data valida');
      cappointment_date.focus();
      return false;
   }
   else
   {
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}
</script>
 <h3>Inserisci un nuovo appuntamento</h3>
 	<div class="menu">
		<form action="addentry.php" method="post" name="insertForm">
		<input type="hidden" name="action" value="addAppointment" /> 
		<table class="insert_table">
		<tbody>
		<tr><td>Data Evento:</td><td><input type="text" name="appointment_date" id="appointment_date" style="width:90px;display:inline;" class="date-pick"/></td></tr>
		<tr><td valign="top">Descrizione Evento:</td><td> <textarea name="appointment_description" style="width:300px;height:40px"></textarea></td></tr>
		<tr><td>Luogo Evento:</td><td> <input type="text" name="appointment_place"/></td></tr>
		<tr><td>Ora Evento:</td><td> <input type="text" style="width:50px;" name="appointment_time"/></td></tr>
		</tbody>
		<tfoot class="insert_table">
		<tr><td colspan="2"><input type="submit" name="submit" value="Salva" onClick="return checkForm();"/></td></tr>
		</tfoot>
		</table>
		</form>
	<br/>
	<br/>
	<br/>
	</div>
<?php } ?>

</div>
