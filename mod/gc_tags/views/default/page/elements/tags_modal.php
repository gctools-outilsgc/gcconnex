<?php
/*
*
*
*/

$community_button = $vars['community_btn'];
$tags_button = $vars['tags_btn'];
$save_button = $vars['save_btn'];

?>

<div class="modal fade tags-modal" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="Tags and Communities">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-title">
                    <?php echo elgg_echo('gctags:modal:header');?>
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


