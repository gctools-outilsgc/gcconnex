<style type="text/css">
.elgg-form-settings
{
	max-width: none;
}
table.communities
{
	width: 100%;
	margin-top: 10px;
	border-right: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
}
table.communities th
{
	padding: 5px;
	border-top: 1px solid #ccc;
	border-left: 1px solid #ccc;
	background: #eee;
}
table.communities td
{
	padding: 5px;
	border-top: 1px solid #ccc;
	border-left: 1px solid #ccc;
}
input.community
{
	font-size: 14px;
	width: 100%;
}
input:disabled
{
	background: #ddd;
}
.edit-message
{
	font-weight: bold;
}
.required
{
	color: red;
}
</style>

<script type="text/javascript">
	$(function() {
		function toggleButtons(key) {
			$('input[data-url=' + key + ']').prop("disabled", function(i, v) {
				return !v;
			});
			$('select[data-url=' + key + ']').prop("disabled", function(i, v) {
				return !v;
			});
			$('a.edit-community[data-url=' + key + ']').toggleClass('hidden');
			$('a.cancel-community[data-url=' + key + ']').toggleClass('hidden');
			$('a.save-community[data-url=' + key + ']').toggleClass('hidden');
		}

		function showMessage(key, msg) {
			$('span.edit-message[data-url=' + key + ']').show().text(msg).delay(2000).fadeOut();
		}

		$("a.edit-community, a.cancel-community").click(function(e) {
			e.preventDefault();
			var url = $(this).data('url');
			toggleButtons(url);
			if ($(this).hasClass("edit-community")) {
				$('input.community_tags[data-url=' + url + ']').focus();
			}
		});

		$("a.add-community").click(function(e) {
			e.preventDefault();

			var community_en = $("#add-community-page-en").val();
			var community_fr = $("#add-community-page-fr").val();
			var community_url = $("#add-community-page-url").val();
			var community_tags = $("#add-community-page-tags").val();
			var community_animator = $("#add-community-page-animator").val();
			var community_audience = $('#add-community-page-audience').val();

			if (community_en !== "" && community_fr !== "" && community_url !== "" && community_tags !== "") {
				var communitiesArray = ($("#communities").val() != "") ? JSON.parse($("#communities").val()) : [];
				var community = {
					'community_en': community_en,
					'community_fr': community_fr,
					'community_url': community_url,
					'community_tags': community_tags,
					'community_animator': community_animator,
					'community_audience': community_audience
				};
				communitiesArray.push(community);
				$("#communities").val(JSON.stringify(communitiesArray));

				$(".elgg-foot .elgg-button-submit").click();
			}
		});

		$("a.save-community").click(function(e) {
			e.preventDefault();

			var url = $(this).data('url');
			var community_en = $('input.community_en[data-url=' + url + ']').val();
			var community_fr = $('input.community_fr[data-url=' + url + ']').val();
			var community_url = $('input.community_url[data-url=' + url + ']').val();
			var community_tags = $('input.community_tags[data-url=' + url + ']').val();
			var community_animator = $('input.community_animator[data-url=' + url + ']').val();
			var community_audience = $('select.community_audience[data-url=' + url + ']').val();

			if (community_en !== "" && community_fr !== "" && community_url !== "" && community_tags !== "") {
				var communitiesArray = JSON.parse($("#communities").val());

				$.each(communitiesArray, function(key, value) {
					if (value.community_url == url) {
						value.community_en = community_en;
						value.community_fr = community_fr;
						value.community_url = community_url;
						value.community_tags = community_tags;
						value.community_animator = community_animator;
						value.community_audience = community_audience;
						return;
					}
				});
				$("#communities").val(JSON.stringify(communitiesArray));

				$(".elgg-foot .elgg-button-submit").click();
			}
		});

		$("a.delete-community").click(function(e) {
			e.preventDefault();

			var communitiesArray = JSON.parse($("#communities").val());
			var url = $(this).data('url');

			$.each(communitiesArray, function(key, value) {
				if (value.community_url == url) {
					communitiesArray.splice(key, 1);
					$("#communities").val(JSON.stringify(communitiesArray));
					$(".elgg-foot .elgg-button-submit").click();
					return;
				}
			});
		});
	});
</script>

<?php
$community_array = array(
	'atip'=> elgg_echo('gctags:community:atip'),
	'communications'=> elgg_echo('gctags:community:communications'),
	'evaluators'=> elgg_echo('gctags:community:evaluators'),
	'financial'=> elgg_echo('gctags:community:financial'),
	'hr'=> elgg_echo('gctags:community:hr'),
	'im'=> elgg_echo('gctags:community:im'),
	'it'=> elgg_echo('gctags:community:it'),
	'auditors'=> elgg_echo('gctags:community:auditors'),
	'matmanagement'=> elgg_echo('gctags:community:matmanagement'),
	'policy'=> elgg_echo('gctags:community:policy'),
	'procurement'=> elgg_echo('gctags:community:procurement'),
	'realproperty'=> elgg_echo('gctags:community:realproperty'),
	'regulators'=> elgg_echo('gctags:community:regulators'),
	'security'=> elgg_echo('gctags:community:security'),
	'service'=> elgg_echo('gctags:community:service'),
	'science'=> elgg_echo('gctags:community:science'),
	'allps' => elgg_echo('gctags:community:allps'),
);

