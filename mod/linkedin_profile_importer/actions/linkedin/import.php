<?php

function resizeImage($image, $maxwidth, $maxheight, $square = false, $upscale = false) {
    // Get the size information from the image
	$imgsizearray = getimagesizefromstring($image);
	if ($imgsizearray == false) {
	    return false;
	}
	
	$width = $imgsizearray[0];
	$height = $imgsizearray[1];

    // load original image
    $original_image = imagecreatefromstring($image);
 
    // allocate the new image
    $new_image = imagecreatetruecolor($maxwidth, $maxheight);
    if (!$new_image) {
        return false;
    }

    // color transparencies white (default is black)
    imagefilledrectangle(
        $new_image, 0, 0, $maxwidth, $maxheight,
        imagecolorallocate($new_image, 255, 255, 255)
    );

	$rtn_code = imagecopyresampled( $new_image, $original_image, 0, 0, 0, 0, $maxwidth, $maxheight, $width, $height );

	if (!$rtn_code) {
	    return false;
	}
	
	// grab a compressed jpeg version of the image
	ob_start();
	imagejpeg($new_image, null, 90);
	$jpeg = ob_get_clean();
	
	imagedestroy($new_image);
	imagedestroy($original_image);
	
	return $jpeg;
}

$user = elgg_get_logged_in_user_entity();

$tags = get_input('tags');

$default_access = ACCESS_LOGGED_IN;

$successMessage = false;

if ($tags) {

	$changed = array();

	foreach ($tags as $tag => $details) {

		$tag_import = elgg_extract('import', $details, false);

		if ($tag_import != 'yes') {
			continue;
		}

		$action = 'update_tags';

		$tag_name = elgg_extract('name', $details, $tag);
		$tag_values = elgg_extract('value', $details, '');

		if (!$tag_values) {
			$error = true;
			continue;
		}

		$changed[] = $tag_name;

		if($tag_name == "picture-url"){
			$icon_sizes = elgg_get_config('icon_sizes');

			// get the images and save their file handlers into an array
			// so we can do clean up if one fails.
			$files = array();
			$image = file_get_contents($tag_values);
			foreach ($icon_sizes as $name => $size_info) {
				$resized = resizeImage($image, $size_info['w'], $size_info['h'], $size_info['square'], $size_info['upscale']);

				if ($resized) {
					//@todo Make these actual entities.  See exts #348.
					$guid = $user->guid;
					$file = new ElggFile();
					$file->owner_guid = $guid;
					$file->setFilename("profile/{$guid}{$name}.jpg");
					$file->open('write');
					$file->write($resized);
					$file->close();
					$files[] = $file;
				} else {
					// cleanup on fail
					foreach ($files as $file) {
						$file->delete();
					}

					register_error(elgg_echo('avatar:resize:fail'));
					forward(REFERER);
				}
			}

			$user->icontime = time();
			if (elgg_trigger_event('profileiconupdate', $user->type, $user)) {
				$view = 'river/user/default/profileiconupdate';
				elgg_delete_river(array('subject_guid' => $user->guid, 'view' => $view));
				elgg_create_river_item(array(
					'view' => $view,
					'action_type' => 'update',
					'subject_guid' => $user->guid,
					'object_guid' => $user->guid,
				));
			}
		} else if($tag_name == "profile-url"){
			$user->set("linkedin", $tag_values);
		} else if (is_array($tag_values)) {
			if (!is_array($tag_name)) {
				elgg_delete_metadata(array(
					'guids' => $user->guid,
					'metadata_names' => $tag_name,
					'limit' => 0
				));
				foreach ($tag_values as $tag_value) {
					$id = create_metadata($user->guid, $tag_name, $tag_value, '', $user->guid, $default_access, true);
					if (!$id) {
						$error = true;
					}
				}
			} else {
				for ($i = 0; $i < count($tag_values); $i++) {
					$tag_name_part = elgg_extract($i, $tag_name, $tag_name[0]);
					$id = create_metadata($user->guid, $tag_name_part, $tag_values[$i], '', $user->guid, $default_access);
					if (!$id) {
						$error = true;
					}
				}
			}
		} else {
			$id = create_metadata($user->guid, $tag_name, $tag_values, '', $user->guid, $default_access);
			if (!$id) {
				$error = true;
			}
		}
	}

	if ($action == 'update_tags') {
		if ($error) {
			register_error(elgg_echo('linkedin:general:error', array($tag_name)));
		} else {
			if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }

			foreach($changed as $tag){
				system_message(elgg_echo('linkedin:general:success:' . $tag));
			}
		}
	}
}

