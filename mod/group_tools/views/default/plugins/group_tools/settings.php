<?php
/**
 * Plugin settings for group tools
 */

$plugin = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$yesno_options = array_reverse($noyes_options);

$noyes3_options = [
	'no' => elgg_echo('option:no'),
	'yes_off' => elgg_echo('group_tools:settings:default_off'),
	'yes_on' => elgg_echo('group_tools:settings:default_on'),
];

$listing_options = [
	'all' => elgg_echo('groups:all'),
	'yours' => elgg_echo('groups:yours'),
	'open' => elgg_echo('group_tools:groups:sorting:open'),
	'closed' => elgg_echo('group_tools:groups:sorting:closed'),
	'ordered' => elgg_echo('group_tools:groups:sorting:ordered'),
	'featured' => elgg_echo('status:featured'),
	'suggested' => elgg_echo('group_tools:groups:sorting:suggested'),
];
if (elgg_is_active_plugin('discussions')) {
	$listing_options['discussion'] = elgg_echo('discussion:latest');
}
$listing_sorting_options = [
	'newest' => elgg_echo('sort:newest'),
	'alpha' => elgg_echo('sort:alpha'),
	'popular' => elgg_echo('sort:popular'),
];
$listing_supported_sorting = [
	'all',
	'yours',
	'open',
	'closed',
	'featured',
];

$suggested_groups = [];
if (!empty($plugin->suggested_groups)) {
	$suggested_groups = string_to_tag_array($plugin->suggested_groups);
}

// group management settings
$general_fields = [
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:show_membership_mode'),
		'name' => 'params[show_membership_mode]',
		'options_values' => $yesno_options,
		'value' => $plugin->show_membership_mode,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:show_hidden_group_indicator'),
		'name' => 'params[show_hidden_group_indicator]',
		'options_values' => [
			'no' => elgg_echo('option:no'),
			'group_acl' => elgg_echo('group_tools:settings:show_hidden_group_indicator:group_acl'),
			'logged_in' => elgg_echo('group_tools:settings:show_hidden_group_indicator:logged_in'),
		],
		'value' => $plugin->show_hidden_group_indicator,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:auto_suggest_groups'),
		'name' => 'params[auto_suggest_groups]',
		'options_values' => $yesno_options,
		'value' => $plugin->auto_suggest_groups,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:multiple_admin'),
		'name' => 'params[multiple_admin]',
		'options_values' => $noyes_options,
		'value' => $plugin->multiple_admin,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:mail'),
		'name' => 'params[mail]',
		'options_values' => $noyes_options,
		'value' => $plugin->mail,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:mail:members'),
		'#help' => elgg_echo('group_tools:settings:mail:members:description'),
		'name' => 'params[mail_members]',
		'options_values' => $noyes_options,
		'value' => $plugin->mail_members,
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:member_export'),
		'#help' => elgg_echo('group_tools:settings:member_export:description'),
		'name' => 'params[member_export]',
		'options_values' => $noyes_options,
		'value' => $plugin->member_export,
	],
];

// do admins have to approve new groups
if (elgg_get_plugin_setting('limited_groups', 'groups', 'no') !== 'yes') {
	// only is group creation isn't limited to admins
	$general_fields[] = [
		'#type' => 'select',
		'#label' => elgg_echo('group_tools:settings:admin_approve'),
		'#help' => elgg_echo('group_tools:settings:admin_approve:description'),
		'name' => 'params[admin_approve]',
		'options_values' => $noyes_options,
		'value' => $plugin->admin_approve,
	];
}

$general_settings = '';
foreach ($general_fields as $field) {
	$general_settings .= elgg_view_field($field);
}

echo elgg_view_module('inline', elgg_echo('group_tools:settings:management:title'), $general_settings);

