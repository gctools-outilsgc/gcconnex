<?php
/**
 * Compose message form
 *
 * @package ElggMessages
 * @uses $vars['$recipient_username']
 * @uses $vars['subject']
 * @uses $vars['body']
 */

if ($_GET['collection']){ // if it's from collection, create a list of recipient
	$collection_id = $_GET['collection'];
	$members = get_members_of_access_collection($collection_id, true);


	foreach ($members as $member) {
		$user = get_user($member);
		$recipient_username .= $user->username.',';
	}

	$recipient_username_list = rtrim($recipient_username, ',');

}else{
	$recipient_username = elgg_extract('recipient_username', $vars, '');
}


$subject = elgg_extract('subject', $vars, '');
$body = elgg_extract('body', $vars, '');

$recipient_autocomplete = elgg_view('input/autocomplete', array(
	'name' => 'recipient_username',
    'id' => 'recipient_username',
	'value' => $recipient_username_list,
	'match_on' => array('friends'),
));

$content = get_user_access_collections(elgg_get_logged_in_user_guid());
?>

<div class="mrgn-bttm-md">
	<label for="recipient_username"><?php echo elgg_echo("colleague_circle_checkbox"); ?>: </label>
	<input id='colleagueCircle' name='colleagueCircle' type='checkbox' value=true <?php if ($collection_id){ echo ' checked="checked"'; } ?> >

</div>

<div class="mrgn-bttm-md" id="circlecolleague_section" name="circlecolleague_section">
		
<ul>	
<?php 
echo '</ul>'; //list of colleague circle + radiobox
echo '<select class="form-control" id="messageCollection" name="messageCollection">
	<option value="">---</option>';
	
foreach ($content as $key => $collection) {
	$collections = get_members_of_access_collection($collection->id, true);
	echo "<option value=";
	$coll_members = array();

	foreach ($collections as $key => $value) {
		$name = get_user($value);
		$coll_members[] = $name->name;
	}

	echo implode(',', $coll_members);
		
	if ($collection->id == $collection_id){
		echo ' selected="selected"';
	}

	echo"> ";
	echo ' '.$collection->name.'</option>';
	echo '<br>';
	}
echo '</select>';
echo $vars['collection'];


?>

</div>
<div class="mrgn-bttm-md" id="for_section">
	<label for="recipient_username"><?php echo elgg_echo("email:to"); ?>: </label>
	<?php echo $recipient_autocomplete; ?>
	<span class="elgg-text-help"><?php echo elgg_echo("messages:to:help"); ?></span>
	
</div>
<div class="mrgn-bttm-md">
	<label for="subject"><?php echo elgg_echo("messages:title"); ?>: <br /></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'subject',
        'id' => 'subject',
		'value' => $subject,
	));
	?>
</div>
<div class="mrgn-bttm-md">
	<label for="body"><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
        'id' => 'body',
		'value' => $body,
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('send'), 'class' => 'btn btn-primary'));
          echo  elgg_view('output/url', array('text' => elgg_echo('preview'), 'href' => 'ajax/view/messages/message_preview', 'class' => 'btn-default btn elgg-lightbox', 'id' => 'preview'));
    ?>
</div>
<script>//Colleague circle show/hide

if($('#colleagueCircle').is(":checked")){
	$("#circlecolleague_section").show();
	$("#for_section").hide();
} else{
    $("#circlecolleague_section").hide();
    $("#for_section").show();
}

$("#colleagueCircle").click(function() {
    if($(this).is(":checked")) {
        $("#circlecolleague_section").show();
 		$("#for_section").hide();
    } else {
        $("#circlecolleague_section").hide();
        $("#for_section").show();
    }
});

</script>