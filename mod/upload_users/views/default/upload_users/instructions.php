<?php

$title = elgg_echo('upload_users:instructions');


$body = elgg_echo('upload_users:download_sample_help');
$body .= elgg_view('output/url', array(
	'text' => elgg_echo('upload_users:download_sample'),
	'href' => 'upload_users/download/sample?limit=50&offset=0',
	'class' => 'elgg-button elgg-button-action mam'
		));

$body .= elgg_echo('upload_users:upload_help');
$body .= <<<__HTML
<div class="mam">
	<pre class="pam code">
username,email,name,films,creator
BugsBunny,bugsbunny@looneytunes.com,Bugs Bunny,"“Rabbit Fire”, “Rabbit Seasoning”, “Duck! Rabbit! Duck!”",Chuck Jones
WileCoyote,wilecoyote@looneytunes.com,Wile E. Coyote,"“Fast and Furry-ous”, “Beep, Beep”","Chuck Jones, Michael Maltese"
	</pre>
	<pre class="pam code">
"username";"email";"name";"films";"creator"
"BugsBunny";"bugsbunny@looneytunes.com";"Bugs Bunny";"“Rabbit Fire”, “Rabbit Seasoning”, “Duck! Rabbit! Duck!”";"Chuck Jones"
"WileCoyote";"wilecoyote@looneytunes.com";"Wile E. Coyote";"“Fast and Furry-ous”, “Beep, Beep”";"Chuck Jones, Michael Maltese"
	</pre>
</div>
__HTML;

$body = '<div class="elgg-border-plain mam pam">' . $body . '</div>';

echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));