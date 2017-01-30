<?php

$contents = $vars['newsletter_content'];
$language_preference = elgg_get_plugin_user_setting('cpn_set_digest_lang_en', $to_recipient->guid, 'cp_notifications');
//set_digest_en  set_digest_fr
$to = $vars['to'];

if (strlen($content) > 0) {
  $content_en = "<h4><p> New Contents </p></h4> {$content} <br/>";
  $content_fr = "<h4><p> Nouveau contenu </p></h4> {$content} <br/>";
}

?>



<html>
  <body style='font-family: sans-serif; color: #055959'>
    <h2><?php echo elgg_echo('newsletter:title_heading'); ?></h2>
    <sub><center><?php echo elgg_echo('cp_notification:email_header'); ?></center></sub>
    <div width='100%' bgcolor='#fcfcfc'>

      <!-- GCconnex banner -->
      <div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
        <span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
      </div>

      <p>Good morning  <?php echo $to->name; ?>. Here are your notifications for <strong><?php echo date('l\, F jS\, Y '); ?></strong>.</p>

    <?php 
      foreach ($contents as $highlevel_header => $highlevel_contents) {
     ?>

      <div>
        <h3><?php echo render_headers($highlevel_header); ?></h3>
        <ul style='list-style-type:none;'>

        <?php 

        foreach ($highlevel_contents as $detailed_header => $detailed_contents) {
          echo "<li>{$detailed_header}</li>";
          


          foreach ($detailed_contents as $content) {

            if ($highlevel_header === 'group') {
              $group_activities = $content;
              foreach ($group_activities as $activity_heading) {
                echo  "<ul style='list-style-type:none;'><li>{$activity_heading}</li></ul>";
              }

            } else {
              echo  "<ul style='list-style-type:none;'><li>{$content}</li></ul>";
            }
          
          }
        }

        ?>

        </ul>
      </div>

      <?php } ?>

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

      case 'micromission':
        $proper_heading = 'Opportunity (Micro Mission) Notifications';
        break;

      case 'group':
        $proper_heading = 'Group Name Here';
        break;

      default:
        $proper_heading = 'Invalid Heading';
        break;
    }

    return $proper_heading;
  }




