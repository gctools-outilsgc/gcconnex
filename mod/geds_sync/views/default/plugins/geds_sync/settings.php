<?php
	$checkdn = $_GET['getDn'];
	$checkpush = $_GET['push'];
	$userEntites = elgg_get_entities_from_metadata(array( 
			'type' => 'user',
			'limit' => 0,
			'metadata_names' => 'orgStruct'
		));
	
?>

<?php

echo "<div>";
echo elgg_echo("geds_sync:setting:url");
echo elgg_view("input/text", array(
    'name' => 'params[geds_url]',
    'value' => $vars['entity']->geds_url,
    ));
    
echo elgg_echo("geds_sync:setting:auth_key");
echo elgg_view("input/text", array(
    'name' => 'params[auth_key]',
    'value' => $vars['entity']->auth_key,
    ));
    
echo elgg_echo("geds_sync:setting:map_key");
echo elgg_view("input/text", array(
    'name' => 'params[map_key]',
    'value' => $vars['entity']->map_key,
    ));
echo "</div>";

?>

<div>
  Number of users sync'ed with geds: <b><?php echo count($userEntites); ?></b></br></br>
  Get all geds profile dn's</br>
  *warning may cause high load on both ends.</br></br>
  
  <button class="confirmGetDn" type="button">GET All</button>

</div>
</br></br></br>
<div>
  Push all geds sync'd profiles to GEDS.</br>
  *warning may cause high load on both ends.</br></br>
  
  <button class="confirmPush" type="button">Push All</button>

</div>
<script>
	$(function() {
		//$('.elgg-foot').empty();
    	$('.confirmGetDn').click(function(e) {
        	e.preventDefault();
        	if (window.confirm("Are you sure?")) {
            	window.location.href = "?getDn=yes";
        	}
    	});
	});
</script>

<?php
	
	if($checkdn == 'yes'){
		
	
	
		foreach ($userEntites as $entity){
			$user = get_user($entity->guid);
			?>
				<script>
					$(function() {
						var userEmail = '<?php echo $user->email; ?>';
						var searchObj = "{\"requestID\" : \"S02\", \"authorizationID\" : \"X4GCCONNEX\", \"requestSettings\" : {\"searchValue\" : \""+userEmail+"\", \"searchField\":\"7\", \"searchCriterion\":\"2\"} }";
            
						$.ajax({
							type: 'POST',
                			contentType: "application/json",
                			url: 'https://api.sage-geds.gc.ca',
                			data: searchObj,
                			dataType: 'json',
                			success: function (feed) { // feed - JS object - GEDS result
                				if(feed.requestResults.personList[0].dn){
                					elgg.action('geds_sync/saveGEDSProfile', { //target
                						data: {
                							guid: '<?php echo $user->guid; ?>',
                    						gedsDN: feed.requestResults.personList[0].dn
                						},
                						success: function() {
                    						//close the modal
                    						//window.location.replace(window.location.href); //reload page so user can see changes
                						}
            						});
                				}
                			}
                
						});
					});
				</script>
			<?php
		}
	}
?>

<script>
	$(function() {
		//$('.elgg-foot').empty();
    	$('.confirmPush').click(function(e) {
        	e.preventDefault();
        	if (window.confirm("Are you sure?")) {
            	window.location.href = "?push=yes";
        	}
    	});
	});
</script>

<?php
	//$checkpush = $_GET['push'];
	if($checkpush == 'yes'){
		
	
	
	foreach ($userEntites as $entity){
		$user = get_user($entity->guid);
		$obj = elgg_get_entities(array(
     		'type' => 'object',
     		'subtype' => 'gcpedia_account',
     		'owner_guid' => $user->guid
			));
		?>
			<script>
			$(function() {
				var dn = '<?php echo addslashes($user->gedsDN); ?>';
				var gcpediaUser = '<?php echo $obj[0]->title; ?>';
				var gcconnexUser = '<?php echo $user->username; ?>';
				//alert(dn+' '+gcpediaUser+' '+gcconnexUser);
				if (!gcpediaUser){
           			var pushObj = {
            			requestID: 'X03',
            			authorizationID: 'X4GCCONNEX',
            			requestSettings:{
            				DN: feed.dn,
            				//GCpediaUsername: gcpUname,
            				GCconnexUsername: gccUname
            			}
            		};
           		}else{
           			var pushObj = {
            			requestID: 'X03',
            			authorizationID: 'X4GCCONNEX',
            			requestSettings:{
            				DN: feed.dn,
            				GCpediaUsername: gcpUname,
            				GCconnexUsername: gccUname
            			}
            		};
           		}
				//alert(JSON.stringify(pushObj));
				$.ajax({
					type: 'POST',
                	contentType: "application/json",
                	url: 'https://api.sage-geds.gc.ca',
                	data: JSON.stringify(pushObj),
                	dataType: 'json',
                	success: function (feed) {
                		//alert(JSON.stringify(feed));
                		if(feed.result != 0){
                			$('.errortable').append('<tr><td>'+dn+'</td><td>'+GCpediaUsername+'</td><td>'+GCconnexUsername+'</td></tr>');
                		}
                	},
                	error: function(request, status, error) { 
                    	//do nothing - could be used for debugging
                    	//alert(JSON.stringify(request)+' '+status+' '+error);
                	}

				});
			});
				
			</script>
		<?php
	}
}
?>
</br></br>
errors
<table class='errortable' >
	<tr><th>dn</th><th>gcpedia username</th><th>gcconnex</th></tr>
</table>

</br></br>