// Show fields for adding new communities
echo '<table class="communities">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gc_communities:title').' (EN) : <span class="required">*</span> '.elgg_view('input/text', array('id' => 'add-community-page-en')).'<br/>';
echo elgg_echo('gc_communities:title').' (FR) : <span class="required">*</span> '.elgg_view('input/text', array('id' => 'add-community-page-fr')).'<br/>';
echo elgg_echo('gc_communities:url').' : <span class="required">*</span> '.elgg_view('input/text', array('id' => 'add-community-page-url')).'<br/>';
echo elgg_echo('gc_communities:tags').' : <span class="required">*</span> '.elgg_view('input/text', array('id' => 'add-community-page-tags')).'<br/>';
echo elgg_echo('gc_communities:animator').' (username) : '.elgg_view('input/text', array('id' => 'add-community-page-animator')).'<br/>';
echo elgg_echo('gc_communities:audience').'<span class="required">*</span>'.elgg_view('input/select', array('id'=>'add-community-page-audience', 'options_values' => $community_array,)).'<br>';
echo '<a class="add-community elgg-button elgg-button-submit btn btn-primary mtm">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

echo '<br />';

// Display all existing communities
$communities = json_decode($vars['entity']->communities, true);

if (count($communities) > 0) {
	echo '<table class="communities"><tbody>';
	echo '<thead>
	<tr>
		<th></th>
		<th>'.elgg_echo('gc_communities:title').' (EN)</th>
		<th>'.elgg_echo('gc_communities:title').' (FR)</th>
		<th>'.elgg_echo('gc_communities:url').'</th>
		<th>'.elgg_echo('gc_communities:tags').'</th>
		<th>'.elgg_echo('gc_communities:animator').'</th>
		<th>'.elgg_echo('gc_communities:audience').'</th>
		<th></th>
		<th></th>
	</tr>
</thead>';
	foreach ($communities as $community) {
		$delete_btn = elgg_view('output/confirmlink', array(
			'class' => 'delete',
			'text' => elgg_echo('delete'),
			'data-url' => $community['community_url']
		));

		echo '<tr>';
		echo '<td> <a class="delete-community" data-url="' . $community['community_url'] . '">'.elgg_echo('delete').'</a> </td>';
		echo '<td> <input class="community community_en" data-url="' . $community['community_url'] . '" type="text" value="' . $community['community_en'] . '" disabled /> </td>';
		echo '<td> <input class="community community_fr" data-url="' . $community['community_url'] . '" type="text" value="' . $community['community_fr'] . '" disabled /> </td>';
		echo '<td> <input class="community community_url" data-url="' . $community['community_url'] . '" type="text" value="' . $community['community_url'] . '" disabled /> </td>';
		echo '<td> <input class="community community_tags" data-url="' . $community['community_url'] . '" type="text" value="' . $community['community_tags'] . '" disabled /> </td>';
		echo '<td> <input class="community community_animator" data-url="' . $community['community_url'] . '" type="text" value="' . $community['community_animator'] . '" disabled /> </td>';
		echo '<td>'.elgg_view('input/select', array('class'=>'community community_audience','options_values' => $community_array,'value'=>$community['community_audience'], 'data-url'=>$community['community_url'],'disabled'=>true)).'</td>';
		echo '<td> <a class="edit-community" data-url="' . $community['community_url'] . '">'.elgg_echo('edit').'</a> <a class="cancel-community hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-url="' . $community['community_url'] . '">'.elgg_echo('cancel').'</a> <a class="save-community hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-url="' . $community['community_url'] . '">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-url="' . $community['community_url'] . '"></span> </td>';
		echo '<td> <a href="' . elgg_get_site_url() . $community['community_url'] . '" target="_blank">'.elgg_echo('open').'</a> </td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

// Hidden field to store communities
echo elgg_view('input/text', array('type' => 'hidden', 'id' => 'communities', 'name' => 'params[communities]', 'value' => $vars['entity']->communities));

// Page parameters for cmmunities
$options = array(
	'id' => 'widget_based',
	'name' => 'params[widget_based]',
	'value' => 'true'
);
if ($vars['entity']->widget_based) {
	$options['checked'] = 'checked';
}
echo '<p class="mtl"><label for="widget_based">' . elgg_echo('gc_communities:enable_widgets') . ' ' . elgg_view('input/checkbox', $options) . '</label></p>';

echo '<p class="mtl"><label for="newsfeed_limit">' . elgg_echo('gc_communities:newsfeed_shown') . ' ' . elgg_view('input/select', array('id' => 'newsfeed_limit', 'name' => 'params[newsfeed_limit]', 'value' => (isset($vars['entity']->newsfeed_limit) ? $vars['entity']->newsfeed_limit : 10), 'options' => range(2, 20, 2))) . '</label></p>';

echo '<p class="mtl"><label for="wire_limit">' . elgg_echo('gc_communities:wires_shown') . ' ' . elgg_view('input/select', array('id' => 'wire_limit', 'name' => 'params[wire_limit]', 'value' => (isset($vars['entity']->wire_limit) ? $vars['entity']->wire_limit : 10), 'options' => range(2, 20, 2))) . '</label></p>';
