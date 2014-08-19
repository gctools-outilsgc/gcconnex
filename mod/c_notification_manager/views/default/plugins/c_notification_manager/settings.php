<?php

$c_notify_date = new DateTime();

if (!isset($vars['entity']->pass_is_displayed))
 	$vars['entity']->pass_is_displayed = 'false';
?>

<style type="text/css">
	.elgg-input-password {
		width:100%;
	}
	.elgg-input-text {
		width:100%;
	}
</style>


<div>

<?php

echo '<b>Credentials for CronJob use</b> <br /><br />';
echo 'Username: ' . elgg_view('input/text', array('name' => 'params[c_user]','value' => $vars['entity']->c_user)) . '<br />';
echo 'Password: ' . elgg_view('input/password', array(
	'name' => 'params[c_pass]',
	'value' => $vars['entity']->c_pass,
	'width' => '100%'));

$notice1 = '';
$notice2 = '';

// validate user
if (!user_isValid($vars['entity']->c_user, $vars['entity']->c_pass))
{
	$notice1 = '<br /> CAUTION: User credentials specified does not exist in the system, please provide valid user account before enabling this module <br />';
	echo $notice1;
} else {

	if (!user_isAdmin(user_isValid($vars['entity']->c_user, $vars['entity']->c_pass)))
	{
	 	$notice2 = '<br /> CAUTION: User credentials specified does not have enough privaleges [user does not have admin rights] <br />';
	 	echo $notice2;
	}
}


echo '<br /><br/>';

echo '<b>CronTab[le] Log</b> <br /><br />'; 
echo 'NOTE:CronTab log file is in /c_notification_manager/cronjob_logging.txt <br />'; 

$log_array = array();
exec('tac '. elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", $log_array);
$log_str = "Logging File:\n";

foreach ($log_array as $log)
{
	$log_str = $log_str . $log . "\n";
}

echo "<textarea id=display_cron_log style='resize:none; overflow:scroll; width:100%; height:400px;' readonly='true'> $log_str </textarea>";

echo '<br />';

$flush_log_url = "action/c_notification_manager/flush_logging";
echo elgg_view('output/confirmlink', array(
	'name' => 'c_flush_log',
	'text' => 'Flush Log',
	'href' => $flush_log_url,
	'class' => 'elgg-button'
	));

$purge_all_notifications = "action/c_notification_manager/purge_all_notifications";
echo elgg_view('output/confirmlink', array(
	'name' => 'c_purge_all',
	'text' => 'Purge all notifications',
	'href' => $purge_all_notifications,
	'class' => 'elgg-button'
	));

$purge_all_invalid_notifications = "action/c_notification_manager/purge_all_invalid_notifications";
echo elgg_view('output/confirmlink', array(
	'name' => 'c_purge_invalid',
	'text' => 'Purge all invalid notifications',
	'href' => $purge_all_invalid_notifications,
	'class' => 'elgg-button'
	));

//echo '<br/><br/><b>Comments/Suggestions/Problems or for further development @ internalfire5@live.com</b> <br />'; 
echo '<br />';

?>

</div>