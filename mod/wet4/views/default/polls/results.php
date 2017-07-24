<?php
/**
 * Elgg polls plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */


if (isset($vars['entity'])) {

	//set img src
	$img_src = $vars['url'] . "mod/polls/graphics/poll.gif";

	$question = $vars['entity']->question;

	//get the array of possible responses
	$responses = polls_get_choices($vars['entity']);
    $responses3 = polls_get_choices3($vars['entity']);

    if ( count($responses3) >= count($responses) ) $responses = $responses3;		// when we have an old poll with 'choice3's

	//get the array of user responses to the poll
	$user_responses = $vars['entity']->getAnnotations('vote',9999,0,'desc');

	//get the count of responses
	$user_responses_count = $vars['entity']->countAnnotations('vote');

	//create new array to store response and count
	//$response_count = array();

	?>

	<?php
	//populate array
	foreach($responses as $response)
	{
		//get count per response
		$response_count = polls_get_response_count_enfr($response, $user_responses);
		
		//calculate %
		if ($response_count != 0) {
			$response_percentage = round(100 / ($user_responses_count / $response_count));
		} else {
			$response_percentage = 0;
		}
		
		//html
		?>
<div id="progress_indicator">
	<div class="poll-result-response"><?php echo $response->text . " (" . $response_count . ")"; ?> </div><br>
	<div id="progressBarContainer" align="left">
		<div class="polls-filled-bar"
			style="width: <?php echo $response_percentage; ?>%"></div>
	</div>
</div>
<br>
		<?php
	}
	?>

<p>
<?php echo elgg_echo('polls:totalvotes') . $user_responses_count; ?>
</p>

<?php

}
else
{
	register_error(elgg_echo("polls:blank"));
	forward("polls/all");
}


