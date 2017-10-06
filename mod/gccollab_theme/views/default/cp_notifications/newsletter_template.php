<?php

elgg_load_library('elgg:gc_notification:functions');
$site = elgg_get_site_entity();
$to = $vars['to'];
$contents = $vars['newsletter_content'];


$language_preference = elgg_get_plugin_user_setting('cpn_set_digest_language', $to->guid, 'cp_notifications');
if (strcmp($language_preference,'set_digest_en') == 0) 
  $language_preference = 'en';
else 
  $language_preference = 'fr';


?>


<html>
  <body style='font-family: sans-serif; color: #46246A'>
    <h2><?php echo elgg_echo('cp_newsletter:title',$language_preference); ?></h2>
    <sub><center><?php echo elgg_echo('cp_notification:email_header',array(),$language_preference); ?></center></sub>
    <div width='100%' bgcolor='#fcfcfc'>

      <?php // notification GCconnex banner ?>
      <div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#46246A;'>
        <span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'><?php echo $site->name; ?></span>
      </div>

      <p><?php echo elgg_echo('cp_newsletter:greeting', array($to->name, date("Y/m/d")), $language_preference); ?></p>

      
      <?php foreach ($contents as $highlevel_header => $highlevel_contents) { ?>

      <div>
        <?php // display the main headings (group, personal, and micro missions) ?>
        <?php 

        // determines the singular or plural headings
          $content_size = sizeof($highlevel_contents);
          //echo "<br/>{$content_size}<br/>";
          if ($content_size == 1) {
            foreach ($highlevel_contents as $detailed_header => $detailed_contents) {
              $content_size = sizeof($detailed_contents);
              //echo "<br/>{$content_size}<br/>";
              if ($content_size == 1) {
                foreach ($detailed_contents as $content_header => $content) {
                  $content_size = sizeof($content);
                  //echo "<br/>{$content_size}<br/>";
                  break;
                }
              }
              break;
            }
          }
          //echo ">>>> <br/>{$content_size}<br/> ";
        ?>

        <h3><?php echo render_headers($highlevel_header,'',$language_preference, $content_size); ?></h3>
        <ul style='list-style-type:none;'>

        <?php 

        
        // display the main headings (group title or different types of posts such as likes, comments, ...)
        foreach ($highlevel_contents as $detailed_header => $detailed_contents) {


          if (strcmp($highlevel_header,'group') == 0){
            echo "<p><li><strong>".render_headers($detailed_header,'',$language_preference, sizeof($detailed_contents))."</strong></li>";

          } elseif ($detailed_header === 'friend_request') {
            echo "<p><li><strong><a href='{$site->getURL()}friend_request/{$to->username}?utm_source=notification_digest&utm_medium=email'>".sizeof($detailed_contents).' '.render_headers($detailed_header,'',$language_preference, sizeof($detailed_contents))."</a></strong></li>";
            break;

          } elseif ($detailed_header === 'friend_approved') {
            echo "<p><li><strong><a href='{$site->getURL()}friends/{$to->username}?utm_source=notification_digest&utm_medium=email'>".sizeof($detailed_contents).' '.render_headers($detailed_header,'',$language_preference, sizeof($detailed_contents))."</a></strong></li>";
            break;

          } elseif ($detailed_header === 'new_post' && $highlevel_header === 'mission') {
            echo "<p><li><strong>".sizeof($detailed_contents).' '.render_headers('new_mission','',$language_preference, sizeof($detailed_contents))."</strong></li>";
           
          } else {
            echo "<p><li><strong>".sizeof($detailed_contents).' '.render_headers($detailed_header,'',$language_preference, sizeof($detailed_contents))."</strong></li>";
          }
          $detailed_header = str_replace("\'", '\'', $detailed_header);
          

          foreach ($detailed_contents as $content_header => $content) { // display new_post, response, forum_topic etc

            // unwrap and display the group content
            if (strcmp($highlevel_header,'group') == 0) {
              echo  "<ul style='list-style-type:none;'><li><strong>".sizeof($content).' '.render_headers("new_post_in_group",'',$language_preference, sizeof($content))."</strong></li>";

              $group_activities = $content;
              foreach ($group_activities as $activity_heading) {
                $content_array = json_decode($activity_heading,true);

                echo  "<ul style='list-style-type:none;'><li>".render_contents($content_array,$content_header,$language_preference)."</li></ul>";
              }

              echo "</ul>";

            } else {

              // unwrap and display the personal content
              $content_array = json_decode($content,true);
              echo  "<ul style='list-style-type:none;'><li>".render_contents($content_array,$detailed_header,$language_preference)."</li></ul>";
              
              
            }
          }
          echo "</p>";
        }
        

        ?>

        </ul>
      </div>

      <?php } ?>

      <br/><br/>
      <?php echo elgg_echo('cp_newsletter:ending', array('some username'), $language_preference); ?>

      <?php // notification footer ?>
      <div width='100%' style='background-color:#f5f5f5; padding:5px 30px 5px 30px; font-family: sans-serif; font-size: 10px; color: #46246A'>
        <center><p><?php echo elgg_echo('cp_newsletter:footer:notification_settings', array($to->username), $language_preference); ?></p>
        <p><?php echo elgg_echo('cp_notifications:contact_help_desk', array(), $language_preference); ?></p> </center>	
      </div>
    </div>
  </body>
</html>

