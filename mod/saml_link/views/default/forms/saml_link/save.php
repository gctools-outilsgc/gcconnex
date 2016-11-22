<?php elgg_load_css('special');?>
<?php 
	$gcuser = htmlspecialchars($_GET["username"]);
	$gcemail = htmlspecialchars($_GET["email"]);
	if (!$gcemail){
		$gcemail=elgg_get_logged_in_user_entity()->email;
	}
?>
<div>
	<?php 
		$connexUser = elgg_get_logged_in_user_entity()->username;
		$connexEmail = elgg_get_logged_in_user_entity()->email;
		echo elgg_echo("link-add:body",array($gcuser,$gcemail,$connexUser,$connexEmail ));
	?>
</div>
<div>
	<?php echo elgg_view('input/hidden',array('name' => 'username', 'value'=> $gcuser, 'class' => 'myClass', 'id' => 'myid')); ?>
	<?php echo elgg_view('input/hidden',array('name' => 'email', 'value'=> $gcemail, 'class' => 'myClass', 'id' => 'myid')); ?>
	<?php echo elgg_view('input/submit', array('id' => 'submit', 'value' => elgg_echo('link-add:button'))); ?>
	<?php echo elgg_view('input/button', array('value' => elgg_echo('link-add:back-button'), 'onclick'=>"window.location.href='".$_SERVER['HTTP_REFERER']."'")); ?>
</div>
<?php
	$user = elgg_get_logged_in_user_entity();
	
	if($user->gedsDN){
		$dn = addslashes($user->gedsDN);
		?>
<script>
	$(document).ready(function(){
		$('#submit').click(function(){
			//alert('test');
			var pushObj = {
            		requestID: 'X03',
            		authorizationID: '<?php echo elgg_get_plugin_setting("auth_key","geds_sync"); ?>',
            		requestSettings:{
            			DN: '<?php echo $dn; ?>',
            			GCpediaUsername: '<?php echo  $gcuser; ?>',
            			GCconnexUsername: '<?php echo $connexUser; ?>'
            		}
            	};
            $.ajax({
            	type: 'POST',
                contentType: "application/json",
                url: 'https://api.sage-geds.gc.ca',
                data: JSON.stringify(pushObj),
                dataType: 'json',
                success: function (feed) {
                	//alert(JSON.stringify(feed));
              	}
            });
		});
	});
</script>
<?php
}
?>