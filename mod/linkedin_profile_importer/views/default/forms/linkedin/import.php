<?php

$ha = new ElggHybridAuth();
$adapter = $ha->getAdapter('LinkedIn');
$adapter->adapter->api->setResponseFormat('JSON');

$details_api_result = $adapter->adapter->api->profile("~:(public-profile-url,picture-urls::(original),summary,headline,location,industry,associations,interests,languages,skills,date-of-birth,phone-numbers,im-accounts,main-address,twitter-accounts)");
$details_json_result = $details_api_result['linkedin'];
$details = json_decode($details_json_result);

// If auth token is invalid, prompt user to re-auth
if(strpos($details->message, 'unauthorized') !== false){
	$user = get_loggedin_user();

	$adapter = $ha->getAdapter('linkedin');
	if ($adapter->isUserConnected()) {
		$adapter->logout();
	}

	elgg_unset_plugin_user_setting('linkedin:uid', $user->guid, 'linkedin_profile_importer');
	elgg_trigger_plugin_hook('hybridauth:deauthenticate', 'linkedin', array('entity' => $user));

	$forward_url = elgg_get_site_url() . 'linkedin/import';
	forward($forward_url);
}

echo '<div class="hybridauth-linkedin-instructions mam">';
echo elgg_echo('linkedin:import:instructions');
echo '</div>';

$tag_names = elgg_trigger_plugin_hook('linkedin:fields', 'profile', NULL, array());

if ($tag_names) {
	echo '<div class="panel panel-custom">';
	echo '<div class="panel-heading"><h2 class="profile-info-head panel-title">' . elgg_echo('linkedin:general') . '</h2></div>';
	echo '<div class="panel-body" style="padding-top: 15px;">';

	if($details->pictureUrls->values[0]){
		echo '<div class="col-sm-4">';
	    echo '<div class="elgg-image-block">';
		echo '<div class="elgg-body">';

		echo '<label>' . elgg_view('input/checkbox', array(
			'name' => "tags[pictureUrls][import]",
			'value' => 'yes',
			'checked' => 'checked',
		)) . '<span class="mrgn-lft-sm">' . elgg_echo("linkedin:profile:picture-url") . '</span></label>';
		echo elgg_view('input/hidden', array(
			'name' => "tags[pictureUrls][name]",
			'value' => "picture-url"
		));
		echo '</div></div>';

		$image_url = $details->pictureUrls->values[0];
		echo elgg_view('output/img', array(
	    	'src' => $image_url,
	    	'style' => 'max-width: 100%;',
	    ));
	    echo elgg_view('input/hidden', array(
			'name' => "tags[pictureUrls][value]",
			'value' => $image_url
		));

		echo '</div><div class="col-sm-8">';
	}

	foreach ($tag_names as $tag => $tag_name) {

		$value = $details->$tag;

		if (!$value || $tag == 'pictureUrls') {
			continue;
		}

		echo '<div class="elgg-image-block mbl">';
		echo '<div class="elgg-body">';

		echo '<label>' . elgg_view('input/checkbox', array(
			'name' => "tags[$tag][import]",
			'value' => 'yes',
			'checked' => 'checked',
		)) . '<span class="mrgn-lft-sm">' . elgg_echo("linkedin:profile:$tag_name") . '</span></label>';
		echo elgg_view('input/hidden', array(
			'name' => "tags[$tag][name]",
			'value' => $tag_name
		));

		switch ($tag) {

			case 'summary' :
			case 'headline' :
			case 'industry' :
			case 'mainAddress' :
				echo elgg_view('output/text', array('value' => $value));
				echo elgg_view('input/hidden', array(
					'name' => "tags[$tag][value]",
					'value' => $value
				));
				break;

			case 'location' :
				echo elgg_view('input/hidden', array(
					'name' => "tags[$tag][value]",
					'value' => $value->name
				));
				// echo elgg_view('output/location', array(
				// 	'value' => $value->name
				// ));
				echo elgg_view('output/text', array(
					'value' => $value->name
				));
				break;

			case 'languages' :
				$new_value = array();
				foreach ($value->values as $obj) {
					$new_value[] = $obj->language->name;
					echo elgg_view('input/hidden', array(
						'name' => "tags[$tag][value][]",
						'value' => $obj->language->name
					));
				}
				echo elgg_view('output/tags', array(
					'value' => $new_value,
					'icon_class' => "elgg-icon-$tag_name"
				));
				break;

			case 'skills' :
				$new_value = array();
				foreach ($value->values as $obj) {
					$new_value[] = $obj->skill->name;
					echo elgg_view('input/hidden', array(
						'name' => "tags[$tag][value][]",
						'value' => $obj->skill->name
					));
				}
				echo elgg_view('output/tags', array(
					'value' => $new_value,
					'icon_class' => "elgg-icon-$tag_name"
				));
				break;

			case 'phoneNumbers' :
				$new_value = array();
				foreach ($value->values as $obj) {
					$new_value[] = $obj->phoneNumber;
					echo elgg_view('input/hidden', array(
						'name' => "tags[$tag][value][]",
						'value' => $obj->phoneNumber
					));
				}
				echo elgg_view('output/tags', array(
					'value' => $new_value,
					'icon_class' => "elgg-icon-$tag_name"
				));
				break;

			case 'twitterAccounts' :
				$new_value = array();
				foreach ($value->values as $obj) {
					$new_value[] = $obj->providerAccountName;
					echo elgg_view('input/hidden', array(
						'name' => "tags[$tag][value][]",
						'value' => $obj->providerAccountName
					));
				}
				echo elgg_view('output/tags', array(
					'value' => $new_value,
					'icon_class' => "elgg-icon-$tag_name"
				));
				break;

			case 'honorsAwards' :
			case 'associations' :
			case 'interests' :
			case 'specialties' :
				$new_value = $value = string_to_tag_array($value);
				foreach ($new_value as $val) {
					echo elgg_view('input/hidden', array(
						'name' => "tags[$tag][value][]",
						'value' => $val
					));
				}
				echo elgg_view('output/tags', array(
					'name' => "tags[$tag][value]",
					'value' => $new_value,
					'icon_class' => "elgg-icon-$tag_name"
				));
				break;

			case 'dateOfBirth' :
				$time = mktime(0, 0, 0, $value->month, $value->day, $value->year);
				echo elgg_view('input/hidden', array(
					'name' => "tags[$tag][value]",
					'value' => $time
				));
				echo elgg_view_icon('calendar') . '<span>' . elgg_view('output/date', array('value' => date('F j, Y', $time))) . '</span>';
				break;

			case 'publicProfileUrl' :
				$linkedin_url = substr($value, strrpos($value, '/') + 1);
				echo '<a href="' . $value .'" target="_blank">' . $value . '</a>';
				echo elgg_view('input/hidden', array(
					'name' => "tags[$tag][value]",
					'value' => $linkedin_url
				));
				break;
		}
		echo '</div>';
		echo '</div>';
	}

	if($details->pictureUrls){
		echo '</div>';
	}

	echo '</div></div>';
}

