<?php

$site = elgg_get_site_entity();
$to = $vars['to'];
$language_preference = elgg_get_plugin_user_setting('cpn_set_digest_language', $to->guid, 'cp_notifications');
if (strcmp($language_preference,'set_digest_en') == 0) 
	$language_preference = 'en';
else 
	$language_preference = 'fr';

?>

<html>
	<body style='font-family: sans-serif; color: #055959'>
		<h2><?php echo elgg_echo('cp_newsletter:title:nothing', array(),$language_preference); ?></h2>
    	<sub><center><?php echo elgg_echo('cp_notification:email_header',array(),$language_preference); ?></center></sub>
		<div width='100%' bgcolor='#fcfcfc'>

			<?php // GCconnex notification banner ?>
			<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
				<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'><?php echo $site->name; ?></span>
			</div>

		    <p><?php echo elgg_echo('cp_newsletter:greeting', array($to->name, date("Y/m/d")), $language_preference); ?></strong>.</p>
		    <br/><br/>

			<div><?php echo elgg_echo('cp_newsletter:body:nothing', array(), $language_preference); ?></div>
		    
		    <br/><br/>
		    <?php echo elgg_echo('cp_newsletter:ending', array(), $language_preference); ?>


			<?php // GCconnex notification footer ?>
		    <div width='100%' style='background-color:#f5f5f5; padding:5px 30px 5px 30px; font-family: sans-serif; font-size: 10px; color: #055959'>
		    	<center><p><?php echo elgg_echo('cp_notifications:contact_help_desk', array(), $language_preference); ?></p>
		    	<p><?php echo elgg_echo('cp_newsletter:footer:notification_settings', array($to->username), $language_preference); ?></p></center>	
		    </div>
		</div>
	</body>
</html>

