<?php
/*
Action handles changing group ownership if user is a group owner
*/
elgg_make_sticky_form('member_selfdelete');

$group = get_entity(get_input('group_guid'));
$new_owner = get_entity(get_input('owner_guid'));

if($new_owner->getGUID() != $group->getOwnerGUID()){
    if($group->isMember($new_owner)){
        //transfer cover photo to new owner
		gc_group_layout_transfer_coverphoto($group, $new_owner);
		// transfer the group to the new owner
		group_tools_transfer_group_ownership($group, $new_owner);
        system_message(elgg_echo('member_selfdelete:gc:change:owner'));
        forward(REFERER);
    }else{
        register_error(elgg_echo('member_selfdelete:gc:change:not:member'));
        forward(REFERER);
    }
}else{
    register_error('member_selfdelete:gc:change:error');
    forward(REFERER);
}