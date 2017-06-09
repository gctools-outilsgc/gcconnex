<?php
/*
*
*
*/

//$community_button = $vars['community_btn'];
//$tags_button = $vars['tags_btn'];
//$save_button = $vars['save_btn'];

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


$community_button = elgg_view('input/community',array());

$tags_label =
$tags_button = elgg_view('input/tags',array());


$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('publish'),
	'name' => 'save',
    'class' => 'btn btn-primary form-submit',
));



?>

<script>
$(document).ready(function(){
    $('form .tag-wrapper:first').remove();
    $('label[for~="tags"]:first').remove();
    $('button[type="submit"]:first').text('Tag and Create');
})
</script>
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
                <?php echo $save_button; ?>
            </div>
        </div>
    </div>
</div>


