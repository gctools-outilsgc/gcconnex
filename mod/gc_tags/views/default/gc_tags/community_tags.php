<?php
/*
* Community and Tags input
*
*
*/

$community_array = array(
    'atip'=> elgg_echo('gctags:community:atip'),
    'communications'=> elgg_echo('gctags:community:communications'),
    'evaluators'=> elgg_echo('gctags:community:evaluators'),
);

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'tags',
	'value' => $vars['tags']
));

echo elgg_view('input/community', array());
echo $tags_input;

?>


<script>
$(document).ready(function(){
    //Declarin' vars
    var submitBtn = $("button[name='save']");
    var actionName = $(submitBtn).parents('form').attr('action');
    actionName = actionName.split('/');
    actionName = actionName.slice(2);
    //Click the button I dare ya
    $(submitBtn).on('click', function(event){
        event.preventDefault;
        alert(actionName);
    });
});
</script>