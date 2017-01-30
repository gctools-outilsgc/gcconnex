<?php

$to = $vars['to'];

?>

<html>
	<body style='font-family: sans-serif; color: #055959'>
		<h2>Your GCconnex Digest: Nothing to Report Today</h2>
    	<sub><center>This is a system-generated message from GCconnex. Please do not reply to this message</center></sub>
		<div width='100%' bgcolor='#fcfcfc'>

			<!-- GCconnex banner -->
			<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
				<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
			</div>

		    <p>Good morning  <?php echo $to->name; ?>. Here are your notifications for <strong><?php echo date('l\, F jS\, Y '); ?></strong>.</p>
		    <br/><br/>

			<div>
				It seems that it was quiet today on GCconnex and we have nothing new to report to you
			</div>
		    
		    <br/><br/>
		    <p>Regards,</p> <p>The GCTools Team</p>


			<!-- email footer -->
		    <div width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 10px; color: #055959'>
		    	<center><p>Should you have any concerns, please use the <a href='#'>Contact us form</a>. </p>
		    	<p>To unsubscribe or manage these messages, please login and visit your <a href='http://192.168.0.30/gcconnex/mod/contactform/'> Notification Settings</a>.</p> </center>	
		    </div>
		</div>
	</body>
</html>

