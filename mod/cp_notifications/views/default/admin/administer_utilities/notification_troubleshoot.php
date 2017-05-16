<?php

echo elgg_view('cp_notifications/admin_nav');
$title = elgg_echo('Troubleshoot Tool');





?>

<script>
	
$(document).keypress(function(e) {
    if(e.which == 13) {
        // get the username from text box
        user_name = $('#textbox_username').val();
    	elgg.action('cp_notify/retrieve_user_info', {
    		data: {
    			username: user_name
    		},
    		success: function (user_information) {
    			//alert("SUCCESS!");
                $('.user_info').html(user_information.output.userinfo);
    		},
    		error: function () {
    			alert("ERROR!");
    		}
    	});
    }
});

function onclick_link(guid, user_guid) {
    var this_thing = $(this);
    elgg.action('cp_notify/unsubscribe', {
        data: {
            'guid' : guid,
            'user_guid' : user_guid
        },
        success: function(data) {
            $('#item_' + guid).fadeOut();
        }
    });
}

</script>


<?php

$body = "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Display User's personal notifications</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";
			
$body .= "<input type='text' id='textbox_username' name='username'></input>";
$body .= "<div class='user_info'></div>";

$body .= "</div>";
$body .= '</fieldset>';




$query = "SELECT * FROM elggobjects_entity WHERE title LIKE 'Newsletter|%'";
$newsletter_objects = get_data($query);

if (count($newsletter_objects) > 0) {

    $body .= "-STARTING----------------------------------------------------------------------------------------------- <br/>";


    foreach ($newsletter_objects as $newsletter_object) {
        
        $newsletter_title = explode('|', $newsletter_object->title);
        $body .= ">> user guid: {$newsletter_title[1]} <br/>";


        // long term fix for the chracter limit, segregate all the entries into records, retrieve via the user guid
        $newsletter_descriptions = json_decode($newsletter_object->description, true);
        foreach ($newsletter_descriptions as $newsletter_header => $newsletter_contents) {
            $body .= ">>> <h2><strong> {$newsletter_header} </strong></h2> <br/>";

            //if ($newsletter_header !== 'group') {
                foreach ($newsletter_contents as $content_type => $contents) {

                    foreach ($contents as $content_id => $content) {
                        $body .= ">>>> type: {$content_type} // content guid: {$content_id}  <br/>";
                    }
                }
            //}
            //$query = "INSERT INTO notification_digest ( user_guid, entry_type, notification_entry ) VALUES ( {$newsletter_title[1]}, '{$newsletter_header}', 'entry' )";
            //$insert_row = insert_data($query);
        }


        // delete the metadata cpn_newsletter       
        //$user->cpn_newsletter
        //$query = "INSERT INTO notification_digest ( user_guid, digest_content ) VALUES ( {$newsletter_title[1]}, {$newsletter_description} )";
        //$insert_row = insertData();
    }

    $body .= "-FINISH-----------------------------------------------------------------------------------------------<br/>";
}

echo elgg_view_module('main', $title, $body);