$ha = new ElggHybridAuth();
$adapter = $ha->getAdapter('LinkedIn');
$adapter->adapter->api->setResponseFormat('JSON');

$positions_input = get_input('positions');

if (is_array($positions_input)) {

	$positions_api_result = $adapter->adapter->api->profile("~:(positions)");
	$positions_json_result = $positions_api_result['linkedin'];
	$positions = json_decode($positions_json_result);

	foreach ($positions->positions->values as $position) {
		if (!in_array($position->id, $positions_input)) {
			continue;
		}

        $validInput = true;
        if(trim($position->title) == '' || trim($position->company->name) == ''){
            $validInput = false;
            $error = true;
        }

        if($validInput == true) {

			$action = 'import';

			if( $position->title ){
				$user->set("job", htmlentities($position->title));
			}

            $experience = new ElggObject();
            $experience->subtype = "experience";
            $experience->owner_guid = $user->guid;
            $experience->title = htmlentities($position->title);
            $experience->description = htmlentities($position->summary);
            $experience->organization = htmlentities($position->company->name);

            $experience->startdate = $position->startDate->month;
            $experience->startyear = $position->startDate->year;

			if ($position->isCurrent) {
				$experience->ongoing = "true";
				$experience->enddate = "";
				$experience->endyear = "";
			} else {
				$experience->ongoing = "false";
				$experience->enddate  = $position->endDate->month;
				$experience->endyear = $position->endDate->year;
			}

            $experience->responsibilities = trim($position->summary);
            $experience->colleagues = "";
            $experience->access_id = $default_access;

        	if ($new_eguid = $experience->save()) {
            	$work_experience_guids[] = $new_eguid;
            	if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
				system_message(elgg_echo('linkedin:general:success:position', array($experience->title)));
			} else {
				system_message(elgg_echo('linkedin:position:error', array($experience->title)));
			}
        }
    }

    if ($user->work == NULL) {
        $user->work = $work_experience_guids;
    } else {
        $stack = $user->work;
        if (!(is_array($stack))) { $stack = array($stack); }

        if ($work_experience_guids != NULL) {
            $user->work = array_merge($stack, $work_experience_guids);
        }
    }
    $user->work_access = $default_access;
    $user->save();
}


$projects_input = get_input('projects');

if (is_array($projects_input)) {

	$user_projects = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_PROJECT_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_projects) {
		foreach ($user_projects as $user_project) {
			$linkedin[$user_project->linkedin_id] = $user_project;
		}
	}

	$projects_api_result = $adapter->adapter->api->profile("~:(projects)");
	$projects_json_result = $projects_api_result['linkedin'];
	$projects = json_decode($projects_json_result);

	foreach ($projects->projects->values as $project) {
		if (!in_array($project->id, $projects_input)) {
			continue;
		}

		if ($linkedin[$project->id]) {
			$action = 'update';
			$object = $linkedin[$project->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_PROJECT_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $project->id;
		}

		$object->title = $project->name;
		$object->description = $project->description;
		$object->address = $project->url;

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:project:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:project:error', array($object->title)));
		}
	}
}


$educations_input = get_input('educations');

if (is_array($educations_input)) {

	$user_educations = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_EDUCATION_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_educations) {
		foreach ($user_educations as $user_education) {
			$linkedin[$user_education->linkedin_id] = $user_education;
		}
	}

	$educations_api_result = $adapter->adapter->api->profile("~:(educations)");
	$educations_json_result = $educations_api_result['linkedin'];
	$educations = json_decode($educations_json_result);

	foreach ($educations->educations->values as $education) {
		if (!in_array($education->id, $educations_input)) {
			continue;
		}

		if ($linkedin[$education->id]) {
			$action = 'update';
			$object = $linkedin[$education->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_EDUCATION_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $education->id;
		}

		$object->title = $education->schoolName;
		$object->description = $education->fieldOfStudy;
		$object->degree = $education->degree;
		$object->activities = $education->activities;
		$object->notes = $education->notes;

		$object->calendar_start_year = $education->startDate->year;
		$object->calendar_end_year = $education->endDate->year;

		if ($education->degree) {
			$label = "$education->degree, ";
		}
		$label .= "$education->fieldOfStudy, $education->schoolName";

		if ($action == 'import') {
			create_metadata($user->guid, 'school', $label, 'text', $user->guid, $default_access, true);
		}

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:education:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:education:error', array($object->title)));
		}
	}
}


$publications_input = get_input('publications');

