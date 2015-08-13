
<?php
// cyu - 01-21-2015: modified queries so that it reflects on variations of table names

function getGroupInformation_query($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT FROM_UNIXTIME(e.time_created, '%Y-%m-%d') AS time_created, eg.name, eg.description, ue.name AS username
	FROM ".$dbprefix."entities e, ".$dbprefix."groups_entity eg, ".$dbprefix."users_entity ue
	WHERE e.guid = eg.guid
		AND e.owner_guid = ue.guid
		AND e.guid = " . $group_guid . " 
	ORDER BY e.time_created DESC";
	
	return $query;
}

function getMemberInformation_query($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT ue.name, er.time_created, e.time_updated, er.relationship, ue.username, ue.language, ue.email
	FROM ".$dbprefix."entities e, ".$dbprefix."entity_relationships er, ".$dbprefix."users_entity ue
	WHERE e.guid = ue.guid 
		AND (er.guid_one =".$group_guid." OR er.guid_two = ".$group_guid.")
		AND (er.guid_one = ue.guid OR er.guid_two = ue.guid)
		AND er.relationship = 'member' 
	ORDER BY er.time_created DESC";

	return $query;
}

function getGroupActivityInformation_query($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT e.guid, e.subtype, e.owner_guid, e.container_guid, e.time_created, e.time_updated, e.last_action, es.subtype, title, description, ue.name
	FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue
	WHERE e.container_guid = ".$group_guid."
		AND e.subtype = es.id
		AND oe.guid = e.guid
		AND ue.guid = e.owner_guid 
	ORDER BY e.time_created DESC";

	return $query;
}

function getDiscussionReplies_query($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT e.guid, a.time_created, ms.string, e.subtype, oe.title, oe.description, ue.name, ue.username
	FROM ".$dbprefix."annotations a, ".$dbprefix."metastrings ms, ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue
	WHERE a.value_id = ms.id
		AND e.guid = a.entity_guid
		AND e.container_guid =".$group_guid."
		AND es.id = e.subtype
		AND oe.guid = e.guid
		AND e.subtype = 7
		AND e.owner_guid = ue.guid 
	ORDER BY a.time_created DESC";

	return $query;
}

function getGroupPhotoInformation_query($album_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT e.guid, ue.username, ue.name, oe.title, oe.description, es.subtype, e.time_created, e.time_updated
	FROM ".$dbprefix."users_entity ue, ".$dbprefix."objects_entity oe, ".$dbprefix."entity_subtypes es, ".$dbprefix."entities e
	WHERE e.container_guid =".$album_guid."
		AND e.subtype =19
		AND e.subtype = es.id
		AND e.guid = oe.guid
		AND e.owner_guid = ue.guid 
	ORDER BY e.time_created DESC";
	
	return $query;
}

function group_activity_statistics_query($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
		SELECT permonth, max(num_of_entities) as num_of_entities, max(num_of_replies) as num_of_replies, max(num_of_members) as num_of_members FROM (

			SELECT COUNT(e.guid) AS num_of_replies, NULL AS num_of_members, NULL AS num_of_entities, FROM_UNIXTIME(a.time_created, '%Y-%m') AS permonth 
		    FROM ".$dbprefix."annotations a, ".$dbprefix."metastrings ms, ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		    WHERE a.value_id = ms.id 
		        AND e.guid = a.entity_guid 
		        AND e.container_guid =".$group_guid." 
		        AND es.id = e.subtype 
		        AND oe.guid = e.guid 
		        AND e.subtype = 7 
		        AND e.owner_guid = ue.guid GROUP BY permonth
		UNION 
			SELECT NULL AS num_of_replies, COUNT( ue.name ) AS num_of_members, NULL AS num_of_entities, FROM_UNIXTIME( er.time_created, '%Y-%m' ) AS permonth
			FROM ".$dbprefix."entities e, ".$dbprefix."entity_relationships er, ".$dbprefix."users_entity ue
			WHERE e.guid = ue.guid 
				AND (er.guid_one =".$group_guid." OR er.guid_two = ".$group_guid.")
				AND (er.guid_one = ue.guid OR er.guid_two = ue.guid)
				AND er.relationship = 'member' GROUP BY permonth
		UNION
			SELECT NULL AS num_of_replies, NULL AS num_of_members, COUNT( e.guid ) AS num_of_entities, FROM_UNIXTIME( e.time_created, '%Y-%m' ) AS permonth 
		    FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		    WHERE e.container_guid =".$group_guid." 
		     	AND e.subtype = es.id 
		     	AND oe.guid = e.guid 
		     	AND ue.guid = e.owner_guid GROUP BY permonth
		) A 
		GROUP BY permonth
		ORDER BY permonth DESC";
	return $query;
}

