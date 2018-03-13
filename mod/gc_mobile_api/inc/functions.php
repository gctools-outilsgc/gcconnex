<?php
/*
 * GC Mobile API functions.php
 */

function get_user_block($userid, $lang = "en")
{
	$user_entity = is_numeric($userid) ? get_user($userid) : (strpos($userid, '@') !== false ? get_user_by_email($userid)[0] : get_user_by_username($userid));

	if (!$user_entity) {
		return "";
	}

	if (!$user_entity instanceof ElggUser) {
		return "";
	}

	$user = array();
	$user['user_id'] = $user_entity->guid;
	$user['username'] = $user_entity->username;
	$user['displayName'] = $user_entity->name;
	$user['email'] = $user_entity->email;
	$user['profileURL'] = $user_entity->getURL();
	$user['iconURL'] = $user_entity->getIconURL();
	$user['dateJoined'] = date("Y-m-d H:i:s", $user_entity->time_created);

	$userType = $user_entity->user_type;
	$user['user_type'] = elgg_echo("gcRegister:occupation:{$userType}", [], $lang);
	$department = "";

	if ($userType == 'federal') {
		$deptObj = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'federal_departments',
		));
		$depts = get_entity($deptObj[0]->guid);

		$federal_departments = array();
		if ($lang == 'en') {
			$federal_departments = json_decode($depts->federal_departments_en, true);
		} else {
			$federal_departments = json_decode($depts->federal_departments_fr, true);
		}

		$department = $federal_departments[$user_entity->federal];

		// otherwise if user is student or academic
	} elseif ($userType == 'student' || $userType == 'academic') {
		$institution = $user_entity->institution;
		$department = ($institution == 'university') ? $user_entity->university : ($institution == 'college' ? $user_entity->college : $user_entity->highschool);

		// otherwise if user is provincial employee
	} elseif ($userType == 'provincial') {
		$provObj = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'provinces',
		));
		$provs = get_entity($provObj[0]->guid);

		$provinces = array();
		if ($lang == 'en') {
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
		if ($lang == 'en') {
			$ministries = json_decode($mins->ministries_en, true);
		} else {
			$ministries = json_decode($mins->ministries_fr, true);
		}

		$department = $provinces[$user_entity->provincial];
		if ($user_entity->ministry && $user_entity->ministry !== "default_invalid_value") {
			$department .= ' / ' . $ministries[$user_entity->provincial][$user_entity->ministry];
		}

		// otherwise show basic info
	} else {
		$department = $user_entity->$userType;
	}
	$user['organization'] = $department;
	$user['job'] = $user_entity->job;

	return $user;
}

function get_entity_comments($guid)
{
	$entity = get_entity($guid);

	$comments = array();
	$comments['count'] = $entity->countComments();
	$commentEntites = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'comment',
		'container_guid' => $entity->guid,
		'order_by' => 'time_created asc'
	));

	$i = 0;
	foreach ($commentEntites as $comment) {
		$i++;
		$comments['comment_'.$i] = array('comment_user'=>get_userBlock($comment->getOwner()),'comment_text'=>$comment->description,'comment_date'=>date("Y-m-d H:i:s", $comment->time_created));
	}
	return $comments;
}

function wire_filter($text)
{
	$site_url = elgg_get_site_url();

	$text = ''.$text;

	// email addresses
	$text = preg_replace('/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i', '$1<a href="mailto:$2@$3">$2@$3</a>', $text);

	// links
	$text = parse_urls($text);

	// usernames
	$text = preg_replace('/(^|[^\w])@([\p{L}\p{Nd}._]+)/u', '$1<a href="' . $site_url . 'thewire/owner/$2">@$2</a>', $text);

	// hashtags
	$text = preg_replace('/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/', '$1<a href="' . $site_url . 'thewire/tag/$2">#$2</a>', $text);

	$text = trim($text);

	return $text;
}

function clean_text($text)
{
	return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($text))))));
}

function replace_accents($str)
{
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	return str_replace($a, $b, $str);
}

function create_username($str, $a_char = array("'", "-", "."))
{
	$string = replace_accents(mb_strtolower(strtok($str, '@')));
	foreach ($a_char as $temp) {
		$pos = strpos($string, $temp);
		if ($pos) {
			$mend = '';
			$a_split = explode($temp, $string);
			foreach ($a_split as $temp2) {
				$mend .= ucfirst($temp2).$temp;
			}
			$string = substr($mend, 0, -1);
		}
	}
	return ucfirst($string);
}

