<?php
/*
*
*
*/

$community_button = $vars['community_btn'];
$tags_button = $vars['tags_btn'];
$save_button = $vars['save_btn'];

$help_link = elgg_view('output/url', array(
    'text' => '[?] <span class="wb-invisible">'.elgg_echo("gctags:help:title").'</span>',
    'href' => '/community-help',
    'title' => elgg_echo("gctags:help:title"),
    'target' => '_blank',
));


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
                echo $tags_button;
                
                ?>
            </div>
            <div class="modal-footer">
                <?php echo $save_button; ?>
            </div>
        </div>
    </div>
</div>