// group edit settings
$group_edit = '';
$group_edit .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:settings:admin_transfer'),
	'name' => 'params[admin_transfer]',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'admin' => elgg_echo('group_tools:settings:admin_transfer:admin'),
		'owner' => elgg_echo('group_tools:settings:admin_transfer:owner'),
	],
	'value' => $plugin->admin_transfer,
]);

$group_edit .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:settings:simple_access_tab'),
	'#help' => elgg_echo('group_tools:settings:simple_access_tab:help'),
	'name' => 'params[simple_access_tab]',
	'options_values' => $noyes_options,
	'value' => $plugin->simple_access_tab,
]);

$group_edit .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:settings:simple_create_form'),
	'#help' => elgg_echo('group_tools:settings:simple_create_form:help'),
	'name' => 'params[simple_create_form]',
	'options_values' => $noyes_options,
	'value' => $plugin->simple_create_form,
]);

$group_edit .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('groups:allowhiddengroups'),
	'#help' => elgg_echo('group_tools:settings:allow_hidden_groups:help'),
	'name' => 'params[allow_hidden_groups]',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'admin' => elgg_echo('group_tools:settings:admin_only'),
		'yes' => elgg_echo('option:yes'),
	],
	'value' => $plugin->allow_hidden_groups ?: elgg_get_plugin_setting('hidden_groups', 'groups', 'no'),
]);

echo elgg_view_module('inline', elgg_echo('group_tools:settings:edit:title'), $group_edit);

// listing settings
$title = elgg_echo('group_tools:settings:listing:title');
$body = elgg_echo('group_tools:settings:listing:description');

$listing_tab_rows = [];
// header rows
$cells = [];
$cells[] = elgg_format_element('th', ['rowspan' => 2], '&nbsp;');
$cells[] = elgg_format_element('th', ['rowspan' => 2, 'class' => 'center'], elgg_echo('group_tools:settings:listing:enabled'));
$cells[] = elgg_format_element('th', ['rowspan' => 2, 'class' => 'center'], elgg_echo('group_tools:settings:listing:default_short'));
$cells[] = elgg_format_element('th', ['colspan' => 3, 'class' => 'center'], elgg_echo('sort'));
$listing_tab_rows[] = elgg_format_element('tr', [], implode('', $cells));

$cells = [];
foreach ($listing_sorting_options as $label) {
	$cells[] = elgg_format_element('th', ['class' => 'center'], $label);
}
$listing_tab_rows[] = elgg_format_element('tr', [], implode('', $cells));

foreach ($listing_options as $tab => $tab_title) {
	$cells = [];
	
	// tab name
	$cells[] = elgg_format_element('td', [], $tab_title);
	
	// tab enabled
	$tab_setting_name = "group_listing_{$tab}_available";
	$checkbox_options = [
		'name' => "params[{$tab_setting_name}]",
		'value' => 1,
	];
	$tab_value = $plugin->$tab_setting_name;
	if ($tab_value !== '0') {
		if (in_array($tab, ['ordered', 'featured'])) {
			// these tabs are default disabled
			if ($tab_value !== null) {
				$checkbox_options['checked'] = true;
			}
		} else {
			$checkbox_options['checked'] = true;
		}
	}
	$cells[] = elgg_format_element('td', [
		'class' => 'center',
		'title' => elgg_echo('group_tools:settings:listing:available'),
	], elgg_view('input/checkbox', $checkbox_options));
	
	// default tab
	$cells[] = elgg_format_element('td', [
		'class' => 'center',
		'title' => elgg_echo('group_tools:settings:listing:default'),
	], elgg_view('input/radio', [
		'name' => 'params[group_listing]',
		'value' => $plugin->group_listing,
		'options' => [
			'' => $tab,
		],
	]));
	
	// sorting options
	if (in_array($tab, $listing_supported_sorting)) {
		$sorting_name = "group_listing_{$tab}_sorting";
		$sorting_options = [
			'name' => "params[{$sorting_name}]",
			'value' => !empty($plugin->$sorting_name) ? $plugin->$sorting_name : 'newest',
		];
		foreach ($listing_sorting_options as $sort => $translation) {
			$sorting_options['options'] = [
				'' => $sort,
			];
			
			$cells[] = elgg_format_element('td', ['class' => 'center',], elgg_view('input/radio', $sorting_options));
		}
	} else {
		$cells[] = elgg_format_element('td', ['colspan' => 3], '&nbsp;');
	}
	
	// add to table rows
	$listing_tab_rows[] = elgg_format_element('tr', [], implode('', $cells));
}
$body .= elgg_format_element('table', ['class' => 'elgg-table-alt'], implode('', $listing_tab_rows));

