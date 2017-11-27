<?php
/*
Page that deactivated users get redirected to
*/
?>

<div class="panel panel-default">
    <div class="panel-body mrgn-tp-md">
        <p class="mrgn-bttm-md"><?php echo elgg_echo('member_selfdelete:gc:youaredeactivated'); ?></p>
        <?php 
            echo elgg_view('output/url',array('text'=>elgg_echo('member_selfdelete:gc:reactivate:action'), 'href'=>'help/knowledgebase', 'class'=> 'btn btn-primary')); 
            echo elgg_view('output/url',array('text'=>elgg_echo('member_selfdelete:gc:reactivate:browse'), 'href'=>'activity', 'class' =>'mrgn-lft-md',));
        ?>
    </div>
</div>