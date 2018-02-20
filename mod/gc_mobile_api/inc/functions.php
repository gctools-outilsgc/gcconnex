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