echo elgg_view_module('inline', $title, $body);

// notifications
$title = elgg_echo('group_tools:settings:notifications:title');
$body = '';

// auto set notifications
$auto_notifications = elgg_echo('group_tools:settings:auto_notification');
if ($plugin->auto_notification == 'yes') {
	// Backwards compatibility
	$auto_notifications .= elgg_view('input/hidden', [
		'name' => 'params[auto_notification]',
		'value' => '0',
	]);
	$plugin->auto_notification_site = '1';
	$plugin->auto_notification_email = '1';
}
$auto_notifications_lis = [];
$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();
foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
	$name = "auto_notification_{$method}";
	$checkbox_options = [
		'name' => "params[{$name}]",
		'value' => '1',
		'label' => elgg_echo("notification:method:{$method}"),
	];
	if ($plugin->$name == '1') {
		$checkbox_options['checked'] = 'checked';
	}
	$auto_notifications_lis[] = elgg_format_element('li', [], elgg_view('input/checkbox', $checkbox_options));
}
$auto_notifications .= elgg_format_element('ul', ['class' => 'mll'], implode('', $auto_notifications_lis));

$body .= elgg_format_element('div', [], $auto_notifications);

// show toggle for group notification settings
$notification_toggle = elgg_echo('group_tools:settings:notifications:notification_toggle');
$notification_toggle .= elgg_view('input/select', [
	'name' => 'params[notification_toggle]',
	'value' => $plugin->notification_toggle,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$notification_toggle .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('group_tools:settings:notifications:notification_toggle:description'));

$body .= elgg_format_element('div', [], $notification_toggle);

echo elgg_view_module('inline', $title, $body);

// group invite settings
$title = elgg_echo('group_tools:settings:invite:title');

$body = '<div>';
$body .= elgg_echo('group_tools:settings:invite_friends');
$body .= elgg_view('input/select', [
	'name' => 'params[invite_friends]',
	'options_values' => $yesno_options,
	'value' => $plugin->invite_friends,
	'class' => 'mls',
]);
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:invite');
$body .= elgg_view('input/select', [
	'name' => 'params[invite]',
	'options_values' => $noyes_options,
	'value' => $plugin->invite,
	'class' => 'mls',
]);
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:invite_email');
$body .= elgg_view('input/select', [
	'name' => 'params[invite_email]',
	'options_values' => $noyes_options,
	'value' => $plugin->invite_email,
	'class' => 'mls',
]);
$body .= '</div>';

$body .= '<div class="elgg-divide-left pls mls">';
$body .= elgg_echo('group_tools:settings:invite_email:match');
$body .= elgg_view('input/select', [
	'name' => 'params[invite_email_match]',
	'options_values' => $yesno_options,
	'value' => $plugin->invite_email_match,
	'class' => 'mls',
]);
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:invite_csv');
$body .= elgg_view('input/select', [
	'name' => 'params[invite_csv]',
	'options_values' => $noyes_options,
	'value' => $plugin->invite_csv,
	'class' => 'mls',
]);
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:invite_members');
$body .= elgg_view('input/select', [
	'name' => 'params[invite_members]',
	'options_values' => $noyes3_options,
	'value' => $plugin->invite_members,
	'class' => 'mls',
]);
$body .= elgg_format_element('div', ['class' => 'plm elgg-subtext'], elgg_echo('group_tools:settings:invite_members:description'));
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:domain_based');
$body .= elgg_view('input/select', [
	'name' => 'params[domain_based]',
	'options_values' => $noyes_options,
	'value' => $plugin->domain_based,
	'class' => 'mls',
]);
$body .= elgg_format_element('div', ['class' => 'plm elgg-subtext'], elgg_echo('group_tools:settings:domain_based:description'));
$body .= '</div>';

$body .= '<div>';
$body .= elgg_echo('group_tools:settings:join_motivation');
$body .= elgg_view('input/select', [
	'name' => 'params[join_motivation]',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'yes_off' => elgg_echo('group_tools:settings:default_off'),
		'yes_on' => elgg_echo('group_tools:settings:default_on'),
		'required' => elgg_echo('group_tools:settings:required'),
	],
	'value' => $plugin->join_motivation,
	'class' => 'mls',
]);
$body .= elgg_format_element('div', ['class' => 'plm elgg-subtext'], elgg_echo('group_tools:settings:join_motivation:description'));
$body .= '</div>';

