<?php

/**
 * View a list of items
 *
 * @package Elgg
 *
 * @uses $vars['items']        Array of ElggEntity, ElggAnnotation or ElggRiverItem objects
 * @uses $vars['offset']       Index of the first list item in complete list
 * @uses $vars['limit']        Number of items per page. Only used as input to pagination.
 * @uses $vars['count']        Number of items in the complete list
 * @uses $vars['base_url']     Base URL of list (optional)
 * @uses $vars['url_fragment'] URL fragment to add to links if not present in base_url (optional)
 * @uses $vars['pagination']   Show pagination? (default: true)
 * @uses $vars['position']     Position of the pagination: before, after, or both
 * @uses $vars['full_view']    Show the full view of the items (default: false)
 * @uses $vars['list_class']   Additional CSS class for the <ul> element
 * @uses $vars['item_class']   Additional CSS class for the <li> elements
 * @uses $vars['item_view']    Alternative view to render list items
 * @uses $vars['no_results']   Message to display if no results (string|Closure)
 */


$items = $vars['items'];
$count = elgg_extract('count', $vars);
$pagination = elgg_extract('pagination', $vars, true);
$position = elgg_extract('position', $vars, 'after');
$no_results = elgg_extract('no_results', $vars, '');

if (!$items && $no_results) {
	if ($no_results instanceof Closure) {
		echo $no_results();
		return;
	}
	echo "<p class='elgg-no-results'>$no_results</p>";
	return;
}

if (!is_array($items) || count($items) == 0) {
	return;
}

$list_classes = ['list-unstyled elgg-list'];
if (isset($vars['list_class'])) {
	$list_classes[] = $vars['list_class'];
}

$item_classes = ['elgg-item'];
if (isset($vars['item_class'])) {
	$item_classes[] = $vars['item_class'];
}

$nav = ($pagination) ? elgg_view('navigation/pagination', $vars) : '';

$list_items = '';

////////////////
///DATATABLES///
////////////////

