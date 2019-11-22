<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */


if (elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), 'group')) {

	//Wrap this view in the context of group profile
	$group = get_entity(elgg_get_page_owner_guid());
	$lang = get_current_language();

	$owner = $group->getOwnerEntity();
	$buttonTitle = '<span class="fa fa-lg fa-cog"><span class="wb-invisible">'.elgg_echo('group:settings').'</span></span>';

	if (!$owner) {
		// not having an owner is very bad so we throw an exception
		$msg = "Sorry, '" . 'group owner' . "' does not exist for guid:" . $group->guid;
		throw new InvalidParameterException($msg);
	}
	if($group->cover_photo =='nope' || $group->cover_photo ==''){
		$c_photo_top_margin = 'group-no-cover';
		// TODO Put a generic cover photo here and fix this layout
		echo '<div class="row group-padding-helper"> <div class="group-place-holder-cover"></div> </div>';
	}else{
		$c_photo_top_margin = ' groups-profile';
	}
	?>

	<div class="row group-padding-helper">
		<div class="panel panel-custom clearfix elgg-image-block col-xs-12 <?php echo $c_photo_top_margin; ?>">
			<div class="group-summary-holder clearfix">
				<div class="col-xs-9 d-flex">

					<div class="group-profile-image-size">
					<?php
						// we don't force icons to be square so don't set width/height
						echo elgg_view_entity_icon($group, 'medium', array(
							'href' => '',
							'width' => '',
							'height' => '',
							'class'=>'TESTING',
						));
					?>
					</div>

					<div class="groups-info">

						<h1 class="group-title">
						<?php
							echo gc_explode_translation($group->name, $lang);
						?>
						</h1>
						
						<div class="clearfix">
							<div class="mrgn-bttm-sm pull-left  mrgn-rght-md">
								<b><?php echo elgg_echo("groups:owner"); ?>: </b>
								<?php
									echo elgg_view('output/url', array(
										'text' => $owner->name,
										'value' => $owner->getURL(),
										'is_trusted' => true,
									));
								?>
							</div>


							<div class="mrgn-bttm-sm pull-left">
							<?php
								$display_members = $group->getPrivateSetting('group_tools:cleanup:members');
								$num_members = $group->getMembers(array('count' => true));

								if($display_members != 'yes'){
									$members_link = 'groups/members/' . $group->guid;
									$all_members_link = elgg_view('output/url', array(
										'href' => $members_link,
										'text' =>  $num_members,
										'is_trusted' => true,
										'class' => '',
									));

									echo '<b>' . elgg_echo('groups:members') . ':</b> ' . $all_members_link;
								} else {
									echo '<b>' . elgg_echo('groups:members') . ':</b> ' . $num_members;
								}
							?>
							</div>

						</div>
					</div>
				</div>

				<div class="btn-group text-right col-xs-3 group-action-holder">


					<div class="groups-stats mrgn-tp-sm mrgn-bttm-sm text-right"></div>

						<div class="groups-info pull-right">

							<ul class="groups-share-links list-inline pull-left mrgn-rght-sm">
							<?php
								//Nick - Added a link to share the group on the wire
								if (elgg_is_logged_in()) {
									$text = elgg_echo('entity:share:link:group', array($group->name));
									$options = array(
										'text' => "<i class='fa fa-share-alt fa-lg icon-unsel'><span class='wb-inv'>{$text}</span></i>",
										'title' => elgg_echo('thewire_tools:reshare'),
										'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $group->getGUID(),
										'class' => 'elgg-lightbox',
										'is_trusted' => true,
									);
								}
								
								echo '<li class="mrgn-tp-sm">'.elgg_view('output/url', $options).'</li>';

								// This is the code to add the notification bell to the page to the left of the member button
								if ($group->isMember(elgg_get_logged_in_user_entity())) { //Nick - check if user is a member before
								
									// cyu - indicate if user has subscribed to the group or not (must have cp notifications enabled)
									if (elgg_is_active_plugin('cp_notifications')) {

										if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $group->getGUID()) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $group->getGUID()))
											echo "<li class='mrgn-tp-sm'><a href='".elgg_add_action_tokens_to_url("/action/cp_notify/unsubscribe?guid={$group->getGUID()}")."' title='".elgg_echo('cp_notify:unsubBell')."'><i class='icon-sel fa fa-lg fa-bell'><span class='wb-inv'>".elgg_echo('entity:unsubscribe:link:group', array($group->name))."</span></i></a></li>";
										else
											echo '<li class="mrgn-tp-sm"><a href="'.elgg_add_action_tokens_to_url("/action/cp_notify/subscribe?guid={$group->getGUID()}").'" title="'.elgg_echo('cp_notify:subBell').'"><i class="icon-unsel fa fa-lg fa-bell-slash-o"><span class="wb-inv">'.elgg_echo('entity:subscribe:link:group', array($group->name)).'</span></i></a></li>';
									}
								}

							?>
							</ul>

							<?php

							// add group operators menu link to title menu
							$page_owner = elgg_get_page_owner_entity();
							$actions = array();
							
							// group owners
							if ($owner->canEdit() || $page_owner->canEdit()) {
								// edit and invite
								$url = elgg_get_site_url() . "groups/edit/{$group->getGUID()}";
								$actions[$url] = 'groups:edit';
								$url = elgg_get_site_url() . "groups/invite/{$group->getGUID()}";
								$actions[$url] = 'groups:invite';
							}
							
							// group members
							if ($group->isMember()) {
								if ($owner->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
									// leave
									$url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
									$url = elgg_add_action_tokens_to_url($url);
									$actions[$url] = 'groups:leave';
								}

								$url = elgg_get_site_url() . "groups/stats/{$group->getGUID()}";
								$actions[$url] = 'groups:stats';

							} elseif (elgg_is_logged_in()) {
								// join - admins can always join.
								$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
								$url = elgg_add_action_tokens_to_url($url);
								if ($group->isPublicMembership() || $owner->canEdit()) {
									$actions[$url] = 'groups:join';
								} else {
									// request membership
									$actions[$url] = 'groups:joinrequest';
								}
							} 

							if ($actions) {
								foreach ($actions as $url => $text) {
									elgg_register_menu_item('group_ddb', array(
										'name' => $text,
										'href' => $url,
										'text' => elgg_echo($text),
										'link_class' => 'elgg-button elgg-button-action',
									));
								}
							}

							if ($page_owner instanceof ElggGroup) {
								if (elgg_is_logged_in() && $page_owner->canEdit()) {
									$url = elgg_get_site_url() . "group_operators/manage/{$page_owner->getGUID()}";
									elgg_register_menu_item('group_ddb', array(
										'name' => 'edit',
										'text' => elgg_echo('group_operators:manage'),
										'href' => $url,
									));
								}
							}

							// Add invitation/request to title menu
							// If you are a member of the group, add a quick link to invite
							if($group->isMember() && $group->invite_members !== 'no' || $page_owner->canEdit()) {
								echo elgg_view('output/url', array(
									'text' => '+ '.elgg_echo('invite'),
									'href' => '/groups/invite/' .$group->guid,
									'class' => 'btn btn-primary mrgn-rght-sm group-invite',
								));
							}

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
									elgg_register_menu_item("group_ddb", array(
										"name" => "membership_requests",
										"text" => elgg_echo("groups:membershiprequests") . $postfix,
										"href" => "groups/requests/" . $page_owner->getGUID(),
									));
								} else {
									elgg_register_menu_item("group_ddb", array(
										"name" => "membership_requests",
										"text" => elgg_echo("group_tools:menu:invitations") . $postfix,
										"href" => "groups/requests/" . $page_owner->getGUID(),
									));
								}
							}

							if(elgg_is_logged_in()){
								$user = elgg_get_logged_in_user_entity()->getGUID();
								//see if user is a member
								if($group->isFriendOf($user) || elgg_is_admin_logged_in()){
									if ($page_owner->canEdit() && (elgg_get_plugin_setting("mail", "group_tools") == "yes")) {
										elgg_register_menu_item("group_ddb", array(
											"name" => "mail",
											"text" => elgg_echo("group_tools:menu:mail"),
											"href" => "groups/mail/" . $page_owner->getGUID(),
										));
									}

									//add create subgroup option
									if (elgg_is_active_plugin('au_subgroups') && $group->subgroups_enable != 'no') {
										$any_member = ($group->subgroups_members_create_enable != 'no');
										if (($group->subgroups_members_create_enable != 'no' || $page_owner->canEdit())) {
											elgg_register_menu_item('group_ddb', array(
												'name' => 'add_subgroup',
												'href' => "groups/subgroups/add/{$group->guid}",
												'text' => elgg_echo('au_subgroups:add:subgroup'),
												'link_class' => 'elgg-button elgg-button-action',
												'priority'=>450,
											));
										}
									}

									//load action buttons in dropdown
									$buttons = elgg_view_menu('group_ddb', array(
										'sort_by' => 'priority',
										'class' => 'dropdown-menu pull-right',
										'item_class' => ' ',
									));
									?>

									<button type="button" class="btn btn-custom dropdown-toggle pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo $buttonTitle . $postfix ?>
										<span class="caret"></span>
									</button>

									<?php
									//action buttons
									echo $buttons;
								} else {
									//if only join group option, display as button not in dropdown
									$buttons = elgg_view_menu('group_ddb', array(
													'sort_by' => 'priority',
													'class' => 'pull-right',
													'item_class' => 'btn btn-primary',
											));
									echo $buttons;
								}
							}
							?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
} ?>
