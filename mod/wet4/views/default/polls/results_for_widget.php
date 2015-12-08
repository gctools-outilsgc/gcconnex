<?php
/**
 * Elgg Poll plugin
 * @package Elggpoll
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @Original author John Mellberg
 * website http://www.syslogicinc.com
 * @Modified By Team Webgalli to work with ElggV1.5
 * www.webgalli.com or www.m4medicine.com
 */


if (isset($vars['entity'])) {
    $chartHeight = "data-flot='{ \"legend\": {\"show\":\"false\"}}'";
    echo '<table class="wb-charts wb-charts-pie wb-charts-nolegend table mrgn-tp-md polls-table" '. $chartHeight .' >';

	//set img src
	$img_src = $vars['url'] . "mod/polls/graphics/poll.gif";

	$question = $vars['entity']->question;

	//get the array of possible responses
	$responses = polls_get_choice_array($vars['entity']);

	//get the array of user responses to the poll
	$user_responses = $vars['entity']->getAnnotations('vote',9999,0,'desc');

	//get the count of responses
	$user_responses_count = $vars['entity']->countAnnotations('vote');

	//create new array to store response and count
	//$response_count = array();


	//populate array
    echo '<tr>';
    echo '<td class="wb-inv"></td>';
	foreach($responses as $response)
	{
		//get count per response
		$response_count = polls_get_response_count($response, $user_responses);
			
		//calculate %
		if ($response_count && $user_responses_count) {
			$response_percentage = round(100 / ($user_responses_count / $response_count));
		} else {
			$response_percentage = 0;
		}
			
		//html
		?>

    <th class="text-center">
        <?php echo $response; ?>
    </th>




		<?php
	}
        echo '</tr>';
        echo '<tr>';
        echo '<th class="wb-inv">'.$question.'</th>';
    	foreach($responses as $response)
	{
		//get count per response
		$response_count = polls_get_response_count($response, $user_responses);
			
		//calculate %
		if ($response_count && $user_responses_count) {
			$response_percentage = round(100 / ($user_responses_count / $response_count));
		} else {
			$response_percentage = 0;
		}
			
		//html
		?>



    <td class="text-center">
        <?php echo $response_count; ?>
    </td>

    <?php
        }
    echo '</tr>';
            ?>

<p>
<?php echo elgg_echo('polls:totalvotes') . $user_responses_count; ?>
</p>
</table>
<?php

}
else
{
	register_error(elgg_echo("polls:blank"));
	forward("mod/polls/all");
}


