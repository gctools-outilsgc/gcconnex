<?php
/*
Page that deactivated users get redirected to
*/
?>

<div class="panel panel-default">
    <div class="panel-body">
        <h1>Welcome back ya boi</h1>
        <p><?php echo elgg_echo('member_selfdelete:gc:youaredeactivated'); ?></p>
        <?php 
            echo elgg_view('output/url',array('text'=>'help desk link', 'href'=>'#', 'class'=> 'btn btn-primary')); 
            echo elgg_view('output/url',array('text'=>'browse the site without login', 'href'=>'activity', 'class' =>'mrgn-lft-md',));
        ?>
    </div>
</div>