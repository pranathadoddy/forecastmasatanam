<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC13xW68lukkKHHL1NRD4LBkVLbC72Zm5o&callback=initialize"></script>
<script>
	var marker, myCircle, map;
 	
 	var myLatLng = {lat: <?php echo $desa->Latitude?>, lng: <?php echo $desa->Longitude?>};
    function initialize() {
        var mapOptions = {
        zoom: 11,
        // Center di kantor kabupaten kudus
        center: new google.maps.LatLng(myLatLng)
        };
 
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
 
 		marker = new google.maps.Marker({
		    position: myLatLng,
		    map: map,
		    title: 'Hello World!',
		    draggable:true
		  });
        // Add a listener for the click event
         google.maps.event.addListener(map, 'click', function(event){
          addMarker(event.latLng);
          var lat = event.latLng.lat();
	        var lng = event.latLng.lng();
	        $('#lat').val(lat);
	        $('#long').val(lng);
        });


         // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
    }

    function addMarker(latLng){       
        //clear the previous marker and circle.
        if(marker != null){
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: latLng,
            map: map,
            draggable:true
        });

        
        //circle options.
        
    }

</script>
<style>
	.controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
</style>
<form id="desaMaintenance" role="form">
	<div class="panel panel-red">
		<div class="panel-heading">
			Detail Desa
		</div>
		<input type="hidden" name="iddesa" value="<?php echo $desa->Id?>">
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Nama Desa</label>
						<input class="form-control" name="namadesa" id="namadesa" value="<?php echo $desa->NamaDesa?>" >
					</div>
					<div class="form-group">
						<label>Longitude</label>
						<input class="form-control" name="long" id="long" value="<?php echo $desa->Longitude?>">
					</div>
					<div class="form-group">
						<label>Latitude</label>
						<input class="form-control" name="lat" id="lat" value="<?php echo $desa->Latitude?>">
					</div>
					<div class="form-group">
						<input id="pac-input" class="controls" type="text" placeholder="Search Box">
						<div id="map-canvas" style="width:100%;height:400px;"></div>
					</div>
				
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button type="submit" id="btn-submit" class="btn btn-red">Simpan</button>
					<button type="reset" class="btn btn-default" onclick="closeMaintenanceWindow()">Kembali</button>
				</div>
			</div>
		</div>

	</div>

</form>

<script type="text/javascript">
	$("#desaMaintenance").submit(function(e){
		e.preventDefault();
		var form=$("#desaMaintenance")[0];
		var formData=new FormData(form);
		waitingDialog.show();
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>/index.php/Desa/updatedesa",
			data:formData,
			contentType: false,
			processData: false,
			success:function(data){
				waitingDialog.hide();
				location.reload();
			},
			error: function(xhr, status, error) {
				waitingDialog.hide();
				alert("error"+xhr.responseText);
			}
		});

	});

	function closeMaintenanceWindow(){
		$("#maintenance-pane").empty();
	}

</script>