<?php

$content = $vars['new_content'];
$like = $vars['new_like'];
$comment = $vars['new_comment'];
$mission = $vars['digest_mm_posting'];
$revision = $vars['new_revision'];

if (strlen($content) > 0) {
	$content_en = "<h4><p> New Contents </p></h4> {$content} <br/>";
	$content_fr = "<h4><p> Nouveau contenu </p></h4> {$content} <br/>";
}

if (strlen($like) > 0) {
	$like_en = "<h4><p> New Likes </p></h4> {$like} <br/>";
	$like_fr = "<h4><p> Nouveau activité </p></h4> {$like} <br/>";
}

if (strlen($comment) > 0) {
	$comment_en = "<h4><p> New Comments </p></h4> {$comment} <br/>";
	$comment_fr = "<h4><p> Nouveaux Commentaires </p></h4> {$comment} <br/>";
}

if (strlen($revision) > 0) {
	$revision_en = "<h4><p> Revisions </p></h4> {$revision} <br/>";
	$revision_fr = "<h4><p> Révisions </p></h4> {$revision} <br/>";
}

if (strlen($mission) > 0) {
	$mission_en = "<h4><p> Missions </p></h4> {$mission} <br/>";
	$mission_fr = "<h4><p> Missions </p></h4> {$mission} <br/>";
}



echo <<<___HTML
<html>
	<body>
  <h2>Your GCconnex Digest: 11 New Things Happened on GCconnex</h2>
  <sub>This is a system-generated message from GCconnex. Please do not reply to this message</sub>
	<div width='100%' bgcolor='#fcfcfc'>

	<!-- GCconnex banner -->
	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
	</div>

Good morning Christine
Here are your notifications for October 3rd 2016.

<div>
<h3>Personal Notifications</h3>
  <ul>
    <li>3 likes on your post: Hello World</li>
    <li>John Doe has liked your discussion reply</li>
    <li>2 colleague requests</li>
  </ul>
</div>

<div>
<h3>Opportunity (Micro Mission) Notifications</h3>
  <ul>
    <li>2 Opportunities have been created</li>
    <ul><li>New Opportunity</li></ul>
    <ul><li>New Opportunity</li></ul>
    <ul><li>New Opportunity</li></ul>
  </ul>
</div>

<div>
<h3>Group Notifications</h3>
  <ul>
    <li>Hello World Group Beta</li>
    <ul><li>2 Discussion Topics have been created</li></ul>
      <ul><ul><li>Hello World 1</li></ul></ul>
      <ul><ul><li>Hello World 2</li></ul></ul>
    
		<ul><li>3 Files have been uploaded</li></ul>
      <ul><ul><li>File Alpha 1</li></ul></ul>
      <ul><ul><li>File Alpha 2</li></ul></ul>
    
    <li>Hello World Group Alpha</li>
		<ul><li>3 Files have been uploaded</li></ul>
      <ul><ul><li>File Alpha 1</li></ul></ul>
      <ul><ul><li>File Alpha 2</li></ul></ul>
  </ul>
</div>
The GCTools Team


    <!-- email footer -->
    <div width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 10px; color: #055959'>Should you have any concerns, please use the Contact us form. To unsubscribe or manage these messages, please login and visit your notification settings 	</div>


		</div>
	</body>
</html>

___HTML;




