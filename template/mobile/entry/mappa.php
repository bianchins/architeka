
<div id="corpo-colonna2">
<div style="width: 600px; height: 400px">
<h3>Inserisci un luogo</h3>
<p><input size="60" name="address" id="address" value=""
	type="text"> <input value="Cerca nelle mappe" type="button"
	onClick="showAddress();"></p>
<form method="post" action="addentry.php" name="insert_map_form">
	<input type="hidden" name="entry_content" id="entry_content"/>

	<div id="map_xxx"
		style="width: 500px; height: 250px; border: 1px solid #cccccc;"></div>
	</div>
	<h3>Con il seguente messaggio...</h3>
	<input type="hidden" name="entry_type" value="5" /> <input type="hidden"
		name="action" value="addentry" /> <textarea name="entry_description"
		class="field" style="color: #dddddd;"
		onClick="this.style.color='#666666';this.value=''">Digita qui il tuo messaggio...</textarea>
	<br />
</form>
<button onClick="document.insert_map_form.submit();">Inserisci</button>
<button class="cancel" onClick="location.href='board.php'">Annulla</button>


</div>


<script type="text/javascript">
    
    var map2 = new GMap2(document.getElementById("map_xxx"));
    var geocoder = new GClientGeocoder();
    var marker = new GMarker(new GLatLng(44.054285,12.551022), {draggable: true});

 function load() {
	 if (GBrowserIsCompatible()) {
	        map2.setCenter(new GLatLng(44.054285,12.551022), 13);
	          
	        map2.addOverlay(marker);
		        
	        map2.setUIToDefault();

	  	  GEvent.addListener(marker, "dragend", function() {
	  	       var point = marker.getPoint();
	  		    map2.panTo(point);

	  		    document.getElementById("entry_content").value=point.lat()+','+point.lng();
	  	        });

	      }

    }


 function showAddress() {

	var address = document.getElementById("address").value;
	 
	 geocoder.getLatLng(
     address,
     function(point) {
       if (!point) {
         alert(address + " Indirizzo non trovato!");
       } else {
         map2.setCenter(point, 13);

		 marker.setLatLng(point);
         map2.addOverlay(marker);
         marker.openInfoWindowHtml(address);
         document.getElementById("entry_content").value=point.lat()+','+point.lng();
       }
     }
   );
 }

load();
   
    </script>