$linkedin_api_result = $adapter->adapter->api->profile("~:(positions:(id,title,company:(name)),projects:(id,name),educations:(id,degree,school-name,field-of-study),publications:(id,title),patents:(id,title),certifications:(id,name,authority),courses:(id,name),volunteer:(volunteer-experiences:(id,role,organization)),recommendations-received:(id,recommender))");
$linkedin_json_result = $linkedin_api_result['linkedin'];
$linkedin = json_decode($linkedin_json_result);

if (LINKEDIN_POSITION_SUBTYPE) {
	if ($linkedin->positions->_total > 0) {

		foreach ($linkedin->positions->values as $position) {
			$label = elgg_echo('linkedin:position:label', array($position->title, $position->company->name));
			$positions_options[$label] = $position->id;
		}

		echo '<div class="panel panel-custom">';
		echo '<div class="panel-heading"><h2 class="profile-info-head panel-title">' . elgg_echo('linkedin:positions') . '</h2></div>';
		echo '<div class="panel-body"><p>' . elgg_echo('linkedin:positions:select') . '</p>';

		foreach ($linkedin->positions->values as $key => $position) {
			$label = elgg_echo('linkedin:position:label', array($position->title, $position->company->name));
			echo (($key + 1) == count($linkedin->positions->values)) ? '<div>' : '<div style="margin-bottom: 15px;">';
			echo elgg_view('input/checkbox', array(
				'name' => "positions[]",
				'value' => $position->id,
				'checked' => ($linkedin->positions->_total == 1) ? true : false
			)) . ' ' . $label . '</div>';
		}

		echo '</div></div>';
	}
}

