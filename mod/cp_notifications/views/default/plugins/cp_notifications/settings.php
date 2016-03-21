<?php

//echo "hello...";


echo "<br/><br/><br/>";

// TODO: option to bundle up notification
// TODO: manual send out notification
// TODO: option to do cron or limit of x number of notifications

// development purposes (not intended for production)

$user_guid = 124; // sokguan
$plugin = elgg_get_plugin_from_id('cp_notifications');

$options = array(
	'container_guid' => 151, // group test
	'type' => 'object',
	'limit' => false,
);
$grp_items = elgg_get_entities($options);

$notification_setup = "";



foreach ($grp_items as $grp_item) {
	//$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$grp_item->getGUID()}", $user_guid);
	$cpn_set_subscription_email = elgg_get_plugin_user_setting("cpn_email_{$grp_item->getGUID()}", $user_guid, "cp_notifications");
	echo "cpn_set_sub: <strong> {$cpn_set_subscription_email} </strong> @ guid: cpn_email_{$grp_item->getGUID()} <br/>";
}

echo "<br/>Preview - TEMPLATE ONLY: <br/><br/>";
echo "<hr>";

$notification_setup .= "
	<!-- beginning of email template -->
	<table width='100%' bgcolor='#fcfcfc' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	GCconnex - This is an automated email notification - Please do not reply
		        </div>
				

				<!-- GCconnex banner -->
		     	<div width='100%' style='padding: 0 0 0 20px; color:#ffffff; font-family: sans-serif; font-size: 45px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 25px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>


		        <!-- main content of the notification (ENGLISH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        	<!-- The French Follows... -->
	        	<span style='font-size:12px; font-weight: normal;'><i>(Le francais suit)</i></span><br/>
        	   
        	       Thank you for contacting the GCconnex Help desk. This email is sent to you to have a copy of your request. You will receive an acknowledgment of receipt by email shortly. Shouldn’t you receive the acknowledgment of receipt, please contact the GCconnex Help Desk at: gcconnex@tbs-sct.gc.ca.<br/>
                   Thank you
		        </div>


		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:1px solid #f2eeed;'>
		        	
		        	<h2 style='padding: 0px 0px 15px 0px'>Entity Title by Entity Owner Name</h2>

		       		Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. 
		       		Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. 
		       		Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
		        </div>

		        <!-- main content of the notification (FRENCH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>
        	       Merci d\'avoir communiquer avec le bureau de soutien de GCconnex. Ce courriel vous est envoyé afin d’avoir une copie de votre demande dans vos dossiers. Vous recevrez un accusé de réception sous peu. Si vous ne recevez pas cet accusé de réception, prière de communiquer avec le bureau de soutien de GCconnex à l’adresse suivante : gcconnex@tbs-sct.gc.ca<br/>
                   Merci
		        </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:1px solid #f2eeed;'>

		       		<h2 style='padding: 0px 0px 15px 0px'>Entiteh Titre de Entity de Quoi</h2>

		       		Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. 
		       		Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. 
		       		Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <!-- email footer -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	GCconnex - Thanks for contacting us / Merci de nous avoir contacter - Do not Reply / Ne pas repondre
		        </div>

			</td>
		</tr>
	</table>


";



echo $notification_setup;