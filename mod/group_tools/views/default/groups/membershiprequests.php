<?php
	/**
	 * A group's member requests
	 *
	 * @uses $vars['entity']   ElggGroup
	 * @uses $vars['requests'] Array of ElggUsers who requested membership
	 * @uses $vars['invitations'] Array of ElggUsers who where invited
	 */
	
	// show membership requests
	$title = elgg_echo("group_tools:groups:membershipreq:requests");
	
	if (!empty($vars['requests']) && is_array($vars['requests'])) {
		$content = '<ul class="elgg-list">';
		
		foreach ($vars['requests'] as $user) {
			$icon = elgg_view_entity_icon($user, 'tiny', array('use_hover' => 'true'));
	
			$user_title = elgg_view('output/url', array(
				'href' => $user->getURL(),
				'text' => $user->name,
				'is_trusted' => true,
			));
	
			$url = "action/groups/addtogroup?user_guid={$user->guid}&group_guid={$vars['entity']->guid}";
			$url = elgg_add_action_tokens_to_url($url);
			$accept_button = elgg_view('output/url', array(
				'href' => $url,
				'text' => elgg_echo('accept'),
				'class' => 'elgg-button elgg-button-submit',
				'is_trusted' => true,
			));
	
			$url = 'action/groups/killrequest?user_guid=' . $user->guid . '&group_guid=' . $vars['entity']->guid;
			$delete_button = elgg_view('output/confirmlink', array(
					'href' => $url,
					'confirm' => elgg_echo('groups:joinrequest:remove:check'),
					'text' => elgg_echo('delete'),
					'class' => 'elgg-button elgg-button-delete mlm',
			));
	
			$body = "<h4>$user_title</h4>";
			$alt = $accept_button . $delete_button;
	
			$content .= '<li class="pvs">';
			$content .= elgg_view_image_block($icon, $body, array('image_alt' => $alt));
			$content .= '</li>';
		}
		
		$content .= '</ul>';
	} else {
		$content = '<p class="mtm">' . elgg_echo('groups:requests:none') . "</p>";
	}

	echo elgg_view_module("info", $title, $content);
	
	// show invitations
	$title = elgg_echo("group_tools:groups:membershipreq:invitations");
	
	if (!empty($vars['invitations']) && is_array($vars['invitations'])) {
		$content = '<ul class="elgg-list">';
	
		foreach ($vars['invitations'] as $user) {
			$icon = elgg_view_entity_icon($user, 'tiny', array('use_hover' => 'true'));
	
			$user_title = elgg_view('output/url', array(
					'href' => $user->getURL(),
					'text' => $user->name,
					'is_trusted' => true,
			));
	
			$url = 'action/groups/killinvitation?user_guid=' . $user->guid . '&group_guid=' . $vars['entity']->guid;
			$delete_button = elgg_view('output/confirmlink', array(
						'href' => $url,
						'confirm' => elgg_echo('group_tools:groups:membershipreq:invitations:revoke:confirm'),
						'text' => elgg_echo('group_tools:revoke'),
						'class' => 'elgg-button elgg-button-delete mlm',
			));
	
			$body = "<h4>$user_title</h4>";
			$alt = $delete_button;
	
			$content .= '<li class="pvs">';
			$content .= elgg_view_image_block($icon, $body, array('image_alt' => $alt));
			$content .= '</li>';
		}
	
		$content .= '</ul>';
	} else {
		$content = '<p class="mtm">' . elgg_echo('group_tools:groups:membershipreq:invitations:none') . "</p>";
	}
	
	echo elgg_view_module("info", $title, $content);
