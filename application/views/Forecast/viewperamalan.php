
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Peta Sebaran Lahan Kering Kabupaten Klungkung</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12" id="body-event">
			<div class="panel panel-red">
			
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="col-lg-12">
						<div id="map_canvas" style="width:100%;height:400px;"></div>
						
					</div>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC13xW68lukkKHHL1NRD4LBkVLbC72Zm5o"></script>
<script>
	function initialize() {
	    var map;
	    var bounds = new google.maps.LatLngBounds();
	    var mapOptions = {
	        mapTypeId: 'roadmap',
	        zoom: 11
	    };
	                    
	    // Display a map on the page
	    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	    map.setTilt(45);
	        
	    // Multiple Markers
	    var markers = [
	    	<?php
	    	foreach ($listdesa->result() as $row) {
	    	?>
	    		 ['<?php echo $row->NamaDesa?>', <?php echo $row->Latitude?>,<?php echo $row->Longitude?>],
	    	<?php
	    		}
	    	?>
	       
	    ];
	                        
	    // Info Window Content
	    var infoWindowContent = [
	    	<?php
	    	foreach ($listdesa->result() as $row) {
	    	?>
		        ['<div class="info_content">' +
		        '<h3><a href="#" onclick="showpopup(<?php echo $row->Id?>)"><?php echo $row->NamaDesa?></a></h3>' +
		       '</div>'],
	       <?php
	    		}
	    	?>
	    ];
	        
	    // Display multiple markers on a map
	    var infoWindow = new google.maps.InfoWindow(), marker, i;
	    
	    // Loop through our array of markers & place each one on the map  
	    for( i = 0; i < markers.length; i++ ) {
	        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
	        bounds.extend(position);
	        marker = new google.maps.Marker({
	            position: position,
	            map: map,
	            title: markers[i][0]
	        });
	        
	        // Allow each marker to have an info window    
	        google.maps.event.addListener(marker, 'click', (function(marker, i) {
	            return function() {
	                infoWindow.setContent(infoWindowContent[i][0]);
	                infoWindow.open(map, marker);
	            }
	        })(marker, i));

	        // Automatically center the map fitting all markers on the screen
	        map.fitBounds(bounds);
	    }

	    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
	    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
	        this.setZoom(14);
	        google.maps.event.removeListener(boundsListener);
	    });
	    
}
google.maps.event.addDomListener(window, 'load', initialize);

function showpopup(id) {
    window.open("<?php echo base_url()?>index.php/ForecastHighOrder/viewdetail/"+id, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
}
</script>