if (is_array($publications_input)) {

	$user_publications = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_PUBLICATION_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_publications) {
		foreach ($user_publications as $user_publication) {
			$linkedin[$user_publication->linkedin_id] = $user_publication;
		}
	}

	$publications_api_result = $adapter->adapter->api->profile("~:(publications:(id,title,publisher,authors,date,url,summary))");
	$publications_json_result = $publications_api_result['linkedin'];
	$publications = json_decode($publications_json_result);

	foreach ($publications->publications->values as $publication) {
		if (!in_array($publication->id, $publications_input)) {
			continue;
		}

		if ($linkedin[$publication->id]) {
			$action = 'update';
			$object = $linkedin[$publication->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_PUBLICATION_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $publication->id;
		}

		$object->title = $publication->title;
		$object->description = $publication->summary;
		$object->address = $publication->url;
		$object->date = mktime(0, 0, 0, $publication->date->month, $publication->date->day, $publication->date->year);
		$object->publisher = $publication->publisher->name;

		if ($publication->authors->_total > 0) {
			foreach ($publication->authors->values as $author) {
				$pub_authors[] = ($author->person) ? "{$author->person->firstName} {$author->person->lastName}" : $author->name;
				if ($author->person) {
					$pub_authors_ids[] = $author->person->id;
				}
			}
			$object->authors = $pub_authors;
			$object->author_linkedin_id = $pub_authors_ids;
		}

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:publication:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:publication:error', array($object->title)));
		}
	}
}


$patents_input = get_input('patents');

if (is_array($patents_input)) {

	$user_patents = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_PATENT_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_patents) {
		foreach ($user_patents as $user_patent) {
			$linkedin[$user_patent->linkedin_id] = $user_patent;
		}
	}

	$patents_api_result = $adapter->adapter->api->profile("~:(patents:(id,title,summary,number,status,office,inventors,date,url))");
	$patents_json_result = $patents_api_result['linkedin'];
	$patents = json_decode($patents_json_result);

	foreach ($patents->patents->values as $patent) {
		if (!in_array($patent->id, $patents_input)) {
			continue;
		}

		if ($linkedin[$patent->id]) {
			$action = 'update';
			$object = $linkedin[$patent->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_PATENT_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $patent->id;
		}

		$object->title = $patent->title;
		$object->description = $patent->summary;
		$object->number = $patent->number;
		$object->office = $patent->office->name;
		$object->status = $patent->status;
		$object->address = $patent->url;
		$object->date = mktime(0, 0, 0, $patent->date->month, $patent->date->day, $patent->date->year);

		if ($patent->inventors->_total > 0) {
			foreach ($patent->inventors->values as $inventor) {
				$patent_inventors[] = ($inventor->person) ? "{$inventor->person->firstName} {$inventor->person->lastName}" : $inventor->name;
				if ($inventor->person) {
					$patent_inventor_ids[] = $inventor->person->id;
				}
			}
			$object->inventors = $patent_inventors;
			$object->inventor_linkedin_ids = $patent_inventor_ids;
		}

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:patent:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:patent:error', array($object->title)));
		}
	}
}

$certifications_input = get_input('certifications');

if (is_array($certifications_input)) {

	$user_certifications = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_CERTIFICATION_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_certifications) {
		foreach ($user_certifications as $user_certification) {
			$linkedin[$user_certification->linkedin_id] = $user_certification;
		}
	}

	$certifications_api_result = $adapter->adapter->api->profile("~:(certifications:(id,name,authority,number,start-date,end-date,url))");
	$certifications_json_result = $certifications_api_result['linkedin'];
	$certifications = json_decode($certifications_json_result);

	foreach ($certifications->certifications->values as $certification) {
		if (!in_array($certification->id, $certifications_input)) {
			continue;
		}

		if ($linkedin[$certification->id]) {
			$action = 'update';
			$object = $linkedin[$certification->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_CERTIFICATION_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $certification->id;
		}

		$object->title = $certification->name;
		$object->description = '';
		$object->number = $certification->number;
		$object->authority = $certification->authority->name;
		$object->address = $certification->url;
		
		if ($certification->startDate) {
			$object->calendar_start = mktime(0, 0, 0, $certification->startDate->month, $certification->startDate->day, $certification->startDate->year);
		}
		if ($certification->endDate) {
			$object->calendar_end = mktime(0, 0, 0, $certification->endDate->month, $certification->endDate->day, $certification->endDate->year);
		}

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:certification:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:certification:error', array($object->title)));
		}
	}
}

$courses_input = get_input('courses');