function detailed_group_activity_statistics_query($group_guid, $album_guid_formatted)
{
	$dbprefix = elgg_get_config("dbprefix");
	//date | blog | bookmarks | calendar | discussion | files | pages | album | polls | tasks
	$query = "
	SELECT permonth, max(blog_count) AS blog_count, max(bookmark_count) AS bookmark_count, max(calendar_count) AS calendar_count, max(topic_count) AS topic_count, max(file_count) AS file_count,
	max(page_count) AS page_count, max(album_count) AS album_count, max(photo_count) AS photo_count, max(poll_count) AS poll_count, max(task_count) AS task_count
	FROM (
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, COUNT(e.guid) AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 5 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, COUNT(e.guid) as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 8 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, COUNT(e.guid) AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 20 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, COUNT(e.guid) AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 7 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, COUNT(e.guid) AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 1 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, COUNT(e.guid) AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 9 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, COUNT(e.guid) as album_count,
			NULL AS photo_count, NULL as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 18 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, COUNT(e.guid) as poll_count, NULL AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 35 GROUP BY permonth
	UNION
		SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
			NULL AS photo_count, NULL as poll_count, COUNT(e.guid) AS task_count
		FROM ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue 
		WHERE e.container_guid = ".$group_guid." 
			AND e.subtype = es.id 
			AND oe.guid = e.guid 
			AND ue.guid = e.owner_guid
			AND e.subtype = 37 GROUP BY permonth";

	if ($album_guid_formatted)
	{

		$query = $query . 
		" UNION
			SELECT FROM_UNIXTIME(e.time_created, '%Y-%m') AS permonth, NULL AS blog_count, NULL as bookmark_count, NULL AS calendar_count, NULL AS topic_count, NULL AS file_count, NULL AS page_count, NULL as album_count,
				COUNT(e.guid) AS photo_count, NULL as poll_count, NULL AS task_count
			FROM ".$dbprefix."users_entity ue, ".$dbprefix."objects_entity oe, ".$dbprefix."entity_subtypes es, ".$dbprefix."entities e
			WHERE e.container_guid ".$album_guid_formatted."
				AND e.subtype =19
				AND e.subtype = es.id
				AND e.guid = oe.guid
				AND e.owner_guid = ue.guid 
		GROUP BY permonth
		ORDER BY permonth DESC";
	}

	$query = $query.") A
	GROUP BY permonth";

	return $query;
}

function detailed_album_statistics($album_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT e.guid, ue.username, ue.name, oe.title, oe.description, es.subtype, e.time_created, e.time_updated
	FROM ".$dbprefix."users_entity ue, ".$dbprefix."objects_entity oe, ".$dbprefix."entity_subtypes es, ".$dbprefix."entities e
	WHERE e.container_guid =".$album_guid."
		AND e.subtype =19
		AND e.subtype = es.id
		AND e.guid = oe.guid
		AND e.owner_guid = ue.guid 
	ORDER BY e.time_created DESC";
	
	return $query;
}

function detailed_discussion_statistics($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	// topic | creation | num replies ORDER BY creation GROUP BY title
	$query = "
	SELECT es.subtype, e.guid, oe.title, ue.name, FROM_UNIXTIME(a.time_created,'%Y-%m-%d') AS time_created, COUNT(e.guid) AS reply_count
	FROM ".$dbprefix."annotations a, ".$dbprefix."metastrings ms, ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue
	WHERE a.value_id = ms.id
		AND e.guid = a.entity_guid
		AND e.container_guid =".$group_guid."
		AND es.id = e.subtype
		AND oe.guid = e.guid
		AND e.subtype = 7
		AND ms.string != 'likes'
		AND e.owner_guid = ue.guid GROUP BY oe.title
	ORDER BY a.time_created DESC";

	return $query;
}

function getRepliesToEntities($group_guid)
{
	$dbprefix = elgg_get_config("dbprefix");
	$query = "
	SELECT e.guid, FROM_UNIXTIME(a.time_created,'%Y-%m-%d') AS time_created, count(ms.string) AS num_of_replies, oe.title, ue.name AS author, es.subtype
	FROM ".$dbprefix."annotations a, ".$dbprefix."metastrings ms, ".$dbprefix."entities e, ".$dbprefix."entity_subtypes es, ".$dbprefix."objects_entity oe, ".$dbprefix."users_entity ue
	WHERE a.value_id = ms.id
		AND e.guid = a.entity_guid
		AND e.container_guid =".$group_guid."
		AND es.id = e.subtype
		AND oe.guid = e.guid
		AND e.owner_guid = ue.guid
		AND es.subtype != 'task'
		AND e.subtype !=7
		AND ms.string !='likes'
		AND e.subtype = es.id
	GROUP BY oe.title
	ORDER BY time_created DESC";

	return $query;
}

function get_result($query)
{
	global $CONFIG;
	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) error_log("cyu_stats_query.php: Failed to connect to MySQL: ".mysqli_connect_errno());
	if (!mysqli_query($connection,$query)) error_log('cyu_stats_query.php: Failed to query: '.mysqli_error($connection));
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function make_zero_entry($cell_value)
{
	if (!$cell_value)
		return '0';
	else
		return $cell_value;
}



function subtype_translation($subtype, $is_link = false)
{
	if ($is_link)
	{
		if ($subtype === 'event_calendar')
			return $subtype;
		if ($subtype === 'image')
			return 'photos/'.$subtype;

	}
	switch ($subtype)
	{
		case 'groupforumtopic':
			return 'discussion';
		case 'event_calendar':
			return 'event';
		case 'bookmarks':
			return 'bookmarks';
		case 'file':
			return 'file';
		case 'blog':
			return 'blog';
		case 'album':
			return 'album';
		case 'task_top':
			return 'tasks';
		case 'page_top':
			return 'pages';
		case 'poll':
			return 'poll';
		case 'task':
			return 'task';
		case 'idea':
			return 'ideas';
		default:
			return $subtype;
	}
}