<?php
	/*
	* location.php
	* This file adds the location and pop out modal window showing the users address
	*
	*
	*/

	$owner = elgg_get_page_owner_entity();
	//if the user doesnt have address metadata on their profile do nothing and end file
	if (!$owner->addressString){
		return;
	}
	//get the appropriate address string for the language
	if (get_current_language()!='fr'){
		$loc = json_decode($owner->addressString);
	}else{
		$loc = json_decode($owner->addressStringFr);
	}
	
?>
<script type="text/javascript">
	//safe to assume location details exist at this point
  	$(document).ready(function () {
  		//data-toggle="modal" data-target="#gedsProfile"
  		$('.gcconnex-profile-contact-info').append("<img class='profile-icons profile-detail-icon' src='<?php echo elgg_get_site_url(); ?>/mod/geds_sync/vendors/pin56.png' />");
  		$('.gcconnex-profile-contact-info').append("<a data-toggle='modal' href='#locMap'><?php echo $loc->street; ?>, <?php echo $loc->city; ?> <?php echo $loc->province; ?></a></br>");
  		//when modal opens, a call must be made to rezise the map. so on modal shown
  		$('#locMap').on('shown.bs.modal', function (e) {
 			resizeMap();
		});
  	});
</script>
<script>
//ripped more or less stright from google examples
var map;
var geocoder;
function initMap() {
  var myLatLng = {lat: -25.363, lng: 131.044};//starting point
  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: myLatLng
  });
  //find lat long of users address. center map and place marker.
  geocoder.geocode( { 'address': "<?php echo $loc->street.', '.$loc->city; ?>"}, function(results, status) {
  		if (status == google.maps.GeocoderStatus.OK) {
        	map.setCenter(results[0].geometry.location);
        	var marker = new google.maps.Marker({
            	map: map,
            	position: results[0].geometry.location
        	});
      	} else {
        	alert("Geocode was not successful for the following reason: " + status);
      	}
  });


}
//if map is not rezied when modal opens, appears as grey box
function resizeMap(){
	var center = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(center);
}
    </script>
    <!-- needed for google map call. key is under my (Troy Lawson) gmail account -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo elgg_get_plugin_setting('map_key','geds_sync');;?>&signed_in=true&callback=initMap"></script>

<div class="modal" id="locMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog dialog-box">
        <div class="panel panel-custom">
            <div class="panel-heading">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			<div class="modal-title" id="title"><h2><?php echo elgg_echo('geds:map:title'); ?></h2></div>
    		</div>
   			<div class="panel-body" id='mapBody'>
   				<div id='addressBlock'>
   					<?php
   						//show address block
   						if ($loc->street)
   							echo $loc->street.",</br>";
   						if ($loc->city)
   							echo $loc->city.", ";
   						if($loc->province)
   							echo $loc->province.",";
   						if($loc->pc)
   							echo $loc->pc."</br>";
   						//echo .",</br>";
   						if($loc->country)
   							echo $loc->country."</br>";
   						if($loc->building)
   							echo $loc->building."</br>";
   						if($loc->floor)
   							echo elgg_echo('geds:floor')." ".$loc->floor."</br>";

   					?>
   				</div>
   				<!-- empty div - will be filled with map-->
   				<div id="map"></div>

   	 		</div>
       

    	</div>
            <div class="panel-footer">
                <!--Is this you?-->
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo elgg_echo('geds:cancel'); ?> </button> 
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