elgg_ws_expose_function(
	"query.posts",
	"query_the_posts",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"password" => array('type' => 'string', 'required' => true),
		"object" => array('type' => 'string', 'required' => false, 'default' => ""),
		"query" => array('type' => 'string', 'required' => false, 'default' => ""),
		"group" => array('type' => 'string', 'required' => false, 'default' => ""),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"from_date" => array('type' => 'string', 'required' => false, 'default' => ""),
		"to_date" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Query GCcollab data based on user-given parameters',
	'POST',
	false,
	false
);

function query_the_posts($user, $password, $object, $query, $group, $limit, $offset, $from_date, $to_date, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

    $valid = elgg_authenticate($user_entity->username, $password);

    $type = "object";
    $subtype = "";
    switch ($object) {
    	case "blog":
    		$subtype = "blog";
        	break;
        case "discussion":
    		$subtype = "groupforumtopic";
        	break;
        case "event":
    		$subtype = "event_calendar";
        	break;
        case "group":
    		$type = "group";
        	break;
        case "opportunity":
    		$subtype = "mission";
        	break;
        case "wire":
    		$subtype = "thewire";
        	break;
        default:
    		return "Please use one of the following object types: 'blog', 'discussion', 'event', 'group', 'opportunity', 'wire'";
        	break;
	}

    $data = "Username/password combination is not correct.";
	if ($valid === true) {
		if (!elgg_is_logged_in()) {
			login($user_entity);
		}

		$db_prefix = elgg_get_config('dbprefix');

		$params = array(
			'type' => $type,
			'subtype' => $subtype,
			'limit' => $limit,
			'offset' => $offset
		);

		if ($query) {
			if ($object == "group") {
				$params['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
				$params['wheres'] = array("(ge.name LIKE '%" . $query . "%' OR ge.description LIKE '%" . $query . "%')");
			} else {
				$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
				$params['wheres'] = array("(oe.title LIKE '%" . $query . "%' OR oe.description LIKE '%" . $query . "%')");
			}
		}

		if ($group) {
			$params['container_guid'] = $group;
		}

		if ($from_date) {
			$params['joins'] = array("JOIN {$db_prefix}entities fd ON e.guid = fd.guid");
			$params['wheres'] = array("(fd.time_updated >= " . strtotime($from_date) . ")");
		}
		if ($to_date) {
			$params['joins'] = array("JOIN {$db_prefix}entities td ON e.guid = td.guid");
			$params['wheres'] = array("(td.time_updated <= " . strtotime($to_date) . ")");
		}

		$ia = elgg_set_ignore_access(true);
		$data = json_decode(elgg_list_entities_from_metadata($params));

		if( $object == "discussion" ){
			foreach ($data as $discussion) {
				$all_replies = elgg_list_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'discussion_reply',
					'container_guid' => $discussion->guid
				));
				$replies = json_decode($all_replies);

				if(count($replies) > 0) {
					$replies = array_reverse($replies);

					$discussionsArray = array();
					foreach ($replies as $reply) {
						$discussionsArray[] = $reply;
					}
					$discussion->replies = $discussionsArray;
				}
			}
		} else {
			foreach ($data as $item) {
				$replies = get_entity_comments($item->guid);
				if( $replies->count > 0 ){
					$item->replies = get_entity_comments($item->guid);
				}
			}
		}
		elgg_set_ignore_access($ia);
	}

	return $data;
}

elgg_ws_expose_function(
	"login.redirect",
	"login_and_redirect",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"password" => array('type' => 'string', 'required' => true),
		"redirect_en" => array('type' => 'string', 'required' => true),
		"redirect_fr" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Login user into GCcollab and redirect them',
	'POST',
	false,
	false
);

function login_and_redirect($user, $password, $redirect_en, $redirect_fr, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}
	if (!$user_entity instanceof ElggUser) {
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}

    $valid = elgg_authenticate($user_entity->username, $password);

	if ($valid === true) {
		login($user_entity);

		if($lang == "fr"){
			setcookie("gcconnex_lang", "fr");
			header("Location: $redirect_fr");
			exit();
		} else {
			setcookie("gcconnex_lang", "en");
			header("Location: $redirect_en");
			exit();
		}
	} else {
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}
}
