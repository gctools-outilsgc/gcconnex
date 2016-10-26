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
	<!-- beginning of email template -->
		<div width='100%' bgcolor='#fcfcfc'>
		<div>
		<div>

		<!-- email header -->
		<div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'> &nbsp; </div>


		<!-- GCconnex banner -->
		<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		</div>


		<!-- email divider -->
		<div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>




		<table cellspacing="0" cellpadding="10" border="1" width="90%" align="center">
			<tr>

				<td width="50%">

				{$content_en}
				{$like_en}
				{$comment_en}
				{$revision_en}
				{$mission_en}

				</td>


				<td width="50%">

				{$content_fr}
				{$like_fr}
				{$comment_fr}
				{$revision_fr}
				{$mission_fr}

				</td>
			</tr>
		</table>




		<!-- email footer -->
		<div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 10px; color: #055959'> GCconnex © 2016 </div>

		</div>
		</div>
		</div>
	</body>
</html>

___HTML;

