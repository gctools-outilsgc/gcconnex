<?php

elgg_ws_expose_function("get.wire","get_wire_posts", array(
"query" => array('type' => 'string','required' => false, 'default' => ' '),
"limit" => array('type' => 'int','required' => false, 'default' => 15),
),'returns wire posts based on query',
'GET', false, false);

function get_wire_posts($query, $limit){
	$posts = array();	
	$result = 'Nothing to return';
	$query = trim($query,' \"');
	//error_log($query);
	if ($query){
		$firstChar = $query[0];
		if ($firstChar === '@'){
		//	error_log('@');
			$user = get_user_by_username(substr($query, 1));
			if (!$user){
				return 'user does not exist';
			}
			$options = array(
				'subtype'=>'thewire',
				'type' => 'object',
				'owner_guids' => array($user->guid),
				'limit' => $limit
			);
			$wire_posts = elgg_get_entities($options);
			if (!$wire_posts){
				////////////////////////////////////////////////////////
				//TODO: handle no wire posts by user.
				//return empty result may be valid, or error code, or string
			
				//return 
			}
		}else{
			$options = array(
				//'metadata_name' => 'tags',
				//'metadata_value' => $tag,
				//'metadata_case_sensitive' => false,
				'type' => 'object',
				'subtype' => 'thewire',
				'limit' => $limit,
				'joins' => array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON e.guid = oe.guid"),
				'wheres' => array("oe.description LIKE '%#" . sanitise_string($query) . "%'"),
			);
			$wire_posts = elgg_get_entities($options);
		}
		
	}else{
		$options = array(
			'subtype'=>'thewire',
			'type' => 'object',
			'limit' => $limit
		);	
		$wire_posts = elgg_get_entities($options);
	}
	if (!$wireposts){
		//return 'no wire posts with with #'.$query." tags. For usernames, please add '@' to front of query string";
	}
	$i = 0;
	foreach($wire_posts as $wp){
		//error_log(var_dump($wp));
		$posts['post_'.$i]['text'] = thewire_filter($wp->description);
		$posts['post_'.$i]['time_created'] = $wp->time_created;
		$posts['post_'.$i]['time_since'] = time_elapsed_B(time()-$wp->time_created);
		$posts['post_'.$i]['user'] = get_userBlock($wp->owner_guid);
		
		$i++;
	}
	if ($posts){
		$result = null;
		$result['posts'] = $posts;
	}
	return $result;
	
}
function time_elapsed_B($secs){
    /*$bit = array(
        ' day'        => $secs / 86400 % 7,
        ' hour'        => $secs / 3600 % 24,
        ' minute'    => $secs / 60 % 60,
        ' second'    => $secs % 60
        );
        
    foreach($bit as $k => $v){
        if($v > 1)$ret = $v . $k . 's';
        if($v == 1)$ret = $v . $k;
        }
    //array_splice($ret, count($ret)-1, 0, 'and');
    $ret .= 'ago';
	 * 
    */
    if ($secs / 86400 % 7 >= 1){
    	$num = $secs / 86400 % 7;
    	$string = 'd';
    }else{
    	if ($secs / 3600 % 24 >= 1){
    		$num = $secs / 3600 % 24;
			$string = 'h';
    	}else{
    		if ($secs / 60 % 60 >= 1){
    			$num = $secs / 60 % 60;
				$string = 'm';
    		}else{
    			if ($secs % 60 >= 1){
    				$num = $secs % 60;
					$string = 's';
    			}
    		}
    	}
    }
	
    return $num.$string;
 }