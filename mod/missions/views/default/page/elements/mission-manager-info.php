<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 *
 */
$mission = $vars['mission'];
$container_class = $vars['container_class'];
$grid_number = $vars['grid_number'];
$test = $mission->account;
$manager_account = get_user($mission->account); //Nick changed to owner_guid then back to account
if(!$manager_account) {
	$manager_account_by_email = get_user_by_email($mission->email);
	$manager_account = array_pop($manager_account_by_email);
}

$manager_name = $mission->name;
$manager_icon = elgg_view_entity_icon(get_entity(1), 'small');
if($manager_account) {
	$manager_name = elgg_view('output/url', array(
			'href' => $manager_account->getURL(), //Nick changed to profile url
			'text' => $manager_name,
			'class' => 'mission-user-link-' . $manager_account->guid
	));

	$manager_icon = elgg_view_entity_icon($manager_account, 'small');
}

$department_node = get_entity(mo_extract_node_guid($mission->department));
if($department_node == '') {
	$department = $mission->department;
}
else {
	$department = $department_node->name;
	if(get_current_language() == 'fr') {
		$department = $department_node->name_french;
	}
}

$department_other = mo_extract_other_input($mission->department);
if($department_other) {
	$department = $department_other;
}

$job_title = $manager_account->job;
?>

<div class="<?php echo $container_class; ?>">


	<div class="col-xs-<?php echo $grid_number; ?>">
		<?php echo $manager_icon;?>
	</div>
	<div class="col-xs-<?php echo (12 - $grid_number); ?>" name="mission-manager" style="text-align:left;">
		<div>
			<span name="mission-manager-name"><?php echo $manager_name;?></span>
		</div>
		<div>
			<span name="mission-manager-department">
            <?php //echo ucwords(strtolower($department));
            echo $job_title;
            ?></span>
		</div>
	</div>
</div>
