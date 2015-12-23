<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
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
            
            <div class="btn-group pull-right mrgn-rght-sm">
                
                
                
                <?php 

                    // add group operators menu link to title menu
                    // Get the page owner entity
                    $page_owner = elgg_get_page_owner_entity();

                    if (elgg_in_context('groups')) {
                        if ($page_owner instanceof ElggGroup) {
                            if (elgg_is_logged_in() && $page_owner->canEdit()) {
                                $url = elgg_get_site_url() . "group_operators/manage/{$page_owner->getGUID()}";
                                elgg_register_menu_item('title', array(
                                    'name' => 'edit',
                                    'text' => elgg_echo('group_operators:manage'),
                                    'href' => $url,
                                ));
                            }
                        }
                    }

                    // Add invitation/request to title menu
                    // invitation management
                    if ($page_owner->canEdit()) {
                        $request_options = array(
                            "type" => "user",
                            "relationship" => "membership_request",
                            "relationship_guid" => $page_owner->getGUID(),
                            "inverse_relationship" => true,
                            "count" => true
                        );

                        $requests = elgg_get_entities_from_relationship($request_options);

                        $postfix = "";
                        if (!empty($requests)) {
                            $postfix = '<span class="notif-badge">' . $requests . "</span>";
                        }

                        if (!$page_owner->isPublicMembership()) {
                            elgg_register_menu_item("title", array(
                                "name" => "membership_requests",
                                "text" => elgg_echo("groups:membershiprequests") . $postfix,
                                "href" => "groups/requests/" . $page_owner->getGUID(),
                            ));
                        } else {
                            elgg_register_menu_item("title", array(
                                "name" => "membership_requests",
                                "text" => elgg_echo("group_tools:menu:invitations") . $postfix,
                                "href" => "groups/requests/" . $page_owner->getGUID(),
                            ));
                        }
                    }

                    if(elgg_is_logged_in()){ 
                    $user = get_loggedin_user()->getGUID();
                           
                    //see if user is a member
                    if($group->isFriendOf($user) || elgg_is_admin_logged_in()){
            
                        //load action buttons in dropdown
                        $buttons = elgg_view_menu('title', array(
                            'sort_by' => 'priority',
                            'class' => 'dropdown-menu pull-right',
                            'item_class' => ' ',

                        ));

                        //display different title on button for group owner/mods
                        if($owner == get_loggedin_user() || elgg_is_admin_logged_in()){
                            $buttonTitle = "Settings";
                        }
                ?>
                

                <button type="button" class="btn btn-custom dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $buttonTitle ?> <span class="caret"></span>
                </button>
            
                        <?php 
                            
                                //action buttons
                                echo $buttons; 
                        
                            } else {
                        
                            //if only join group option, display as button not in dropdown
                        $buttons = elgg_view_menu('title', array(
                            'sort_by' => 'priority',
                            'class' => '',
                            'item_class' => 'btn btn-primary',

                        ));
                        
                        echo $buttons;
                    }
                    }
                    
                        ?>
                
            </div>

                
            <h2 class="pull-left"><?php echo $group->name; ?></h2>
        </div>
    <div class="row mrgn-lft-sm mrgn-rght-sm">
		<div class="groups-profile-icon col-xs-2 col-md-2 mrgn-tp-sm">
			<?php
				// we don't force icons to be square so don't set width/height
				echo elgg_view_entity_icon($group, 'medium', array(
					'href' => '',
					'width' => '',
					'height' => '',
				)); 
			?>
		</div>
        
    
    
    
		<div class="groups-info col-xs-10 col-md-10 ">
            
            
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


</div>
