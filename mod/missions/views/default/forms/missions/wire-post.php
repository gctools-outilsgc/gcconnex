<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which allows users to post a message to The Wire about the subject mission entity.
 */

//Nick - cutting up the orginal share on wire form to keep consistancy on the site
//Cleaned up some of this file as it will only deal with mission opportunities
/**
 * Wire add form body
 *
 * @uses $vars["post"]
 */

elgg_load_js("elgg.thewire");

$post = elgg_extract("post", $vars);
$char_limit = thewire_tools_get_wire_length();
//Changed to entity_subject as this what was already passed to this view
$reshare = elgg_extract("entity_subject", $vars); // for reshare functionality

$text = elgg_echo("post");
if ($post) {
	$text = elgg_echo("reply");
}
$chars_left = elgg_echo("thewire:charleft");

$parent_input = "";
if ($post) {
	$parent_input = elgg_view("input/hidden", array(
		"name" => "parent_guid",
		"value" => $post->guid,
	));
}

$reshare_input = "";
$post_value = "";
if (!empty($reshare)) {
	$reshare_input = elgg_view("input/hidden", array(
		"name" => "reshare_guid",
		"value" => $reshare->getGUID()
	));

	$reshare_input .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare));

	if (!empty($reshare->title)) {
		$post_value = $reshare->title;
	} elseif (!empty($reshare->name)) {
		$post_value = $reshare->name;
	} elseif (!empty($reshare->description)) {
		$post_value = elgg_get_excerpt($reshare->description, 140);
	}
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 2;
if ($char_limit == 0) {
	$num_lines = 3;
	$count_down = "";
} else if ($char_limit > 140) {
	$num_lines = 3;
}

$post_input = elgg_view("input/plaintext", array(
	"name" => "body",
	"class" => "mtm thewire-textarea",
	"rows" => $num_lines,
	"value" => $post_value,
	"data-max-length" => $char_limit,
));

$submit_button = elgg_view("input/submit", array(
	"value" => $text,
	"class" => "elgg-button elgg-button-submit thewire-submit-button",
));

$mentions = "";
$access_input = "";


echo <<<HTML
	$reshare_input
	$post_input
<div class="thewire-characters-remaining">
	$count_down
</div>
$mentions
<div class="elgg-foot mts">
	$parent_input
	$submit_button
	$access_input
</div>
HTML;

if (elgg_is_xhr()) {
?>
<script type="text/javascript">
		$("#thewire-tools-reshare-wrapper").find('.elgg-form-thewire-add textarea[name="body"]').each(function(i) {
			elgg.thewire_tools.init_autocomplete(this);
		});
</script>
<?php
}


?>