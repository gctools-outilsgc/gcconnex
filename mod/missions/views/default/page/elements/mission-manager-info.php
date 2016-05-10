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

$manager_account_by_email = get_user_by_email($mission->email);
$manager_account = array_pop($manager_account_by_email);

$manager_name = $mission->name;
$manager_icon = '';
if($manager_account) {
	$manager_name = elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'profile/' . $manager_account->name,
			'text' => $manager_name,
			'id' => 'mission-user-link-' . $manager->guid
	));

	$manager_icon = elgg_view_entity_icon($manager_account, 'small');;
}

$department_node = get_entity(mo_extract_node_guid($mission->department));
$department = $department_node->name;
if(get_current_language() == 'fr') {
	$department = $department_node->name_french;
}

$department_other = mo_extract_other_input($mission->department);
if($department_other) {
	$department = $department_other;
}
?>

<div class="<?php echo $container_class; ?>">
	<div class="col-sm-<?php echo $grid_number; ?>">
		<?php echo $manager_icon;?>
	</div>
	<div class="col-sm-<?php echo (12 - $grid_number); ?>" name="mission-manager" style="text-align:left;">
		<div>
			<span name="mission-manager-name"><?php echo $manager_name;?></span>
		</div>
		<div>
			<span name="mission-manager-department"><?php echo ucwords(strtolower($department)); ?></span>
		</div>
	</div>
</div>