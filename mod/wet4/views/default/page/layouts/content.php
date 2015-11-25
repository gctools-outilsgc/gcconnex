<?php
/**
 * Main content area layout
 *
 * @uses $vars['content']        HTML of main content area
 * @uses $vars['sidebar']        HTML of the sidebar
 * @uses $vars['header']         HTML of the content area header (override)
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['footer']         HTML of the content area footer
 * @uses $vars['filter']         HTML of the content area filter (override)
 * @uses $vars['title']          Title text (override)
 * @uses $vars['context']        Page context (override)
 * @uses $vars['filter_context'] Filter context: everyone, friends, mine
 * @uses $vars['class']          Additional class to apply to layout
 */

$context = elgg_extract('context', $vars, elgg_get_context());

$vars['title'] = elgg_extract('title', $vars, '');
if (!$vars['title'] && $vars['title'] !== false) {
	$vars['title'] = elgg_echo($context);
}



// 1.8 supported 'filter_override'
if (isset($vars['filter_override'])) {
	$vars['filter'] = $vars['filter_override'];
}

// register the default content filters
if (!isset($vars['filter']) && elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
    
        if((elgg_get_context() == 'blog'))  {
        $tabs = array(
            'all' => array(
                'text' => elgg_echo('all'),
                'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
                'selected' => ($filter_context == 'all'),
                'priority' => 200,
            ),
            'mine' => array(
                'text' => elgg_echo('My blog'),
                'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
                'selected' => ($filter_context == 'mine'),
                'priority' => 300,
            ),
            'champions' => array(
                'text' => elgg_echo('Friends'), //GCconnex Champions
                'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
                'selected' => ($filter_context == 'friends'),
                'priority' => 400,
            ),/*Hide for now
            'authors' => array(
                'text' => elgg_echo('My favorite Authors'),
                'href' => "activity/blog",
                'selected' => ($filter_context == 'sharemaps'),
                'priority' => 500,
            ),*/
        );
        
        } else if((elgg_get_context() == 'thewire')){
            //changing the tabs in the wire to add 'mentioned'
            if($user = elgg_get_logged_in_user_entity()){
                      $tabs = array(
		'all' => array(
			'text' => elgg_echo('all'),
			'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		),
		'mine' => array(
			'text' => elgg_echo('mine'),
			'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
			'selected' => ($filter_context == 'mine'),
			'priority' => 300,
		),
		'friend' => array(
			'text' => elgg_echo('friends'),
			'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		),
        'mention' => array(
            'text' => 'Mentions',
            "href" => "thewire/search/@" . $user->username,
            "text" => elgg_echo("thewire_tools:menu:mentions"),
            "context" => "thewire",
            'priority' => 500,
            ),
        );  
            }

            
            
        }else if((elgg_get_context() == 'friend')){
            $tabs = elgg_view_menu('page', array('sort_by' => 'name'));
            //echo elgg_view_menu('page', array('sort_by' => 'name'));
            //echo '<div>Maybe Im stoopid?</div>';
        }else{
    
	$tabs = array(
		'all' => array(
			'text' => elgg_echo('all'),
			'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		),
		'mine' => array(
			'text' => elgg_echo('mine'),
			'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
			'selected' => ($filter_context == 'mine'),
			'priority' => 300,
		),
		'friend' => array(
			'text' => elgg_echo('friends'),
			'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		),
	);
        }

	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}

$filter = elgg_view('page/layouts/elements/filter', $vars);
$vars['content'] = $filter . $vars['content'];

echo elgg_view_layout('one_sidebar', $vars);
