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
$site_url = elgg_get_site_url();
?>

<div id="groups-tools" class="tab-content clearfix">
    <?php //Create an empty div for all of the group tools that we can append content to.?>
    <div id="search" class="collapse panel panel-custom">
    <div class="panel-body">
        <?php 
            
            echo  '<h3>' .   elgg_echo('groups:search_in_group') . '</h3>';
            echo elgg_view("groups/sidebar/search", $vars); 
        ?>
    </div>
</div>

    <div id="about" class="tab-pane fade-in active">

        <?php 
    echo elgg_view('groups/profile/fields', $vars);
                
    echo elgg_view('groups/profile/widget_area', $vars);
        ?>

    </div>
    <div id="groupforumtopic" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content"/>
            
        </div>
    </div>
    <div id="blog" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="file" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="bookmarks" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="polls" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="calendar" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="page_top" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="albums" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="images" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="ideas" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="related" class="tab-pane fade-in ">
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>

    <?php  // Load other widgets to create tabs
        //Nick - Remove group tools content from echoing to the group page
    //echo elgg_view("groups/tool_latest", $vars);
    //echo elgg_view('groups/profile/related');
    ?>
    
    

</div>
