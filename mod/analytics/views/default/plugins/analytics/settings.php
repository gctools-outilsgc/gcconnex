<?php
	/**
	* Google Analytics settings configuration.
	* 
	* @package analytics
	* @author ColdTrick IT Solutions
	* @copyright ColdTrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$trackID = $vars['entity']->analyticsSiteID;
	$domain = $vars['entity']->analyticsDomain;
	$actions = $vars['entity']->trackActions;
	$events = $vars['entity']->trackEvents;
	$flagAdmins = $vars['entity']->flagAdmins;
	
	$host = $_SERVER['HTTP_HOST'];
	$hostArray = explode(".", $host);
	$host = "";
	for($i = 1; $i < count($hostArray); $i++){
		$host .= "." . $hostArray[$i];
	}
	
	if($domain != $host){
		$sample = true;
	}
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
?>
<div>
	<?php 
		echo elgg_echo("analytics:settings:trackid");
		echo "&nbsp;" . elgg_view("input/text", array("name" => "params[analyticsSiteID]", "value" => $trackID, "maxlength" => "15", "id" => "analyticsSiteID")); 
	?>
</div>

<div>
	<?php 
		echo elgg_echo("analytics:settings:domain");
		echo "&nbsp;" . elgg_view("input/text", array("name" => "params[analyticsDomain]", "value" => $domain, "id" => "analyticsDomain"));
		
		if($sample){ 
			echo "&nbsp;" . elgg_echo("analytics:settings:domain:sample", array($host)); 
		}
	?>
</div>

<div>
	<?php 
		echo elgg_echo("analytics:settings:track_actions");
		echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[trackActions]", "options_values" => $noyes_options, "value" => $actions));
	?>
</div>

<div>
	<?php 
		echo elgg_echo("analytics:settings:track_events");
		echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[trackEvents]", "options_values" => $noyes_options, "value" => $events));
	?>
	<div><?php echo elgg_echo("analytics:settings:track_events:warning"); ?></div>
</div>

<div>
	<?php 
		echo elgg_echo("analytics:settings:flag_administrators");
		echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[flagAdmins]", "options_values" => $noyes_options, "value" => $flagAdmins));
	?>
</div>