echo elgg_view_module('inline', $title, $body);

// group content settings

// default group access
// set a context so we can do stuff
elgg_push_context('group_tools_default_access');

$group_content = elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('group_tools:settings:default_access'),
	'name' => 'params[group_default_access]',
	'value' => $plugin->group_default_access,
]);

// restore context
elgg_pop_context();

$group_content .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:settings:search_index'),
	'name' => 'params[search_index]',
	'options_values' => $noyes_options,
	'value' => $plugin->search_index,
]);

$group_content .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('group_tools:settings:stale_timeout'),
	'#help' => elgg_echo('group_tools:settings:stale_timeout:help'),
	'name' => 'params[stale_timeout]',
	'value' => $plugin->stale_timeout,
	'min' => 0,
	'max' => 9999,
]);

echo elgg_view_module('inline', elgg_echo('group_tools:settings:content:title'), $group_content);

// list all special state groups (features/suggested)
$tabs = [];
$content = '';

// featured
$options = [
	'type' => 'group',
	'limit' => false,
	'metadata_name_value_pairs' => [
		'name' => 'featured_group',
		'value' => 'yes',
	],
];

$featured_groups = elgg_get_entities_from_metadata($options);
if (!empty($featured_groups)) {
	$tabs[] = [
		'text' => elgg_echo('status:featured'),
		'href' => '#group-tools-special-states-featured',
		'selected' => true,
	];
	
	$content .= '<div id="group-tools-special-states-featured">';
	$content .= elgg_view('output/longtext', [
		'value' => elgg_echo('group_tools:settings:special_states:featured:description'),
	]);
	
	$content .= '<table class="elgg-table mtm">';
	
	$content .= '<tr>';
	$content .= elgg_format_element('th', ['colspan' => 2], elgg_echo('groups:name'));
	$content .= '</tr>';
	
	foreach ($featured_groups as $group) {
		$content .= '<tr>';
		$content .= elgg_format_element('td', [], elgg_view('output/url', [
			'href' => $group->getURL(),
			'text' => $group->name,
		]));
		$content .= elgg_format_element('td', ['style' => 'width: 25px;'], elgg_view('output/url', [
			'href' => "action/groups/featured?group_guid={$group->getGUID()}",
			'title' => elgg_echo('remove'),
			'text' => elgg_view_icon('delete'),
			'confirm' => true,
		]));
		$content .= '</tr>';
	}
	
	$content .= '</table>';
	$content .= '</div>';
}

