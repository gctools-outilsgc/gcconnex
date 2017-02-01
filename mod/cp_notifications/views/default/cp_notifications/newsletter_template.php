<?php


$site = elgg_get_site_entity();
$to = $vars['to'];
$contents = $vars['newsletter_content'];

$language_preference_en = elgg_get_plugin_user_setting('cpn_set_digest_lang_en', $to->guid, 'cp_notifications');
if (strcmp($language_preference_en,'set_digest_en') == 0) 
  $language_preference = 'en';

$language_preference_fr = elgg_get_plugin_user_setting('cpn_set_digest_lang_fr', $to->guid, 'cp_notifications');
if (strcmp($language_preference_fr,'set_digest_fr') == 0)
  $language_preference = 'fr';

//see array_count_values
?>


<html>
  <body style='font-family: sans-serif; color: #055959'>
    <h2><?php echo elgg_echo('newsletter:title_heading',array('Something something hello'),$language_preference); ?></h2>
    <sub><center><?php echo elgg_echo('cp_notification:email_header',array(),$language_preference); ?></center></sub>
    <div width='100%' bgcolor='#fcfcfc'>

      <?php // notification GCconnex banner ?>
      <div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
        <span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'><?php echo $site->name; ?></span>
      </div>

      <p><?php echo elgg_echo('newsletter:greeting', array($to->name, date('l\, F jS\, Y ')), $language_preference); ?></strong>.</p>

      
      <?php foreach ($contents as $highlevel_header => $highlevel_contents) { ?>

      <div>
        <?php // display the main headings (group, personal, and micro missions) ?>
        <h3><?php echo render_headers($highlevel_header); ?></h3>
        <ul style='list-style-type:none;'>

        <?php 

        
        // display the main headings (group title or different types of posts such as likes, comments, ...)
        foreach ($highlevel_contents as $detailed_header => $detailed_contents) {
          if (strcmp($highlevel_header,'group') == 0){
            echo "<p><li><strong>".render_headers($detailed_header)."</strong></li>";
          } elseif ($detailed_header === 'friend_request') {
            echo "<p><li><strong><a href='{$site->getURL()}friend_request/{$to->username}'>".sizeof($detailed_contents).' '.render_headers($detailed_header)."</a></strong></li>";
            break;
          } else {
            echo "<p><li><strong>".sizeof($detailed_contents).' '.render_headers($detailed_header)."</strong></li>";
          }
          
          foreach ($detailed_contents as $content_header => $content) {

            // unwrap and display the group content
            if (strcmp($highlevel_header,'group') == 0) {
              echo  "<ul style='list-style-type:none;'><li><strong>".sizeof($content).' '.render_headers($content_header)."</strong></li>";

              $group_activities = $content;
              foreach ($group_activities as $activity_heading) {
                $content_array = json_decode($activity_heading,true);

                echo  "<ul style='list-style-type:none;'><li>".render_contents($content_array)."</li></ul>";
              }

              echo "</ul>";

            } else {
              // unwrap and display the personal content
              $content_array = json_decode($content,true);
              echo  "<ul style='list-style-type:none;'><li>".render_contents($content_array)."</li></ul>";
            }
          }
          echo "</p>";
        }
        

        ?>

        </ul>
      </div>

      <?php } ?>

      <br/><br/>
      <?php echo elgg_echo('newsletter:ending', array(), $language_preference); ?>

      <?php // notification footer ?>
      <div width='100%' style='background-color:#f5f5f5; padding:5px 30px 5px 30px; font-family: sans-serif; font-size: 10px; color: #055959'>
        <center><p><?php echo elgg_echo('newsletter:footer:notification_settings', array(), $language_preference); ?></p>
        <p><?php echo elgg_echo('cp_notify:contactHelpDesk', array(), $language_preference); ?></p> </center>	
      </div>
    </div>
  </body>
</html>






<?php

  /**
   * @param Array <string> $heading
   */
  function render_contents($content_array) {

    $author = "{$content_array['content_author_name']} has posted a ";
    // this is specifically for the Micro Missions portion due to extra field
    $subtype = elgg_echo($content_array['subtype']);
    if ($content_array['deadline']) {
      $closing_date = 'Closing Date : '.$content_array['deadline'];
      $subtype = elgg_echo($subtype);
      $author = '';
    }
    // limit 35 characters
    $rendered_content = "{$author}{$subtype} <a href='{$content_array['content_url']}'>{$content_array['content_title']}</a> {$closing_date}";
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

      case 'likes':
        $proper_heading = 'Users that have liked your content';
        break;

      case 'friend_request':
        $proper_heading = 'Colleague requests';
        break;

      case 'content_revision':
        $proper_heading = 'Contents have been revised';
        break;

      case 'forum_topic':
        $proper_heading = 'Forum Topics';
        break;

      case 'forum_reply':
        $proper_heading = 'Forum Topic Replies';
        break;

      case 'response':
        $proper_heading = 'Response to a content you are subscribed to';
        break;

      default:
        $proper_heading = $heading;
        break;
    }

    return $proper_heading;
  }




