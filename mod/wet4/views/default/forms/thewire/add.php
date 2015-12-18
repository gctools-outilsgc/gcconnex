<?php
/**
 * Wire add form body
 *
 * @uses $vars["post"]
 */

elgg_load_js("elgg.thewire");

$post = elgg_extract("post", $vars);
$char_limit = thewire_tools_get_wire_length();
$reshare = elgg_extract("reshare", $vars); // for reshare functionality

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
	
    //display warning to user if resharing content that is not public on the wire
	$reshare_input .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare));
    
    //see if entity is within a group
    $owner = $reshare->getContainerEntity();

        //check access mode of group
        if(elgg_instanceof($owner, "group") && $owner->getContentAccessMode() == 'members_only'){
            
            echo '<div class="alert alert-warning">
            <p>' . elgg_echo('thewire:contentwarning') . '</p>
            <p>' . elgg_echo('thewire:groupwarning') . '<b><i>' . $owner->name . '</i></b></p>
            </div>';
            
        } else if($reshare->access_id != 2){
            
            $access = elgg_view('output/access', array(
                'name' => 'access',
                'entity' => $reshare,
                ));
            
            echo '<div class="alert alert-warning">
            <p>' . elgg_echo('thewire:contentwarning') . '</p>
            <p>' . elgg_echo('thewire:userwarning') . '<b><i>' . $access . '</i></b></p>
            </div>';
        }
        
        
        
    

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
    "id"=>"wire-body",
	"class" => "mtm thewire-textarea form-control",
	"rows" => $num_lines,
	"value" => $post_value,
	"data-max-length" => $char_limit,
));

$submit_button = elgg_view("input/submit", array(
	"value" => $text,
	"class" => "btn btn-primary elgg-button elgg-button-submit thewire-submit-button",
));

$mentions = "";
$access_input = "";
if (thewire_tools_groups_enabled()) {

	if ($post) {
		$access_input = elgg_view("input/hidden", array("name" => "access_id", "value" => $post->access_id));
	} else {
		$page_owner_entity = elgg_get_page_owner_entity();

		if ($page_owner_entity instanceof ElggGroup) {
			// in a group only allow sharing in the current group
			$access_input = elgg_view("input/hidden", array("name" => "access_id", "value" => $page_owner_entity->group_acl));
			$mentions = "<div class='elgg-subtext mbn'>" . elgg_echo("thewire_tools:groups:mentions") . "</div>";
		} else {
			$params = array(
				"name" => "access_id"
			);
			
			if (elgg_in_context("widgets")) {
				$params["class"] = "thewire-tools-widget-access";
			}
			
			elgg_push_context("thewire_add");
			$access_input = elgg_view("input/access", $params);
			elgg_pop_context();
		}
	}
}
$createWire = elgg_echo('thewire:post');

echo <<<HTML
	$reshare_input
    <label for="wire-body">$createWire</label>
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