if (LINKEDIN_PROJECT_SUBTYPE) {
	if ($linkedin->projects->_total > 0) {

		foreach ($linkedin->projects->values as $project) {
			$label = $project->name;
			$projects_options[$label] = $project->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:projects') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:projects:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'projects',
			'options' => $projects_options
		));

		echo '</fieldset>';
	}
}

if (LINKEDIN_EDUCATION_SUBTYPE) {
	if ($linkedin->educations->_total > 0) {

		foreach ($linkedin->educations->values as $education) {
			if ($education->degree) {
				$label = "$education->degree, ";
			}
			$label .= "$education->fieldOfStudy, $education->schoolName";
			$educations_options[$label] = $education->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:educations') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:educations:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'educations',
			'options' => $educations_options
		));

		echo '</fieldset>';
	}
}

if (LINKEDIN_PUBLICATION_SUBTYPE) {

	if ($linkedin->publications->_total > 0) {

		foreach ($linkedin->publications->values as $publication) {
			$publications_options[$publication->title] = $publication->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:publications') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:publications:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'publications',
			'options' => $publications_options
		));

		echo '</fieldset>';
	}
}

if (LINKEDIN_PATENT_SUBTYPE) {

	if ($linkedin->patents->_total > 0) {

		foreach ($linkedin->patents->values as $patent) {
			$patents_options[$patent->title] = $patent->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:patents') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:patents:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'patents',
			'options' => $patents_options
		));

		echo '</fieldset>';
	}
}


if (LINKEDIN_CERTIFICATION_SUBTYPE) {
	
	if ($linkedin->certifications->_total > 0) {

		foreach ($linkedin->certifications->values as $certification) {
			$label = elgg_echo('linkedin:certifications:label', array($certification->name, $certification->authority->name));
			$certifications_options[$label] = $certification->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:certifications') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:certifications:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'certifications',
			'options' => $certifications_options
		));

		echo '</fieldset>';
	}
}


if (LINKEDIN_COURSE_SUBTYPE) {

	if ($linkedin->courses->_total > 0) {

		foreach ($linkedin->courses->values as $course) {
			$courses_options[$course->name] = $course->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:courses') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:courses:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'courses',
			'options' => $courses_options
		));

		echo '</fieldset>';
	}
}

if (LINKEDIN_VOLUNTEER_SUBTYPE) {

	/**
	 * @todo: add 'causes', 'supportedOrganizations'
	 */

	if ($linkedin->volunteer->volunteerExperiences->_total > 0) {

		foreach ($linkedin->volunteer->volunteerExperiences->values as $volunteer_experience) {
			$label = elgg_echo('linkedin:volunteer_experiences:label', array($volunteer_experience->role, $volunteer_experience->organization->name));
			$volunteer_experiences_options[$label] = $volunteer_experience->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:volunteer_experiences') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:volunteer_experiences:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'volunteer_experiences',
			'options' => $volunteer_experiences_options
		));

		echo '</fieldset>';
	}
}


if (LINKEDIN_RECOMMENDATION_SUBTYPE) {

	if ($linkedin->recommendationsReceived->_total > 0) {

		foreach ($linkedin->recommendationsReceived->values as $recommendation) {
			$label = elgg_echo('linkedin:recommendations:label', array($recommendation->recommender->firstName, $recommendation->recommender->lastName));
			$recommendations_options[$label] = $recommendation->id;
		}

		echo '<fieldset>';
		echo '<legend>' . elgg_echo('linkedin:recommendations') . '</legend>';

		echo '<label>' . elgg_echo('linkedin:recommendations:select') . '</label>';
		echo elgg_view('input/checkboxes', array(
			'name' => 'recommendations',
			'options' => $recommendations_options
		));

		echo '</fieldset>';
	}
}

echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('linkedin:submit'), 'class' => 'btn-primary pull-right mls', 'onclick' => 'ga(\'send\', \'event\', {\'eventCategory\': \'LinkedIn\',\'eventAction\': \'Save\',\'eventLabel\': \'' . get_loggedin_user()->name . '\'});'));
echo elgg_view('output/url', array('text' => elgg_echo('linkedin:cancel'), 'class' => 'btn btn-default pull-right', 'href' => elgg_get_site_url() . 'profile/' . get_loggedin_user()->username));
echo '</div>';