if(elgg_in_context('friends') || elgg_in_context('my_groups') || elgg_in_context('groups_members')){ //datatable for colleagues, group members, my groups, messages

    foreach ($items as $item) {
	    $item_view = elgg_view_list_item($item, $vars);
	    if (!$item_view) {
		    continue;
	    }
    
        $heading = $item->getType();

	    $li_attrs = ['class' => $item_classes];

	    if ($item instanceof \ElggEntity) {
		    $guid = $item->getGUID();
		    $type = $item->getType();
		    $subtype = $item->getSubtype();

		    $li_attrs['id'] = "elgg-$type-$guid";

		    $li_attrs['class'][] = "elgg-item-$type";
		    if ($subtype) {
                //                                               
			    $li_attrs['class'][] = "elgg-item-$type-$subtype clearfix";
		    }
	    } else if (is_callable(array($item, 'getType'))) {
		    $li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
	    }

        //stick items in <td> element
	    $list_items = elgg_format_element('td', ['class' => 'data-table-list-item '], $item_view);
        //stick <td> elements in <tr>
        $tR .= elgg_format_element('tr', ['class' => 'testing',], $list_items);
    }

    if ($position == 'before' || $position == 'both') {
	    echo $nav;
    }
    
    //determine what to put in table head based on item subtype
    if($heading == 'user' && elgg_in_context('friends')){ //friends
        $heading = elgg_echo('friends');   
    } else if($heading == 'user' && elgg_in_context('groups_members')){ //group members
        $heading = elgg_echo('groups:members');   
    } else if($heading == 'group' && elgg_in_context('my_groups')){ //my groups
        $heading = elgg_echo('groups');   
    } 

    //create table body
    $tBody = elgg_format_element('tbody', ['class' => ''], $tR);

    //create table head
    $tHead = elgg_format_element('thead', ['class' => ''], '<tr> <th class=""> ' . $heading . '</th> </tr>');

        if(elgg_get_context() == 'messages'){
            //make it so that messages won't be in alphabetical order. Need to pass a JSON array, but elgg is being mean :(
    echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => '', "data-wb-tables"=>"{ \"ordering\" : false }"], $tHead . $tBody);
        }else{
            //pull it all together and display table
    echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => ''], $tHead . $tBody);
        }
    


    if ($position == 'after' || $position == 'both') {
	    echo $nav;
    }

}
if(elgg_in_context('groups') && get_input("filter") == 'yours'){ //datatable for groups/all?filter=yours page

    foreach ($items as $item) {
	    $item_view = elgg_view_list_item($item, $vars);
	    if (!$item_view) {
		    continue;
	    }

        $heading = $item->getType();

	    $li_attrs = ['class' => $item_classes];

	    if ($item instanceof \ElggEntity) {
		    $guid = $item->getGUID();
		    $type = $item->getType();
		    $subtype = $item->getSubtype();

		    $li_attrs['id'] = "elgg-$type-$guid";

		    $li_attrs['class'][] = "elgg-item-$type";
		    if ($subtype) {
                //
			    $li_attrs['class'][] = "elgg-item-$type-$subtype clearfix";
		    }
	    } else if (is_callable(array($item, 'getType'))) {
		    $li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
	    }

        //stick items in <td> element
	    $list_items = elgg_format_element('td', ['class' => 'data-table-list-item '], $item_view);
        //stick <td> elements in <tr>
        $tR .= elgg_format_element('tr', ['class' => 'testing',], $list_items);
    }

    if ($position == 'before' || $position == 'both') {
	    echo $nav;
    }

    //determine what to put in table head based on item subtype

  if($heading == 'group' && elgg_in_context('groups')){ //my groups
        $heading = elgg_echo('groups');
    }

    //create table body
    $tBody = elgg_format_element('tbody', ['class' => ''], $tR);

    //create table head
    $tHead = elgg_format_element('thead', ['class' => ''], '<tr> <th class=""> ' . $heading . '</th> </tr>');

    if(elgg_get_context() == 'messages'){
        //make it so that messages won't be in alphabetical order. Need to pass a JSON array, but elgg is being mean :(
        echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => '', "data-wb-tables"=>"{ \"ordering\" : false }"], $tHead . $tBody);
    }else{
        //pull it all together and display table
        echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => ''], $tHead . $tBody);
    }



    if ($position == 'after' || $position == 'both') {
	    echo $nav;
    }

} else if(elgg_in_context('messages')) {

    foreach ($items as $item) {
	    $item_view = elgg_view_list_item($item, $vars);
	    if (!$item_view) {
		    continue;
	    }

        $heading = $item->getType();

	    $li_attrs = ['class' => $item_classes];

	    if ($item instanceof \ElggEntity) {
		    $guid = $item->getGUID();
		    $type = $item->getType();
		    $subtype = $item->getSubtype();

		    $li_attrs['id'] = "elgg-$type-$guid";

		    $li_attrs['class'][] = "elgg-item-$type";
		    if ($subtype) {
                //
			    $li_attrs['class'][] = "elgg-item-$type-$subtype clearfix";
		    }
	    } else if (is_callable(array($item, 'getType'))) {
		    $li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
	    }

        $mess_check = elgg_view('input/checkbox', array(
			'name' => 'message_id[]',
			'value' => $item->guid,

		));


        //stick items in <td> element
        $list_items = elgg_format_element('td', ['class' => 'data-table-list-item '], $mess_check);
	    $list_items .= elgg_format_element('td', ['class' => 'data-table-list-item '], $item_view);
        //stick <td> elements in <tr>
        $tR .= elgg_format_element('tr', ['class' => 'testing',], $list_items);
    }

    if ($position == 'before' || $position == 'both') {
	    echo $nav;
    }
        $heading = elgg_echo('messages');


    //create table body
    $tBody = elgg_format_element('tbody', ['class' => ''], $tR);

    //create table head
    $tHead = elgg_format_element('thead', ['class' => ''], '<tr><th><input type="checkbox" name="select_all" value="Toggle All" id="table-select-all"></th> <th class=""> ' . $heading . '</th> </tr>');


        //make it so that messages won't be in alphabetical order. Need to pass a JSON array, but elgg is being mean :(
        echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => '', "data-wb-tables"=>"{ \"ordering\" : false }"], $tHead . $tBody);

        ?>
        
        <script>
        $('#table-select-all').on('click', function(){
            $('input[type="checkbox"]').prop('checked', this.checked);
        });

        $('div .message').on('hover', function(){
            $(this).css('cursor', 'pointer');
            $(this).on('click', function(){
               var link = $(this).find("a:first").attr('href');
               window.location.href = link;
            });
        });
        </script>
        
        <?php

    if ($position == 'after' || $position == 'both') {
	    echo $nav;
    }

} else { //normal list for everything else
    
    foreach ($items as $item) {
	$item_view = elgg_view_list_item($item, $vars);
	if (!$item_view) {
		continue;
	}

	$li_attrs = ['class' => $item_classes];

	if ($item instanceof \ElggEntity) {
		$guid = $item->getGUID();
		$type = $item->getType();
		$subtype = $item->getSubtype();

		$li_attrs['id'] = "elgg-$type-$guid";

        
        
		$li_attrs['class'][] = "elgg-item-$type list-break mrgn-tp-md clearfix";
        
        
		if ($subtype) {
                                                          
			$li_attrs['class'][] = "elgg-item-$type-$subtype clearfix";
		}
	} else if (is_callable(array($item, 'getType'))) {
		$li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
	}

	$list_items .= elgg_format_element('li', $li_attrs, $item_view);
}

if ($position == 'before' || $position == 'both') {
	echo $nav;
}

echo elgg_format_element('ul', ['class' => $list_classes], $list_items);

if ($position == 'after' || $position == 'both') {
	echo $nav;
}
}