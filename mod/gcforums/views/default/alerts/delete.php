<?php

$entity = $vars['entity'];
$delete_title = "Deletion Notice";
$delete_content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce faucibus nec dolor ullamcorper tempus. Nunc vel efficitur est. Curabitur sed eleifend neque. Aliquam vehicula mollis augue ac sodales. Vestibulum mollis ipsum eget diam accumsan condimentum. Etiam nec metus volutpat nibh porttitor egestas in at orci. Vestibulum in ultricies orci. Suspendisse potenti. Curabitur ultrices neque egestas, faucibus leo sed, vehicula eros. Aliquam convallis vehicula leo id maximus. Suspendisse maximus dictum ligula vitae venenatis. Mauris rhoncus arcu ultrices nibh fermentum, porttitor cursus orci rutrum. Suspendisse quis dignissim lacus. Phasellus viverra ullamcorper odio, id imperdiet nunc suscipit quis.";
$delete_button = "Delete";

elgg_view('output/url', array('is_action' => TRUE));
elgg_view('input/securitytoken');
$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$entity->getGUID()}");
$delete = "<a href='{$url}'>Delete</a>";

?>


<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal"><?php echo $delete_button ?></button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		    	<h4 class="modal-title"><?php echo $delete_title; ?></h4>
		    </div>
		  	<div class="modal-body">
			    <p><?php echo $delete_content; ?></p>
			    <p><?php echo $delete; ?></p>
		    </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<style>

.modal {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	z-index: 99; /* Sit on top */
	left: 0;
	top: 0;
	width: 100%; /* Full width */
	height: 100%; /* Full height */
	overflow: auto; /* Enable scroll if needed */
	background-color: rgb(0,0,0); /* Fallback color */
	background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
</style>

