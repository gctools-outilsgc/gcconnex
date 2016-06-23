
<?php 
    /*
    Display user's message in message format for preview

    Done in jQuery at the moment 
    */
    ?>

<script>
    //Get values from unsubmitted form from page to display
  var body = $('#body').val();
   var subject = $('#subject').val();
   var sender = '<?php echo elgg_get_logged_in_user_entity()->name; ?>';

    //the body
   $('.desc').html(body);

    //the title
   var eng_title = sender + " sent you a site message entitled '" + subject + "'";
   $('.eng-title').html(eng_title);
   var fr_title = sender + " vous a envoy&#233; un message intitul&#233; '" + subject + "'";
   $('.fr-title').html(fr_title);

</script>


<?php
echo <<<___HTML
<html>
<body>
	<!-- beginning of email template -->
	<div width='100%' style="max-width: 1135px" bgcolor='#fcfcfc'>
		<div>
			<div>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>


				<!-- GCconnex banner -->
		     	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

<!-- english -->


		        <!-- main content of the notification (ENGLISH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<!-- The French Follows... -->
	        		<span style='font-size:12px; font-weight: normal;'><i>(<a href="#gcc_fr_suit">Le francais suit</a>)</i></span><br/>

		        </div>



		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>
		        	<!-- TITLE OF CONTENT -->
		        	<h2 class='eng-title' style='padding: 0px 0px 15px 0px; font-family:sans-serif';>
		        		<strong> {$cp_notify_msg_title_en}</strong>
		        	</h2>

		        	<!-- BODY OF CONTENT -->




		        	{$cp_notify_msg_description_en}
                    <p>The content of the message is: </p>
                    <p class="desc"></p>
                    <br><p>You can view or reply to this by clicking on this link:</p>





		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>Should you have any concerns, please use the <a href="https://gcconnex.gc.ca/mod/contactform/">Contact us form</a>.</div>
                    <div>To learn more about GCconnex and its features visit the <a href="http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/See_All">GCconnex User Help</a>.<br/>
	                             Thank you</div>
                </div>


<!-- french -->

		        <!-- main content of the notification (FRENCH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div id="gcc_fr_suit" name="gcc_fr_suit" width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

		        </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>
		       		<!-- TITLE OF CONTENT -->
		       		<h2 class='fr-title' style='padding: 0px 0px 15px 0px; font-family:sans-serif;'>
		       			<strong> {$cp_notify_msg_title_fr} </strong>
		       		</h2>

		       		<!-- BODY OF CONTENT -->



		       		{$cp_notify_msg_description_fr}
                    <p>Le contenu du message est le suivant : </p>
                    <p class="desc"></p>
                    <br><p>Vous pouvez le consulter ou y r&#233;pondre en cliquant sur le lien suivant:</p>




		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                    <div>Si vous avez des questions, veuillez soumettre votre demande via le <a href="https://gcconnex.gc.ca/mod/contactform/">formulaire Contactez-nous</a>.</div>
                    <div>Pour de plus amples renseignements sur GCconnex et ses fonctionnalit&#233;s, consultez l'<a href='http://www.gcpedia.gc.ca/wiki/Aide_%C3%A0_l%27utilisateur/Voir_Tout'>aide &#224; l'utilisateur de GCconnex</a>.<br/>
	                             Merci</div>

                    </div>

		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <!-- email footer -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'>
		        	
		        </div>

			</div>
		</div>
	</div>
</body>
</html>

___HTML;


?>