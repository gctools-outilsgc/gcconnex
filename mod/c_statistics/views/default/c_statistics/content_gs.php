<style>
table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }

.highlight_row:hover {
  background-color: #3399ff;
  color: #FFFFFF;
}

</style>

<?php

$group = elgg_get_page_owner_entity();
if ($group->canEdit())
{
	$start_timer = microtime(true);
	$group_url = explode('/',$_SERVER["REQUEST_URI"]);
	$group_id = $group_url[4];

	elgg_load_library('c_statistics');

	$report_creation_time = date("Y-m-d h:m:s");
	echo ''.elgg_echo('c_stats:report_generated2').' <code>'.$report_creation_time.'</code><br/>';
	echo '<br/><a href="'.elgg_get_site_url().'c_statistics/xexcel/?group_guid='.$group_id.'">'.elgg_echo('c_stats:export').'</a>';
	echo '<hr>';

	$tab = get_input('tab','tabbed_options');

	echo elgg_view('navigation/tabs', array(
		'tabs' => array(
			array(
				'text' => elgg_echo('c_stats:group_stats-tab'),
				'href' => '#entities',
			),
			array(
				'text' => elgg_echo('c_stats:group_inv-tab'),
				'href' => '#activity_stats',
			),
			array(
				'text' => elgg_echo('c_stats:group_report-tab'),
				'href' => '#help',
			),
		)));
?>

<script>
	$(document).ready(function(){

		$('#group_information').show();
		$('#group_stats').hide();
		$('#stats_help').hide();

		$('input[type="checkbox"]').click(function(){
			var item = $(this).attr('name');
	        $('table[name="'+item+'"]').toggle();

		});
	});

	$(window).on('hashchange', function()
	{
		switch(location.hash.slice(1))
		{
			case 'entities':
				$('#group_information').show();
				$('#group_stats').hide();
				$('#stats_help').hide();
				break;
			case 'activity_stats':
				$('#group_information').hide();
				$('#group_stats').show();
				$('#stats_help').hide();
				break;
			case 'help':
				$('#group_information').hide();
				$('#group_stats').hide();
				$('#stats_help').show();
				break;
			default:
		}
	});
</script>


<?php
	echo '<div id="group_information">';

	$checkboxes = array(
		'display general group information',
		'display group members information',
		'display overall group activity information',
		'display group photo information',
		'display all discussion replies information');

	// echo '<div class="options">';
	// foreach ($checkboxes as $checkbox)
	// {
	// 	echo "<input type='checkbox' checked name='".$checkbox."'><label>".$checkbox."</label><br />";
	// }
	// echo '</div>';
	// echo '<hr>';

/* +++[ GROUP STATISTICS ]++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

	echo '<br/><u>'.elgg_echo('c_stats:general_group_info-heading').'</u><br/>';
	$result = get_result(getGroupInformation_query($group_id));
	$row = mysqli_fetch_array($result);
	echo "<table name='display general group information' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
	echo '<th>'.elgg_echo('c_stats:general_group_info-table').'</th>';
	echo '<tr class="highlight_row"><td>';
	echo elgg_echo('c_stats:group_name').' : '.utf8_encode($row['name']).'<br />';
	//echo 'group description : '.$row['description'].'<br/>';
	echo elgg_echo('c_stats:group_creator').' : '.utf8_encode($row['username']).'<br/>';
	echo elgg_echo('c_stats:group_creation_date').' : '.$row['time_created'].'<br/>';
	echo "</td></tr></table>";


	$result = get_result(group_activity_statistics_query($group_id));
	if (count($result) > 0)
	{
		echo '<br/><u>'.elgg_echo('c_stats:group_activity_statistics-heading').'</u><br/>';
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:year_month').'</th> <th width="16%">'.elgg_echo('c_stats:new_member').'</th> <th width="16%">'.elgg_echo('c_stats:new_entities').'</th> <th width="16%">'.elgg_echo('c_stats:new_topic_reply').'</th></tr>';
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class = "highlight_row">'; 
			echo '<td> '.$row['permonth'].' </td>';
			echo '<td> '.make_zero_entry($row['num_of_members']).' </td>';
			echo '<td> '.make_zero_entry($row['num_of_entities']).' </td>';
			echo '<td> '.make_zero_entry($row['num_of_replies']).' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	// format the album ids and insert into query
	if ($album_guid)
	{
		$album_ids = 'IN (';
		for ($i = 0; $i < count($album_guid); $i++)
		{
			if ($i == (count($album_guid) - 1))
				$album_ids = $album_ids . $album_guid[$i];
			else
				$album_ids = $album_ids . $album_guid[$i] . ',';
		}
		$album_ids = $album_ids . ')';
	}

	$result = get_result(detailed_group_activity_statistics_query($group_id, $album_ids));
	if (count($result) > 0)
	{
		echo '<br/><u>'.elgg_echo('c_stats:detailed_entities_statistics1-heading').'</u><br/>';
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:year_month').'</th> <th width="16%">new blogs</th> <th width="16%">'.elgg_echo('c_stats:new_bookmark').'</th> <th width="16%">'.elgg_echo('c_stats:new_event').'</th><th width="16%">'.elgg_echo('c_stats:new_topic').'</th><th width="16%">'.elgg_echo('c_stats:new_file').'</th></tr>';
		// date | blog | bookmarks | calendar | discussion | files | pages | album | photos | polls | tasks
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			echo '<td> '.$row['permonth'].' </td>';
			echo '<td> '.make_zero_entry($row['blog_count']).' </td>';
			echo '<td> '.make_zero_entry($row['bookmark_count']).' </td>';
			echo '<td> '.make_zero_entry($row['calendar_count']).' </td>'; 
			echo '<td> '.make_zero_entry($row['topic_count']).' </td>';
			echo '<td> '.make_zero_entry($row['file_count']).' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	$result = get_result(detailed_group_activity_statistics_query($group_id, $album_ids));
	if (count($result) > 0)
	{
		echo '<br/><u>'.elgg_echo('c_stats:detailed_entities_statistics2-heading').'</u><br/>';
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:year_month').'</th> <th width="16%">'.elgg_echo('c_stats:new_page').'</th><th width="16%">'.elgg_echo('c_stats:new_album').'</th><th width="16%">'.elgg_echo('c_stats:new_photo').'</th><th width="16%">'.elgg_echo('c_stats:new_poll').'</th><th width="16%">'.elgg_echo('c_stats:new_task').'</th></tr>';
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			echo '<td> '.$row['permonth'].' </td>';
			echo '<td> '.make_zero_entry($row['page_count']).' </td>';
			echo '<td> '.make_zero_entry($row['album_count']).' </td>';
			echo '<td> '.make_zero_entry($row['photo_count']).' </td>'; 
			echo '<td> '.make_zero_entry($row['poll_count']).' </td>';
			echo '<td> '.make_zero_entry($row['task_count']).' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	$result = get_result(detailed_discussion_statistics($group_id));
	if (count($result) > 0)
	{
		echo '<br/><u>'.elgg_echo('c_stats:group_topic_replies_info-heading').'</u><br/>';
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:discussion_topic').'</th> <th width="16%">'.elgg_echo('c_stats:author').'</th><th width="16%">'.elgg_echo('c_stats:num_replies').'</th><th width="16%">'.elgg_echo('c_stats:date_created').'</th></tr>';
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			//echo '<td> '.utf8_encode($row['title']).' </td>';
			echo '<td> '.'<a href="'.elgg_get_site_url().subtype_translation($row['subtype'], true).'/view/'.$row['guid'].'/'.str_replace(" ", "-", $row['title']).'">'.utf8_encode($row['title']).'</a>'.' </td>';
			echo '<td> '.utf8_encode($row['name']).' </td>';
			echo '<td> '.make_zero_entry($row['reply_count']).' </td>';
			echo '<td> '.$row['time_created'].' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	$result = get_result(getRepliesToEntities($group_id));
	if (count($result) > 0)
	{
		echo '<br/><u>'.elgg_echo('c_stats:group_entity_replies-heading').'</u><br/>';
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:title').'</th> <th width="16%">'.elgg_echo('c_stats:num_replies').'</th><th width="16%">'.elgg_echo('c_stats:date_created').'</th><th width="16%">'.elgg_echo('c_stats:entity_type').'</th></tr>';
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			echo '<td> '.'<a href="'.elgg_get_site_url().subtype_translation($row['subtype'], true).'/view/'.$row['guid'].'/'.str_replace(" ", "-", utf8_encode($row['title'])).'">'.utf8_encode($row['title']).'</a>'.' </td>';
			echo '<td> '.make_zero_entry($row['num_of_replies']).' </td>';
			echo '<td> '.$row['time_created'].' </td>';
			echo '<td> '.subtype_translation(utf8_encode($row['subtype'])).' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	echo '<br /><br />';
	echo '</div>';



/* +++[ GROUP ACTIVITY STATISTICS ]++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	echo '<div id="group_stats" style="visible:none;">';

	// activity feed table-zed (do we want this in excel instead?)
	$result = get_result(getGroupActivityInformation_query($group_id));
	if (count($result) > 0) {
//		echo '<br/><code><u>GROUP ACTIVITY TYPE</u></code><br/>';
		$album_guid = array();
		//$row = mysqli_fetch_array($result);
//		echo "<table name='display overall group activity information' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
//		echo '<tr> <th width="16%">time created</th> <th width="16%">author</th> <th width="16%">title</th> <th width="16%">activity type</th> <!--<th width="16%">updated</th>--> </tr>';
		// time created | author | title | subtype | last updated
		while ($row = mysqli_fetch_array($result))
		{
			if ($row['subtype'] == 'album')	$album_guid[] = $row['guid'];
//			echo '<tr class="highlight_row">'; 
//			echo '<td> '.date("Y-m-d", $row['time_created']).' </td>';
//			echo '<td> '.utf8_encode($row['name']).' </td>';
//			echo '<td> '.utf8_encode($row['title']).' </td>';
//			echo '<td> '.subtype_translation($row['subtype']).' </td>'; 
			//echo '<td> '.date("Y-m-d", $row['time_updated']).' </td>';
//			echo '</tr>';
		}
//		echo '</table>';
	}

	if (count($album_guid) > 0) 
	{
		echo '<br/><u>'.elgg_echo('c_stats:group_photos_information-heading').'</u><br/>';
		echo "<table name='display group photo information' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:title').'</th> <th width="16%">'.elgg_echo('c_stats:description').'</th> <th width="16%">'.elgg_echo('c_stats:date_created').'</th> <th width="16%">'.elgg_echo('c_stats:author').'</th> </tr>';
		foreach ($album_guid as $album)
		{	
			$result = get_result(getGroupPhotoInformation_query($album));
			while ($row = mysqli_fetch_array($result))
			{
				echo '<tr class="highlight_row">'; 
				//echo '<td> '.$row['guid'].' </td>';
				echo '<td> '.'<a href="'.elgg_get_site_url().subtype_translation($row['subtype'], true).'/'.$row['guid'].'/'.str_replace(" ", "-", $row['title']).'">'.utf8_encode($row['title']).'</a>'.' </td>';
				echo '<td> '.utf8_encode($row['description']).' </td>';
				echo '<td> '.date("Y-m-d", $row['time_created']).' </td>'; 
				//echo '<td> '.date("Y-m-d", $row['time_updated']).' </td>';
				echo '<td> '.utf8_encode($row['name']).' </td>';
				echo '</tr>';
			}
		}
		echo '</table>';
	}

	// redundant
/*	$result = get_result(getDiscussionReplies_query($group_id));
	if (count($result) > 0)
	{
		echo '<br/><code><u>DISCUSSION THREAD REPLIES</u></code><br/>';
		echo "<table name ='display all discussion replies information' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr > <th width="16%">username</th> <th width="16%">title of topic</th> <th width="16%">creation</th></tr>';//' <th width="16%">comment posted</th></tr>';
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			echo '<td> '.utf8_encode($row['name']).' </td>';
			echo '<td> '.utf8_encode($row['title']).' </td>';
			echo '<td> '.date("Y-m-d", $row['time_created']).' </td>';
			//echo '<td> '.$row['string'].' </td>'; 
			echo '</tr>';
		}
		echo '</table>';
	} */

	$result = get_result(getMemberInformation_query($group_id));
	if (count($result) > 0) {
		echo '<br/><code><u>'.elgg_echo('c_stats:group_member_information-heading').'</u></code><br/>';
		echo "<table name='display group members information' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
		echo '<tr> <th width="16%">'.elgg_echo('c_stats:user_name').'</th> <th width="16%">'.elgg_echo('c_stats:date_joined').'</th> <th width="16%">'.elgg_echo('c_stats:email').'</th> <th width="16%">'.elgg_echo('c_stats:language').'</th></tr>';// <th width="16%">department</th> </tr>';
		// name | joined date | email | preferred language | department?
		while ($row = mysqli_fetch_array($result))
		{
			echo '<tr class="highlight_row">'; 
			echo '<td> '.utf8_encode($row['name']).' </td>';
			echo '<td> '.date("Y-m-d", $row['time_created']).' </td>';
			echo '<td> '.$row['email'].' </td>';
			echo '<td> '.$row['language'].' </td>'; 
			//echo '<td> '.'department'.' </td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	echo '</div>';



/*+++[ HELP SECTION ]++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	echo '<div id="stats_help">';
	echo '<br />';
	if ($_COOKIE['connex_lang'] === 'fr')
		$stats_instructions = elgg_get_plugin_setting('fr_stats_instruction', 'c_statistics');
	else
		$stats_instructions = elgg_get_plugin_setting('en_stats_instruction', 'c_statistics');
	echo $stats_instructions;
	echo '<br/><br/>';	
	echo '</div>';

	$end_timer = microtime(true);
	$time = number_format(($end_timer - $start_timer), 2);
	echo '<div align="center"><br/><br/>'.elgg_echo('c_stats:report_generated').'<code>' .$time.' '.elgg_echo('c_stats:sec').'</code></div>';

} else {
	echo elgg_echo('c_stats:noaccess');
}