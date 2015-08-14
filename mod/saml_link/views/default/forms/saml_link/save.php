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
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('link-add:button'))); ?>
	<?php echo elgg_view('input/button', array('value' => elgg_echo('link-add:back-button'), 'onclick'=>"window.location.href='".$_SERVER['HTTP_REFERER']."'")); ?>
</div>

