<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

$group = elgg_get_page_owner_entity();
$owner = $group->getOwnerEntity();

$buttonTitle = 'Member';

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = "Sorry, '" . 'group owner' . "' does not exist for guid:" . $group->guid;
	throw new InvalidParameterException($msg);
}

?>
<div class="groups-profile panel panel-custom clearfix elgg-image-block">

        
    
    
        <div class="panel-heading col-xs-12 mrgn-lft-sm"> 
                
            <h2 class="pull-left"><a href="<?php echo $group->getURL(); ?>"><?php echo $group->name; ?></a></h2>
        </div>
    
		<div class="groups-profile-icon pull-left mrgn-lft-md">
			<?php
				// we don't force icons to be square so don't set width/height
				echo elgg_view_entity_icon($group, 'medium', array(
					'href' => '',
					'width' => '',
					'height' => '',
				)); 
			?>
		</div>
        
    
    
    
		<div class="groups-info pull-left mrgn-lft-md">
            
            
			<p class="mrgn-bttm-sm">
				<b><?php echo elgg_echo("groups:owner"); ?>: </b>
				<?php
					echo elgg_view('output/url', array(
						'text' => $owner->name,
						'value' => $owner->getURL(),
						'is_trusted' => true,
					));  
				?>
			</p>
            
            
			<p class="mrgn-bttm-sm">
			<?php
				$num_members = $group->getMembers(array('count' => true));
				echo '<b>' . elgg_echo('groups:members') . ':</b> ' . $num_members;
			?>
			</p>
            
            
            <?php

            //Add tags for new layout to profile stats

            $profile_fields = elgg_get_config('group');

            foreach ($profile_fields as $key => $valtype) {
                
                $options = array('value' => $group->$key, 'list_class' => 'mrgn-bttm-sm',);
                
                if ($valtype == 'tags') {
                    $options['tag_names'] = $key;
                    $tags .= elgg_view("output/$valtype", $options);
                }   
            }   

            
            //check to see if tags have been made
            //dont list tag header if no tags
            if(!$tags){
                
            } else {
                echo '<b>' . elgg_echo('profile:field:tags') . '</b>';
                echo $tags;
            }

            ?>
            
            <div class="groups-stats mrgn-tp-0 mrgn-bttm-sm"></div>
           
		</div>
    


</div>
