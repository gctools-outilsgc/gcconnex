<?php
/**
 * Elgg log rotator plugin settings.
 *
 * @package unvalidated_user_cleanup
 */

$unvaldeleteage = $vars['entity']->unvaldeleteage;
$unvaldelete = $vars['entity']->unvaldelete;
if (!$unvaldeleteage) {
	$unvaldeleteage = 2;
}

if (!$unvaldelete) {
	$unvaldelete = 'daily';
}		
?>
<div>
	<?php

		echo elgg_echo('unvalidated_user_cleanup:period') . ' ';
		echo elgg_view('input/dropdown', array(
			'name' => 'params[unvaldelete]',
			'options_values' => array(
				'fiveminute' => '5 min',
				'hourly' => elgg_echo('unvalidated_user_cleanup:hourly'),
				'daily' => elgg_echo('unvalidated_user_cleanup:daily'),
				'weekly' => elgg_echo('unvalidated_user_cleanup:weekly'),
				'monthly' => elgg_echo('unvalidated_user_cleanup:monthly'),
				'yearly' => elgg_echo('unvalidated_user_cleanup:yearly'),
			),
			'value' => $unvaldelete,
		));
	?>
</div>
<div>
	<?php

		echo elgg_echo('unvalidated_user_cleanup:delete') . ' ';
		echo elgg_view('input/text', array(
			'name' => 'params[unvaldeleteage]',
			'value' => $unvaldeleteage,
		));
	?>
</div>

<?php // For testing purposes
/*echo "<div>";
	$ia = elgg_set_ignore_access(TRUE);
	$hidden_entities = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);
		$options = array(
		'type' => 'user',
		'wheres' => uservalidationbyemail_get_unvalidated_users_sql_where(),
	//	'count' => TRUE,
	);
		$users = elgg_get_entities($options);
		foreach ( $users as $usr ){
		echo $usr->username . "<br />";
		if ( ( time() - $usr->time_created ) > 2500 && !elgg_get_user_validation_status( $usr->guid ) ){
			$usr->delete();
		}
	}
echo "</div>";*/
?>

