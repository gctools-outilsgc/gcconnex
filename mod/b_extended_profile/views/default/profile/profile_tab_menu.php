<?php
/**
 * Group Profile Tools Tab Menu
 *
 *
 *
 * - if adding an additional tool to groups
 * - make sure it's link priority is before "more" and "search"
 * - Nick - removed the search tab button to replace with an inline search form. Activity tab is now showing up :(
 */


$owner = elgg_get_page_owner_entity();

     if (empty($_GET['pg']))  {
$pg = '';

}else{

     $pg = $_GET['pg'];

}

if(elgg_get_context() == 'groupSubPage'){

    elgg_register_menu_item('owner_block', array(
    'name' => 'about',
    'href' => $owner->getURL(),
    'text' => elgg_echo('gprofile:about'),
    'title' => elgg_echo('gprofile:about'),
    'class' => '',
    'priority' => '0',
    ));

} else if(elgg_get_context() == 'group_profile'){

    elgg_register_menu_item('owner_block', array(
    'name' => 'about',
    'href' => '#about',
    'text' => elgg_echo('gprofile:about'),
    'title' => elgg_echo('gprofile:about'),
    'item_class' => 'active',
    'data-toggle' => 'tab',
    'class' => '',
    'priority' => '0',
    ));

} else if(elgg_get_context() == 'profile'){
    if ($pg == 'splashboard'){

        elgg_register_menu_item('owner_block', array(
    'name' => 'profile',
    'href' => '#profile-display',
    'text' => elgg_echo('gcconnex_profile:profile'),
    //'item_class' => 'active',
    'data-toggle' => 'tab',
    'class' => '',
    'priority' => '0',
    ));
    }else {

    elgg_register_menu_item('owner_block', array(
    'name' => 'profile',
    'href' => '#profile-display',
    'text' => elgg_echo('gcconnex_profile:profile'),
    'item_class' => 'active',
    'data-toggle' => 'tab',
    'class' => '',
    'priority' => '0',
    ));
    }


    // elgg_register_menu_item('owner_block', array(
    // 'name' => 'portfolio',
    // 'href' => '#portfolio',
    // 'text' => elgg_echo('gcconnex_profile:portfolio'),
    // 'data-toggle' => 'tab',
    // 'class' => '',
    // 'priority' => '0',
    // ));

	if ($owner->orgStruct){
    	elgg_register_menu_item('owner_block', array(
    		'name' => 'orgs',
    		'href' => '#org',
    		'text' => elgg_echo('geds:org:orgTab'),
    		'data-toggle' => 'tab',
    		'class' => '',
    		'priority' => '0',
    	));
  	}

     if ($pg == 'splashboard'){
        elgg_register_menu_item('owner_block', array(
        'name' => 'widgets',
        'href' => '#splashboard',
        'text' => elgg_echo('gcconnex_profile:widgets'),
        'data-toggle' => 'tab',
        'item_class' => 'active',
        'class' => '',
        'priority' => '0',
        ));
    }else{
        // elgg_register_menu_item('owner_block', array(
        // 'name' => 'widgets',
        // 'href' => '#splashboard',
        // 'text' => elgg_echo('gcconnex_profile:widgets'),
        // 'data-toggle' => 'tab',
        // 'class' => '',
        // 'priority' => '0',
        // ));
    }
}

if(elgg_in_context('group_profile')){
    $group_only_class = 'wet-group-tabs';
}else{
    $group_only_class = '';
}
//if(elgg_get_context() == 'group_profile'){
echo '<nav role="navigation">';
echo '<h2 class="wb-invisible">'.elgg_echo('profile:content:menu').'</h2>';
echo elgg_view_menu('owner_block', array('entity' => $owner, 'class' => 'nav nav-tabs tabMenuGroup clearfix ' .$group_only_class, 'sort_by' => 'priority',));
echo '</nav>';
//}
//condition for page
//see what page we are on for proper js
if(elgg_get_context() == 'group_profile'){
    $num = 1;
} else {
    $num = 2;
}

//display more items on user profile page
if(elgg_get_context() == 'profile'){
    $itemNum = 6;
} else {
    //Nick - this formats the tabs properly but now activity is showing up instead of hiding away like it should *If group has activity active which we might turn on for everyone
    $itemNum = 4;
}

 ?>

<script type="text/javascript">

    //place additional group tools in dropdown menu
    $(document).ready( function(){

    <?php if(elgg_get_context() == 'profile'){ ?>
        //add tab data to li's
        $('.tabMenuGroup .elgg-menu-content').attr('data-toggle', 'tab');
        $('.tabMenuGroup .dropdown-toggle').attr('data-toggle', 'dropdown');
        $('.tabMenuGroup .forums').attr('data-toggle', '');
        $('.tabMenuGroup .dropdown-menu a').on('click', function(){
            $('.tabMenuGroup .dropdown-menu li').removeClass('active');
        });
    <?php } ?>

    //focus on tabs when navigating to each panel
    $('.elgg-menu-owner-block-default a').on('click', function(e){
      //get id
      var id = $(this).attr('href');

      //dont do anything if more tab is pressed
      if(id != ''){
          $(id).find('h2').attr('tabindex', '-1').focus();
      }
    });

});


</script>
