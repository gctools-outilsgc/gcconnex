<?php
/**
 * Elgg notifications groups subscription form
 *
 * @package ElggNotifications
 *
 * @uses $vars['user'] ElggUser
 */

/* @var ElggUser $user */
$user = $vars['user'];

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
	$subsbig[$method] = elgg_get_entities_from_relationship(array(
		'relationship' => 'notify' . $method,
		'relationship_guid' => $user->guid,
		'type' => 'group',
		'limit' => false,
	));
	$tmparray = array();
	if ($subsbig[$method]) {
		foreach($subsbig[$method] as $tmpent) {
			$tmparray[] = $tmpent->guid;
		}
	}
	$subsbig[$method] = $tmparray;
}

?>



<div>
    <div class="clearfix">

        	<?php
		echo elgg_view('notifications/subscriptions/jsfuncs',$vars);
	?>
		<div class="mrgn-bttm-lg">
		<?php
			echo elgg_echo('notifications:subscriptions:groups:description');
		?>
		</div>
        <?php

        if (isset($vars['groups']) && !empty($vars['groups'])) {

?>
        <?php
	       foreach($vars['groups'] as $group) {
		
		$fields = '';
		$i = 0;
		
		foreach($NOTIFICATION_HANDLERS as $method => $foo) {
			if (in_array($group->guid,$subsbig[$method])) {
				$checked[$method] = 'checked="checked"';
			} else {
				$checked[$method] = '';
			}
			if ($i > 0) {
				//$fields .= "<div class=\"spacercolumn\">&nbsp;</div>";
			}
            $test =  elgg_echo('notification:method:'.$method);
			$fields .= <<< END
				<div class="{$method}togglefield col-xs-3 mrgn-bttm-md ">
				<a border="0" id="{$method}{$group->guid}" class="{$method}toggleOff" onclick="adjust{$method}_alt('{$method}{$group->guid}');">
				<label><input type="checkbox" name="{$method}subscriptions[]" id="{$method}checkbox" onclick="adjust{$method}('{$method}{$group->guid}');" value="{$group->guid}" {$checked[$method]} /><span class="mrgn-lft-sm">{$test}</span></label></a></div>
END;
			$i++;
		}
	
?>
			
				
					<div class="col-xs-6 mrgn-bttm-md">
					<?php echo $group->name; //group name?>
					</div>
				
				<?php echo $fields; ?>
			
			
        <?php }?>
    </div>
    
    <?php 
        }
    	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
	   echo elgg_view('input/submit', array('value' => elgg_echo('save')));
    ?>
</div>





