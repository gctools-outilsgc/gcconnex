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

$object = elgg_get_page_owner_entity();
$lang = get_current_language();

if($object->title3){
		$groupName = gc_explode_translation($object->title3, $lang);
}else{
		$groupName = $object->name;
}

//tool tabs
//Nick - removed the group search tab and created the search form directly into the tab menu
echo '<div class="row clearfix">';
echo '<div class="col-sm-12">'.elgg_view('groups/profile/tab_menu'). '</div>';
//Nick - we can uncomment this when it works
//echo '<div class="col-sm-4">'.elgg_view("groups/sidebar/search", $vars).'</div>';
echo '</div>';
$site_url = elgg_get_site_url();
?>

<div id="groups-tools" class="tab-content clearfix">
    <?php //Create an empty div for all of the group tools that we can append content to.?>


    <div id="about" class="tab-pane fade-in active">

        <?php
    echo elgg_view('groups/profile/fields', $vars);

    echo elgg_view('groups/profile/widget_area', $vars);
        ?>

    </div>
    <div id="groupforumtopic" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('groups:ecml:discussion', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content"/>

        </div>
    </div>
    <div id="blog" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('blog:title:user_blogs', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="file" class="tab-pane fade-in ">
				<h2 class="wb-inv"><?php echo  elgg_echo('file:user', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="bookmarks" class="tab-pane fade-in ">
				<h2 class="wb-inv"><?php echo  elgg_echo('bookmarks:owner', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="polls" class="tab-pane fade-in ">
				<h2 class="wb-inv"><?php echo  elgg_echo('polls:not_me', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="calendar" class="tab-pane fade-in ">
				<h2 class="wb-inv"><?php echo  elgg_echo('event_calendar:listing_title:mine', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="page_top" class="tab-pane fade-in ">
				<h2 class="wb-inv"><?php echo  elgg_echo('pages:owner', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="albums" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('album:user', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="images" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('tidypics:siteimagesowner', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="ideas" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('ideas:owner', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="related" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('groups_tools:related_groups:widget:title', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
    <div id="activity" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('groups:widget:group_activity:title', array($groupName));?></h2>
        <div class="wet-ajax-loader" aria-hidden="true">
            <img src="<?php echo $site_url.'mod/wet4/graphics/loading.gif';?>" alt="loading content" />

        </div>
    </div>
		<div id="questions" class="tab-pane fade-in ">
			<h2 class="wb-inv"><?php echo  elgg_echo('questions:owner', array($groupName));?></h2>
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
