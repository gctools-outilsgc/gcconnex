<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 
	
// backward compatibility
$right = elgg_view('groups/right_column', $vars);
$left = elgg_view('groups/left_column', $vars);
if ($right || $left) {
	elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
	echo $left;
	echo $right;
}

//tool tabs
echo elgg_view('groups/profile/tab_menu');
?>

<div id="groups-tools" class="tab-content clearfix">
    
    <div id="search" class="collapse panel panel-custom">
    <div class="panel-body">
        <?php 
            echo  '<h3>' .   elgg_echo('groups:search_in_group') . '</h3>';
            echo elgg_view("groups/sidebar/search", $vars); 
        ?>
    </div>
</div>

    <div id="<?php echo elgg_echo('gprofile:about') ?>" class="tab-pane fade-in active">

        <?php 
    echo elgg_view('groups/profile/fields', $vars);
                
    echo elgg_view('groups/profile/widget_area', $vars);
        ?>

    </div>

    <?php  // Load other widgets to create tabs
    echo elgg_view("groups/tool_latest", $vars);
    echo elgg_view('groups/profile/related');
    ?>
    
    

</div>
