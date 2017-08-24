<?php 
  
/**
 * Community page widgets
 */
  
 	$widget = $vars['entity'];
 	
	$widget->title = ( get_current_language() == "fr" ) ? $widget->widget_title_fr : $widget->widget_title_en;
	
	$display_avatar = $widget->display_avatar;
	if( !isset($display_avatar) ) $display_avatar = 'yes';

	$widget_users = $widget->widget_users;
	$widget_users = array_map('trim', explode(',', $widget_users));

	if( !empty($widget_users) ){

		foreach($widget_users as $widget_user){
			
			$userObj = get_user_by_username($widget_user);

			if( $userObj ){

				$userType = $userObj->user_type;
			    
            	switch( $userType ){
            		case "federal":
	                    $deptObj = elgg_get_entities(array(
	                        'type' => 'object',
	                        'subtype' => 'federal_departments',
	                    ));
	                    $depts = get_entity($deptObj[0]->guid);

	                    $federal_departments = array();
	                    if (get_current_language() == 'en'){
	                        $federal_departments = json_decode($depts->federal_departments_en, true);
	                    } else {
	                        $federal_departments = json_decode($depts->federal_departments_fr, true);
	                    }

	                    $department = $federal_departments[$userObj->federal];
	                    break;
	                case "student":
	                case "academic":
	                    $institution = $userObj->institution;
	                    $department = ($institution == 'university') ? $userObj->university : $userObj->college;
	                    break;
	                case "provincial":
	                    $provObj = elgg_get_entities(array(
	                        'type' => 'object',
	                        'subtype' => 'provinces',
	                    ));
	                    $provs = get_entity($provObj[0]->guid);

	                    $provinces = array();
	                    if (get_current_language() == 'en'){
	                        $provinces = json_decode($provs->provinces_en, true);
	                    } else {
	                        $provinces = json_decode($provs->provinces_fr, true);
	                    }

	                    $minObj = elgg_get_entities(array(
	                        'type' => 'object',
	                        'subtype' => 'ministries',
	                    ));
	                    $mins = get_entity($minObj[0]->guid);

	                    $ministries = array();
	                    if (get_current_language() == 'en'){
	                        $ministries = json_decode($mins->ministries_en, true);
	                    } else {
	                        $ministries = json_decode($mins->ministries_fr, true);
	                    }

	                    $department = $provinces[$userObj->provincial];
	                    if( $userObj->ministry && $userObj->ministry !== "default_invalid_value" ){
	                        $department .= ' / ' . $ministries[$userObj->provincial][$userObj->ministry];
	                    }
	                    break;
	                default:
	                    $department = $userObj->$userType;
            	}

				echo '<div class="col-xs-12 mrgn-tp-sm  clearfix mrgn-bttm-sm">
				    <div class="mrgn-tp-sm col-xs-2">';
				    if( $display_avatar == 'yes' ){
				    	echo '<a href="' . elgg_get_site_url() . 'profile/' . $userObj->username . '">
								<img src="' . $userObj->getIconURL() . '" alt="' . $userObj->getDisplayName() . '" title="' . $userObj->getDisplayName() . '" class="img-responsive img-circle">
							</a>';
					}
					echo '</div>
					<div class="mrgn-tp-sm col-xs-10 noWrap">
						<span class="mrgn-bttm-0 summary-title">
							<a href="' . elgg_get_site_url() . 'profile/' . $userObj->username . '" rel="me">' . $userObj->getDisplayName() . '</a>
						</span>
						<div class=" mrgn-bttm-sm mrgn-tp-sm  timeStamp clearfix">' . $department . '</div>
					</div>
				</div>';
			}
		}
	}
?>        