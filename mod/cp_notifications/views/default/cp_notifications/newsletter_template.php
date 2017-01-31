<?php

gatekeeper();
$site = elgg_get_site_entity();
$to = $vars['to'];
$contents = $vars['newsletter_content'];
$language_preference = elgg_get_plugin_user_setting('cpn_set_digest_lang_en', $to_recipient->guid, 'cp_notifications');
$contact_us = "{$site->getURL()}mod/contactform/";
$notifications_settings = "{$site->getURL()}settings/plugin/{$to->username}/cp_notifications";

$language_preference = (strcmp($language_preference,'set_digest_en') == 0) ? 'en' : 'fr';


?>


<html>
  <body style='font-family: sans-serif; color: #055959'>
    <h2><?php echo elgg_echo('newsletter:title_heading',$language_preference); ?></h2>
    <sub><center><?php echo elgg_echo('cp_notification:email_header',$language_preference); ?></center></sub>
    <div width='100%' bgcolor='#fcfcfc'>

      <?php // notification GCconnex banner ?>
      <div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
        <span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'><?php echo $site->name ?></span>
      </div>

      <p>Good morning  <?php echo $to->name; ?>. Here are your notifications for <strong><?php echo date('l\, F jS\, Y '); ?></strong>.</p>

      
      <?php foreach ($contents as $highlevel_header => $highlevel_contents) { ?>

      <div>
        <?php // display the main headings (group, personal, and micro missions) ?>
        <h3><?php echo render_headers($highlevel_header); ?></h3>
        <ul style='list-style-type:none;'>

        <?php 

        // display the main headings (group title or different types of posts such as likes, comments, ...)
        foreach ($highlevel_contents as $detailed_header => $detailed_contents) {
          echo "<li><strong>".render_headers($detailed_header)."</strong></li>";
          
          foreach ($detailed_contents as $content) {

            // unwrap and display the group content
            if (strcmp($highlevel_header,'group') == 0) {

              $group_activities = $content;
              foreach ($group_activities as $activity_heading) {
                $content_array = json_decode($activity_heading,true);
                echo  "<ul style='list-style-type:none;'><li>{$content_array['subtype']}:{$content_array['content_title']}:{$content_array['content_url']}</li></ul>";
              }


            } else {
              // unwrap and display the personal content

              $content_array = json_decode($content,true);
              echo  "<ul style='list-style-type:none;'><li>{$content_array['subtype']}:{$content_array['content_title']}:{$content_array['content_url']}</li></ul>";
            }

          }
        }

        ?>

        </ul>
      </div>

      <?php } ?>

      <br/><br/>
      <p>Regards,</p> <p>The GCTools Team</p>

      <?php // notification footer ?>
      <div width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 10px; color: #055959'>
        <center><p>Should you have any concerns, please use the <a href='<?php echo $contact_us ?>'>Contact us form</a>. </p>
        <p>To unsubscribe or manage these messages, please login and visit your <a href='<?php echo $notifications_settings ?>'> Notification Settings</a>.</p> </center>	
      </div>
    </div>
  </body>
</html>






<?php

  /**
   * @param Array <string> $heading
   */
  function render_contents($heading) {

    $rendered_content = $heading;
    if ($heading)

    return $rendered_content;
  }


  /**
   * @param string  $heading
   *
   */
  function render_headers($heading) {

    $proper_heading = '';

    switch ($heading) {
      case 'personal':
        $proper_heading = 'Personal Notifications';
        break;

      case 'mission':
        $proper_heading = 'Opportunity (Micro Mission) Notifications';
        break;

      case 'group':
        $proper_heading = 'Group Notifications';
        break;

      case 'new_post':
        $proper_heading = 'New content posted by your colleagues';
        break;

      case 'cp_wire_share':
        $proper_heading = 'Contents that have been shared';
        break;

      default:
        $proper_heading = $heading;
        break;
    }

    return $proper_heading;
  }