// suggested
if (!empty($suggested_groups)) {
	$class = '';
	$selected = true;
	if (!empty($tabs)) {
		$class = 'hidden';
		$selected = false;
	}
	$tabs[] = [
		'text' => elgg_echo('group_tools:settings:special_states:suggested'),
		'href' => '#group-tools-special-states-suggested',
		'selected' => $selected,
	];
	
	$content .= "<div id='group-tools-special-states-suggested' class='{$class}'>";
	$content .= elgg_view('output/longtext', [
		'value' => elgg_echo('group_tools:settings:special_states:suggested:description'),
	]);
	
	$content .= '<table class="elgg-table mtm">';
	
	$content .= '<tr>';
	$content .= elgg_format_element('th', ['colspan' => 2], elgg_echo('groups:name'));
	$content .= '</tr>';
	
	$options = [
		'type' => 'group',
		'limit' => false,
		'guids' => $suggested_groups,
	];
	
	$groups = new ElggBatch('elgg_get_entities', $options);
	foreach ($groups as $group) {
		$content .= '<tr>';
		$content .= elgg_format_element('td', [], elgg_view('output/url', [
			'href' => $group->getURL(),
			'text' => $group->name,
		]));
		$content .= elgg_format_element('td', ['style' => 'width: 25px;'], elgg_view('output/url', [
			'href' => "action/group_tools/toggle_special_state?group_guid={$group->getGUID()}&state=suggested",
			'title' => elgg_echo('remove'),
			'text' => elgg_view_icon('delete'),
			'confirm' => true,
		]));
		$content .= '</tr>';
	}
	
	$content .= '</table>';
	$content .= '</div>';
}

if (!empty($tabs)) {
	$navigation = '';
	if (count($tabs) > 1) {
		elgg_require_js('group_tools/settings');
		$navigation = elgg_view('navigation/tabs', [
			'tabs' => $tabs,
			'id' => 'group-tools-special-states-tabs',
		]);
	}
	
	echo elgg_view_module('inline', elgg_echo('group_tools:settings:special_states'), $navigation . $content);
}

// fix some problems with groups
$rows = [];

// check missing acl members
$missing_acl_members = group_tools_get_missing_acl_users();
if (!empty($missing_acl_members)) {
	$rows[] = [
		elgg_echo('group_tools:settings:fix:missing', [count($missing_acl_members)]),
		elgg_view('output/url', [
			'href' => 'action/group_tools/fix_acl?fix=missing',
			'text' => elgg_echo('group_tools:settings:fix_it'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true,
			'style' => 'white-space: nowrap;',
			'confirm' => true,
		]),
	];
}

// check excess acl members
$excess_acl_members = group_tools_get_excess_acl_users();
if (!empty($excess_acl_members)) {
	$rows[] = [
		elgg_echo('group_tools:settings:fix:excess', [count($excess_acl_members)]),
		elgg_view('output/url', [
			'href' => 'action/group_tools/fix_acl?fix=excess',
			'text' => elgg_echo('group_tools:settings:fix_it'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true,
			'style' => 'white-space: nowrap;',
			'confirm' => true,
		]),
	];
}

// check groups without acl
$wrong_groups = group_tools_get_groups_without_acl();
if (!empty($wrong_groups)) {
	$rows[] = [
		elgg_echo('group_tools:settings:fix:without', [count($wrong_groups)]),
		elgg_view('output/url', [
			'href' => 'action/group_tools/fix_acl?fix=without',
			'text' => elgg_echo('group_tools:settings:fix_it'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true,
			'style' => 'white-space: nowrap;',
			'confirm' => true,
		]),
	];
}

// fix everything at once
if (count($rows) > 1) {
	$rows[] = [
		elgg_echo('group_tools:settings:fix:all:description'),
		elgg_view('output/url', [
			'href' => 'action/group_tools/fix_acl?fix=all',
			'text' => elgg_echo('group_tools:settings:fix:all'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true,
			'style' => 'white-space: nowrap;',
			'confirm' => true,
		]),
	];
}

if (!empty($rows)) {
	$content = '<table class="elgg-table">';
	
	foreach ($rows as $row) {
		$content .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';
	}
	
	$content .= '</table>';
	
	echo elgg_view_module('inline', elgg_echo('group_tools:settings:fix:title'), $content);
}
