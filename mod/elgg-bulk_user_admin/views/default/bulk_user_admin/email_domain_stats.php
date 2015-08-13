<?php

$domains = $vars['domains'];

?>
<table class="bulk_user_admin_email_domains">
	<tr>
		<th>Domain</th>
		<th>Registered users</th>
	</tr>
<?php


$i = 0;
foreach ($domains as $domain_info) {
	if (!$domain_info->domain) {
		continue;
	}

	$domain = elgg_view('output/url', array(
		'text' => $domain_info->domain,
		'href' => $domain_info->domain
	));

	$url = elgg_http_add_url_query_elements($vars['url'] . 'admin/user', array('domain' => $domain_info->domain));

	// can't use $_GET variables in admin
	// otherwise admin_page_handler() tries to call the view: view/name?variable=value
	// which clearly doesn't work
	// so we'll pass the domain via post
	$users = '<form id="domain:' . $domain_info->domain . '" action="' . elgg_get_site_url() . 'admin/user" method="post">';
	$users .= elgg_view('input/hidden', array('name' => 'domain', 'value' => $domain_info->domain));
	$users .= '</form>';
	$users .= '<a href="javascript:document.forms[\'domain:' . $domain_info->domain . '\'].submit();">' . $domain_info->count . '</a>';

	$class = ($i % 2) ? 'odd' : 'even';

	echo <<<___HTML
	<tr class="$class">
		<td>$domain</td>
		<td class="center">$users</td>
	</tr>
___HTML;
	
	$i++;
}

?>
</table>