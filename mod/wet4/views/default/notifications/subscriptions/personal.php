<?php
/**
 * @uses $vars['user'] ElggUser
 */

/* @var ElggUser $user */
$user = $vars['user'];

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();

?>
<div class="notification_personal">
<div class="elgg-module elgg-module-info">
	<div class="elgg-head">
		<h3 class="well">
			<?php echo elgg_echo('notifications:subscriptions:personal:title'); ?>
		</h3>
	</div>
</div>
    
    <div id="notificationstable">
        <div class="clearfix">

		
	
	
	
			<div class="col-md-6">
				<?php echo elgg_echo('notifications:subscriptions:personal:description') ?>
            </div>
            
            <?php

            $fields = '';
            $i = 0;
            foreach($NOTIFICATION_HANDLERS as $method => $foo) {
	           if ($notification_settings = get_user_notification_settings($user->guid)) {
		          if (isset($notification_settings->$method) && $notification_settings->$method) {
			         $personalchecked[$method] = 'checked="checked"';
		          } else {
			         $personalchecked[$method] = '';
		          }
	           }
	           if ($i > 0) {
		          //$fields .= "<div class='spacercolumn'>&nbsp;</div>";
	           }
                $test =  elgg_echo('notification:method:'.$method);
	           $fields .= <<< END
		          <div class="{$method}togglefield col-xs-3 mrgn-bttm-md ">
		          <a  border="0" id="{$method}personal" class="{$method}toggleOff" onclick="adjust{$method}_alt('{$method}personal');">
		          <label><input type="checkbox" name="{$method}personal" id="{$method}checkbox" onclick="adjust{$method}('{$method}personal');" value="1" {$personalchecked[$method]} /><span class="mrgn-lft-sm">{$test}</span></label></a></div>
END;
	$i++;
}
echo $fields;

?>
		       
        </div>
    
    </div>

</div>