if (is_array($courses_input)) {

	$user_courses = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_COURSE_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_courses) {
		foreach ($user_courses as $user_course) {
			$linkedin[$user_course->linkedin_id] = $user_course;
		}
	}

	$courses_api_result = $adapter->adapter->api->profile("~:(courses:(id,name,number))");
	$courses_json_result = $courses_api_result['linkedin'];
	$courses = json_decode($courses_json_result);

	foreach ($courses->courses->values as $course) {
		if (!in_array($course->id, $courses_input)) {
			continue;
		}

		if ($linkedin[$course->id]) {
			$action = 'update';
			$object = $linkedin[$course->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_COURSE_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $course->id;
		}

		$object->title = $course->name;
		$object->description = '';
		$object->number = $course->number;

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:course:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:course:error', array($object->title)));
		}
	}
}


$volunteer_experiences_input = get_input('volunteer_experiences');

if (is_array($volunteer_experiences_input)) {

	$user_volunteer_experiences = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_VOLUNTEER_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_volunteer_experiences) {
		foreach ($user_volunteer_experiences as $user_volunteer_experience) {
			$linkedin[$user_volunteer_experience->linkedin_id] = $user_volunteer_experience;
		}
	}

	$volunteer_api_result = $adapter->adapter->api->profile("~:(volunteer:(volunteer-experiences:(id,role,organization,cause,start-date,end-date,description)))");
	$volunteer_json_result = $volunteer_api_result['linkedin'];
	$volunteer = json_decode($volunteer_json_result);
	
	$volunteer_experiences = $volunteer->volunteer->volunteerExperiences;

	foreach ($volunteer_experiences->values as $volunteer_experience) {
		
		if (!in_array($volunteer_experience->id, $volunteer_experiences_input)) {
			continue;
		}

		if ($linkedin[$volunteer_experience->id]) {
			$action = 'update';
			$object = $linkedin[$volunteer_experience->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_VOLUNTEER_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $volunteer_experience->id;
		}

		$object->title = $volunteer_experience->role;
		$object->description = $volunteer_experience->description;
		$object->company = $volunteer_experience->organization->name;
		$object->company_linkedin_id = $volunteer_experience->organization->id;
		$object->cause = $volunteer_experience->cause->name;

		if ($volunteer_experience->startDate) {
			$object->calendar_start = mktime(0, 0, 0, $volunteer_experience->startDate->month, $volunteer_experience->startDate->day, $volunteer_experience->startDate->year);
		}
		if ($volunteer_experience->endDate) {
			$object->calendar_end = mktime(0, 0, 0, $volunteer_experience->endDate->month, $volunteer_experience->endDate->day, $volunteer_experience->endDate->year);
		}

		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:volunteer_experience:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:volunteer_experience:error', array($object->title)));
		}
	}
}


$recommendations_input = get_input('recommendations');

if (is_array($recommendations_input)) {

	$user_recommendations = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => LINKEDIN_RECOMMENDATION_SUBTYPE,
		'owner_guid' => $user->guid,
		'metadata_names' => 'linkedin_id',
		'limit' => false
	));

	$linkedin = array();
	if ($user_recommendations) {
		foreach ($user_recommendations as $user_recommendation) {
			$linkedin[$user_recommendation->linkedin_id] = $user_recommendation;
		}
	}

	$recommendations_api_result = $adapter->adapter->api->profile("~:(recommendations-received)");
	$recommendations_json_result = $recommendations_api_result['linkedin'];
	$recommendations = json_decode($recommendations_json_result);
	
	foreach ($recommendations->recommendationsReceived->values as $recommendation) {
		
		if (!in_array($recommendation->id, $recommendations_input)) {
			continue;
		}

		if ($linkedin[$recommendation->id]) {
			$action = 'update';
			$object = $linkedin[$recommendation->id];
		} else {
			$action = 'import';
			$object = new ElggObject();
			$object->subtype = LINKEDIN_RECOMMENDATION_SUBTYPE;
			$object->owner_guid = $user->guid;
			$object->access_id = $default_access;

			$object->linkedin_id = $recommendation->id;
		}

		$object->title = '';
		$object->description = $recommendation->recommendationText;
		$object->recommendation_type = $recommendation->recommendationType->code;

		$object->recommender = "{$recommendation->recommender->firstName} {$recommendation->recommender->lastName}";
		$object->recommender_linkedin_id = $recommendation->recommender->id;
		
		if ($object->save()) {
            if(!$successMessage){ system_message(elgg_echo('linkedin:general:success')); $successMessage = true; }
			system_message(elgg_echo('linkedin:recommendation:success:' . $action, array($object->title)));
		} else {
			system_message(elgg_echo('linkedin:recommendation:error', array($object->title)));
		}
	}
}

forward('profile');
