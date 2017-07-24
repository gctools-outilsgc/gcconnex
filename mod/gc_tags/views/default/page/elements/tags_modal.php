<?php
/*
* Extend save / upload / add forms with the tags and community modal.
* This removes the tags input that is on most forms, and changes the button text to say "Tag and create"
* This modal is opened from validate.js (in wet4) when the submit handler is run
*
* @author Nick github.com/piet0024
*/

$entity = elgg_extract('entity', $vars, false);
$audience = elgg_extract('audience', $vars, false);
$guid = elgg_extract('guid', $vars, null);

$help_link_main = elgg_view('output/url', array(
    'text' => '[?] <span class="wb-invisible">'.elgg_echo("gctags:help:title").'</span>',
    'href' => '/community-help',
    'title' => elgg_echo("gctags:help:title"),
    'target' => '_blank',
));

$help_link_tags = elgg_view('output/url', array(
    'text' => '[?] <span class="wb-invisible">'.elgg_echo("gctags:help:tags").'</span>',
    'href' => '/community-help#what-are-tags',
    'title' => elgg_echo("gctags:help:tags"),
    'target' => '_blank',
));

$community_button = elgg_view('input/community',array(
    'entity' => $entity,
    'value' => $vars['audience'],
    'guid' => $guid,
));

//different mods like to call tags other things! neato
if(elgg_in_context('groups')){
    $tag_name = 'interests';
}else{
    $tag_name ='tags';
}
$tags_button = elgg_view('input/tags',array(
    'name' => $tag_name,
    'value' => $vars[$tag_name],
));


$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('publish'),
	'name' => 'save',
    'class' => 'btn btn-primary form-submit',
));

$cancel_tagging = elgg_view('output/url',array(
    'text' => elgg_echo('close'),
    'href' => '#',
    'class' => 'close-tag-modal',
    'data-dismiss' => 'modal',
    'aria-label' => 'Close',
));
$buttonText = elgg_echo('gctags:button:create');
?>


<div class="modal fade tags-modal" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="Tags and Communities">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-title">
                    <span class="h4"><?php echo elgg_echo('gctags:modal:header');?></span>
                    <span><?php echo $help_link; ?></span>
                </div>
            </div>
            <div class="modal-body">
               <?php
                 echo $community_button;
                echo elgg_format_element('label', array('for' => 'tags'), elgg_echo('tags'));
                echo elgg_format_element('span',array('class' => 'mrgn-lft-sm'),$help_link_tags);
                echo $tags_button;
                
                ?>
            </div>
            <div class="modal-footer">
                <?php 
                    echo $cancel_tagging;
                    echo $save_button; 
                ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('form .tag-wrapper:first').remove();
    $('label[for~="<?php echo $tag_name; ?>"]:first').remove();
    $('button[type="submit"]:first').text('<?php echo $buttonText; ?>');
    
})
</script>
