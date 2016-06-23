<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Script which acts as a bridge between the post mission third form submission and the skill match actions.
 */
// Required action security tokens.
$ts = time();
$token = generate_action_token($ts);
set_input('__elgg_ts', $ts);
set_input('__elgg_token', $token);
?>

<script>
	$('document').ready(function() {
		$(document.body).css({ 'cursor': 'wait' });
		$('#<?php echo $vars['submit_button_id'];?>').prop('disabled', true);
		elgg.action('missions/post-mission-skill-match', {
			success: function(returner) {
				elgg.forward(returner.forward_url);
			}
		});
	});
</script>