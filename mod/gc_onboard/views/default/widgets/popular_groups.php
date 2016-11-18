<?php
/*
 * popular_groups.php
 *
 * Lists the most popular groups. Used in the group module.
 */
$db_prefix = elgg_get_config('dbprefix');
$options = array(
					'type' => 'group',
					'relationship' => 'member',
					'inverse_relationship' => false,
					'full_view' => false,
                    'limit' => 9,
                    'pagination' => false,
					'no_results' => elgg_echo('groups:none'),
				);

				if ($display_subgroups != 'yes') {
					$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = 'au_subgroup_of' )");
				}

				$content = elgg_get_entities_from_relationship_count($options);

                //echo $content;

                foreach($content as $group){

                    //dont show groups user is already a member of
                    if($group->isMember(elgg_get_logged_in_user_entity())){
                        //echo ' i am a member of '.$group->name;
                    } else {
                        $join_url = "action/groups/join?group_guid={$group->getGUID()}";

                        if ($group->isPublicMembership() || $group->canEdit()) {
                            $join_text = elgg_echo("groups:join");

                        } else {
                            // request membership
                            $join_text = elgg_echo("groups:joinrequest");

                        }
                        echo '<div class="list-break">';
                        echo elgg_view('group/default', array('entity' => $group));
                        //echo "<div class='text-center'>" . elgg_view("output/url", array("text" => $join_text, "href" => $join_url, "is_action" => true, "class" => "elgg-button elgg-button-action btn btn-primary mrgn-bttm-sm")) . "</div>";
                        echo '<div class="text-center"><a id="popular-'.$group->guid.'" '.$disabled.' class="btn btn-primary mrgn-bttm-sm" href="#popular" onclick="joinGroup(\'popular\', '.$group->guid.')">'.$join_text.'</a></div>';
                        echo '</div>';
                    }
                }
