<?php

/**
 * Return default results for searches on objects.
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $value
 * @param unknown_type $params
 * @return unknown_type
 */
function elgg_solr_file_search($hook, $type, $value, $params) {

	$language = get_language();
    $select = array(
        'start'  => $params['offset'],
        'rows'   => $params['limit'] ? $params['limit'] : 10,
		'querydefaultfield' => "text_{$language}",
		'query' => $params['query'],
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }

    // create a client instance
    $client = elgg_solr_get_client();

    // get an update query instance
    $query = $client->createSelect($select);
	
	$default_sorts = array(
		'date_created' => 'desc'
	);
	
	$sorts = $params['sorts'] ? $params['sorts'] : $default_sorts;
	$query->addSorts($sorts);
		
	$params['fq']['type'] = 'type:object';
	$params['fq']['subtype'] = 'subtype:file';

    $default_fq = elgg_solr_get_default_fq($params);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
            $query->createFilterQuery($key)->setQuery($value);
        }
    }

    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
	$hlfields = array("text_{$language}");
	if ($params['hlfields']) {
		$hlfields = $params['hlfields'];
	}
    $hl->setFields($hlfields);
    $hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');
	
	$fragsize = elgg_solr_get_fragsize();
	if (isset($params['fragsize'])) {
		$fragsize = (int) $params['fragsize'];
	}
	$hl->setFragSize($fragsize);


    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
    $count = $resultset->getNumFound();
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();

	$search_results = array();
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	
    foreach ($resultset as $document) {
		$search_results[$document->guid] = array();
		$snippet = '';
            
		// highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->guid);

        if($highlightedDoc){
            foreach($highlightedDoc as $field => $highlight) {
                $snippet = implode(' (...) ', $highlight);
				// get our highlight based on the wrapped tokens
				// note, this is to prevent partial html from breaking page layouts
				preg_match_all('/<span data-hl="elgg-solr">(.*?)<\/span>/', $snippet, $match);

				if ($match[1]) {
					$matches = array_unique($match[1]);
					foreach ($matches as $m) {
						$snippet = str_replace($m, $hl_prefix . $m . $hl_suffix, $snippet);	
					}
					$snippet = $purifier->purify($snippet);
				}
				
				$search_results[$document->guid][$field] = $snippet;
            }
        }

		// normalize description with attr_content
		$search_results[$document->guid]["description_{$language}"] = trim($search_results[$document->guid]["description_{$language}"]);
    }
	
	// get the entities in a single query
	// resort them into the order returned by solr by looping through $search_results
	$entities = array();
	$entities_unsorted = array();
	if ($search_results) {
		$entities_unsorted = elgg_get_entities(array(
			'guids' => array_keys($search_results),
			'limit' => false
		));
	}
	
	foreach ($search_results as $guid => $matches) {
		foreach ($entities_unsorted as $e) {
			if ($e->guid == $guid) {
				
				$desc_suffix = '';

				if ($matches["title__{$language}"]) {
					$e->setVolatileData('search_matched_title', $matches["title_{$language}"]);
				}
				else {
					$e->setVolatileData('search_matched_title', gc_explode_translation($e->title, $language));
				}
				
				if ($matches["description_{$language}"]) {
					$desc = $matches["description_{$language}"];
				}
				else {
						$desc = elgg_get_excerpt(gc_explode_translation($e->description, $language), 100);
				}
											
				unset($matches["title_{$language}"]);
				unset($matches["description_{$language}"]);
				$desc .= implode('...', $matches);
				
				$e->setVolatileData('search_matched_description', $desc . $desc_suffix);
				
				$entities[] = $e;
			}
		}
	}

    return array(
        'entities' => $entities,
        'count' => $count,
    );
}


function elgg_solr_object_search($hook, $type, $return, $params) {
	$language = get_language();

    $select = array(
        'start'  => $params['offset'],
        'rows'   => $params['limit'] ? $params['limit'] : 10,
		'query' => $params['query'],
		'querydefaultfield' => "text_{$language}"
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }
	
    // create a client instance
    $client = elgg_solr_get_client($select);

    // get an update query instance
    $query = $client->createSelect($select);
	
	// this query is now a dismax query
	$query->setQuery($params['query']);

	$default_sorts = array(
		'date_created' => 'desc'
	);
	
	$sorts = $params['sorts'] ? $params['sorts'] : $default_sorts;
	$query->addSorts($sorts);
	
	// make sure we're only getting objectss
	$params['fq']['type'] = 'type:object';

	$default_fq = elgg_solr_get_default_fq($params);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
            $query->createFilterQuery($key)->setQuery($value);
        }
    }

    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
	$hlfields = array("text_{$language}");
	if ($params['hlfields']) {
		$hlfields = $params['hlfields'];
	}
    $hl->setFields($hlfields);
	$hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');
	
	$fragsize = elgg_solr_get_fragsize();
	if (isset($params['fragsize'])) {
		$fragsize = (int) $params['fragsize'];
	}
	$hl->setFragSize($fragsize);

	
    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
    $count = $resultset->getNumFound();
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);

    $search_results = array();
    foreach ($resultset as $document) {
		$search_results[$document->guid] = array();
		$snippet = '';
            
		// highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->guid);

        if($highlightedDoc){
            foreach($highlightedDoc as $field => $highlight) {
                $snippet = implode(' (...) ', $highlight);
				// get our highlight based on the wrapped tokens
				// note, this is to prevent partial html from breaking page layouts
				preg_match_all('/<span data-hl="elgg-solr">(.*?)<\/span>/', $snippet, $match);

				if ($match[1]) {
					$matches = array_unique($match[1]);
					foreach ($matches as $m) {
						$snippet = str_replace($m, $hl_prefix . $m . $hl_suffix, $snippet);	
					}
					$snippet = $purifier->purify($snippet);
				}
				
				$search_results[$document->guid][$field] = $snippet;
            }
        }
    }
	
	// get the entities
	$entities = array();
	$entities_unsorted = array();
	if ($search_results) {
		$entities_unsorted = elgg_get_entities(array(
			'guids' => array_keys($search_results),
			'limit' => false
		));
	}
	
	foreach ($search_results as $guid => $matches) {
		foreach ($entities_unsorted as $e) {
			
			$desc_suffix = '';
			
			if ($e->guid == $guid) {
				if ($matches["title_{$language}"]) {
					$e->setVolatileData('search_matched_title', $matches["title_{$language}"]);
				}
				else {
					$e->setVolatileData('search_matched_title', gc_explode_translation($e->title, $language));
				}
				
				if ($matches["description_{$language}"]) {
					$desc = $matches["description_{$language}"];
				}
				else {
					$desc = elgg_get_excerpt(gc_explode_translation($e->description, $language), 100);
				}
				
				unset($matches["title_{$language}"]);
				unset($matches["description_{$language}"]);
				$desc .= implode('...', $matches);
				
				$e->setVolatileData('search_matched_description', $desc . $desc_suffix);
				$entities[] = $e;
			}
		}
	}

    return array(
        'entities' => $entities,
        'count' => $count,
    );
}



function elgg_solr_user_search($hook, $type, $return, $params) {

	$language = get_language();

    $select = array(
		'querydefaultfield' => "text_{$language}",
        'start'  => $params['offset'],
		'rows'   => $params['limit'] ? $params['limit'] : 10,
		'query' => $params['query']
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }

    // create a client instance
    $client = elgg_solr_get_client();

    // get an update query instance
    $query = $client->createSelect($select);
	
	$default_sorts = array(
		'date_created' => 'desc'
	);

	if ($params['qf']) {
		$qf = $params['qf'];
	}

	// make sure we're only getting users
	$params['fq']['type'] = 'type:user';

	if( $params['user_type'] ){
		$params['fq']['user_type'] = 'user_type:"' . $params['user_type'] . '"';
	}

	$default_fq = elgg_solr_get_default_fq($params);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
			if ($key == 'subtype') continue;
            $query->createFilterQuery($key)->setQuery($value);
		}
    }
	
    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
	$hlfields = array("text_{$language}");
	
	if ($params['hlfields']) {
		$hlfields = $params['hlfields'];
	}
    $hl->setFields($hlfields);
	$hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');
	
	$fragsize = elgg_solr_get_fragsize();
	if (isset($params['fragsize'])) {
		$fragsize = (int) $params['fragsize'];
	}
	$hl->setFragSize($fragsize);

    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
	$count = $resultset->getNumFound();
	
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();
	
	$search_results = array();
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	
    foreach ($resultset as $document) {
		$search_results[$document->guid] = array();
		$snippet = '';
            
		// highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->guid);

        if($highlightedDoc){
            foreach($highlightedDoc as $field => $highlight) {
                $snippet = implode(' (...) ', $highlight);
				// get our highlight based on the wrapped tokens
				// note, this is to prevent partial html from breaking page layouts
				preg_match_all('/<span data-hl="elgg-solr">(.*?)<\/span>/', $snippet, $match);

				if ($match[1]) {
					$matches = array_unique($match[1]);
					foreach ($matches as $m) {
						$snippet = str_replace($m, $hl_prefix . $m . $hl_suffix, $snippet);	
					}
					$snippet = $purifier->purify($snippet);
				}
				
				$search_results[$document->guid][$field] = $snippet;
            }
        }
    }

	// get the entities
	$entities = array();
	$entities_unsorted = array();
	if ($search_results) {
		$entities_unsorted = elgg_get_entities(array(
			'guids' => array_keys($search_results),
			'limit' => false
		));
	}
	
	foreach ($search_results as $guid => $matches) {
		foreach ($entities_unsorted as $e) {
			if ($e->guid == $guid) {
				
				$desc_suffix = '';
				if ($matches["name_{$language}"]) {
					$name = $matches["name_{$language}"];
					if ($matches['username']) {
						$name .= ' (@' . $matches['username'] . ')';
					}
					else {
						$name .= ' (@' . $e->username . ')';
					}
					$e->setVolatileData('search_matched_name', $name);
					$e->setVolatileData('search_matched_title', $name);
				}
				else {
					$name = gc_explode_translation($e->name, $language);
					if ($matches['username']) {
						$name .= ' (@' . $matches['username'] . ')';
					}
					else {
						$name .= ' (@' . $e->username . ')';
					}
					$e->setVolatileData('search_matched_name', $name);
					$e->setVolatileData('search_matched_title', $name);
				}
				
				// anything not already matched can be lumped in with the description
				unset($matches["name_{$language}"]);
				unset($matches['username']);
				$desc_suffix .= implode('...', $matches);
				$desc_hl = search_get_highlighted_relevant_substrings($e->description, $params['query']);
				$e->setVolatileData('search_matched_description', $desc_hl . $desc_suffix);
				$entities[] = $e;
			}
		}
	}

    return array(
        'entities' => $entities,
        'count' => $count,
    );
}



function elgg_solr_group_search($hook, $type, $return, $params) {

	$language = get_language();
	 
    $select = array(
        'start'  => $params['offset'],
        'rows'   => $params['limit'] ? $params['limit'] : 10,
		'query' => $params['query'],
		'querydefaultfield' => "text_{$language}",
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }

    // create a client instance
    $client = elgg_solr_get_client();

    // get an update query instance
    $query = $client->createSelect($select);
	
	$default_sorts = array(
		'date_created' => 'desc'
	);
	
	$sorts = $params['sorts'] ? $params['sorts'] : $default_sorts;
	$query->addSorts($sorts);
	
	// this query is now a dismax query
	$query->setQuery($params['query']);
	
	// make sure we're only getting groups
	$params['fq']['type'] = 'type:group';

	$default_fq = elgg_solr_get_default_fq($params);
	unset($default_fq['subtype']);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
            $query->createFilterQuery($key)->setQuery($value);
        }
    }

    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
	$hlfields = array("text_{$language}");
	if ($params['hlfields']) {
		$hlfields = $params['hlfields'];
	}
    $hl->setFields($hlfields);
	$hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');
	
	$fragsize = elgg_solr_get_fragsize();
	if (isset($params['fragsize'])) {
		$fragsize = (int) $params['fragsize'];
	}
	$hl->setFragSize($fragsize);


    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
    $count = $resultset->getNumFound();
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();	

	$search_results = array();
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	
    foreach ($resultset as $document) {
		$search_results[$document->guid] = array();
		$snippet = '';
            
		// highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->guid);

        if($highlightedDoc){
            foreach($highlightedDoc as $field => $highlight) {
                $snippet = implode(' (...) ', $highlight);
				// get our highlight based on the wrapped tokens
				// note, this is to prevent partial html from breaking page layouts
					preg_match_all('/<span data-hl="elgg-solr">(.*?)<\/span>/', $snippet, $match);

				if ($match[1]) {
					$matches = array_unique($match[1]);
					foreach ($matches as $m) {
						$snippet = str_replace($m, $hl_prefix . $m . $hl_suffix, $snippet);	
					}
					$snippet = $purifier->purify($snippet);
				}
				
				$search_results[$document->guid][$field] = $snippet;
            }
        }
    }

	// get the entities
	$entities = array();
	$entities_unsorted = array();
	if ($search_results) {
		$entities_unsorted = elgg_get_entities(array(
			'guids' => array_keys($search_results),
			'limit' => false
		));
	}
	
	foreach ($search_results as $guid => $matches) {
		foreach ($entities_unsorted as $e) {
			
			$desc_suffix = '';
				
			if ($e->guid == $guid) {
				if ($matches["name_{$language}"]) {
					$name = $matches["name_{$language}"];
					$e->setVolatileData('search_matched_name', $name);
					$e->setVolatileData('search_matched_title', $name);
				}
				else {
					$name = gc_explode_translation($e->name, $language);
					$e->setVolatileData('search_matched_name', $name);
					$e->setVolatileData('search_matched_title', $name);
				}
				
				if ($matches["description_{$language}"]) {
					$desc = $matches["description_{$language}"];
				}
				else {
					$desc = search_get_highlighted_relevant_substrings(gc_explode_translation($e->description, $language), $params['query']);
				}
				
								
				unset($matches["name_{$language}"]);
				unset($matches["description_{$language}"]);
				$desc .= implode('...', $matches);
				
				$e->setVolatileData('search_matched_description', $desc . $desc_suffix);
				
				$entities[] = $e;
			}
		}
	}

    return array(
        'entities' => $entities,
        'count' => $count,
    );
}


function elgg_solr_user_settings_save($hook, $type, $return, $params) {
	$user_guid = (int) get_input('guid');
	$user = get_user($user_guid);
	
	if (!$user) {
		return $return;
	}
	
	$guids = elgg_get_config('elgg_solr_sync');
	if (!is_array($guids)) {
		$guids = array();
	}
	$guids[$user->guid] = 1; // use key to keep it unique
	
	elgg_set_config('elgg_solr_sync', $guids);
	
	return $return;
}


/* Thursday, July 12 2018
 * this won't be used for now, temporarily disabled
 */
function elgg_solr_tag_search($hook, $type, $return, $params) {
	
	$valid_tag_names = elgg_get_registered_tag_metadata_names();
	
	if (!$valid_tag_names || !is_array($valid_tag_names)) {
		return array('entities' => array(), 'count' => 0);
	}

	// if passed a tag metadata name, only search on that tag name.
	// tag_name isn't included in the params because it's specific to
	// tag searches.
	if ($tag_names = get_input('tag_names')) {
		if (is_array($tag_names)) {
			$search_tag_names = $tag_names;
		} else {
			$search_tag_names = array($tag_names);
		}

		// check these are valid to avoid arbitrary metadata searches.
		foreach ($search_tag_names as $i => $tag_name) {
			if (!in_array($tag_name, $valid_tag_names)) {
				unset($search_tag_names[$i]);
			}
		}
	} else {
		$search_tag_names = $valid_tag_names;
	}
	
	$query_parts = array();
	foreach ($search_tag_names as $tagname) {
		// @note - these need to be treated as literal exact matches, so encapsulate in double-quotes
		//$query_parts[] = 'tags:"' . elgg_solr_escape_special_chars($tagname . '%%' . $params['query']) . '"';
	}
	
	if (!$query_parts) {
		return array('entities' => array(), 'count' => 0);
	}
	
	$q = implode(' OR ', $query_parts);

	$select = array(
        'query'  => $q,
        'start'  => $params['offset'],
        'rows'   => $params['limit'],
        'fields' => array('id','title','description','score')
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }

	$client = elgg_solr_get_client();
// get an update query instance
    $query = $client->createSelect($select);
	
	$default_sorts = array(
		'score' => 'desc',
		'date_created' => 'desc'
	);
	
	$sorts = $params['sorts'] ? $params['sorts'] : $default_sorts;
	$query->addSorts($sorts);
	
	$default_fq = elgg_solr_get_default_fq($params);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
            $query->createFilterQuery($key)->setQuery($value);
        }
    }

    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
    //$hl->setFields(array('tags'));
    $hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');

    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
    $count = $resultset->getNumFound();
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();

	$search_results = array();
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	
    foreach ($resultset as $document) {
		$search_results[$document->id] = array();
        $snippet = '';

        // highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->id);

        if($highlightedDoc){
            foreach($highlightedDoc as $field => $highlight) {
				// a little hackery for matched tags
				$snippet = array();
                foreach ($highlight as $key => $h) {
					$matched = $hl_prefix;
					$matched .= substr(strstr(elgg_strip_tags($h), '%%'), 2);
					$matched .= $hl_suffix;
					$snippet[] = $purifier->purify($matched);
				}

				$display = implode(', ', $snippet);
				$search_results[$document->id][$field] = $display;
            }
        }
		$search_results[$document->id]['score'] = $document->score;
    }
	
	// get the entities
	$entities = array();
	$entities_unsorted = array();
	if ($search_results) {
		$entities_unsorted = elgg_get_entities(array(
			'guids' => array_keys($search_results),
			'limit' => false
		));
	}
	
	$show_score = elgg_get_plugin_setting('show_score', 'elgg_solr');
	foreach ($search_results as $guid => $matches) {
		foreach ($entities_unsorted as $e) {
			if ($e->guid == $guid) {
				
				$desc_suffix = '';
				if ($show_score == 'yes' && elgg_is_admin_logged_in()) {
					$desc_suffix .= elgg_view('output/longtext', array(
						'value' => elgg_echo('elgg_solr:relevancy', array($matches['score'])),
						'class' => 'elgg-subtext'
					));
				}
			
				$title = $e->title ? $e->title : $e->name;
				$description = $e->description;
				$e->setVolatileData('search_matched_title', $title);
				$e->setVolatileData('search_matched_description', elgg_get_excerpt($description) . $desc_suffix);
				
				//$e->setVolatileData('search_matched_extra', $matches['tags']);
				$entities[] = $e;
			}
		}
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}


// optimize our index daily
function elgg_solr_daily_cron($hook, $type, $return, $params) {
	$ia = elgg_set_ignore_access(true);
	
	$client = elgg_solr_get_client();
	$query = $client->createUpdate();
	$query->addOptimize(true, true, 5);
	
	try {
		$client->update($query);
	}
	catch (Exception $exc) {
		// fail silently
	}
	
	
	// try to catch any missed deletions
	$options = array(
		'guid' => elgg_get_site_entity()->guid,
		'annotation_names' => array('elgg_solr_delete_cache'),
		'limit' => false
	);
	
	$annotations = new ElggBatch('elgg_get_annotations', $options, null, 25, false);
	foreach ($annotations as $a) {
		$client = elgg_solr_get_client();
		$query = $client->createUpdate();
		$query->addDeleteById($a->value);
		$query->addCommit();
			
		try {
			$client->update($query);
		} catch (Exception $exc) {
			// well we tried...
		}
		
		$a->delete();
	}
	
	elgg_set_ignore_access($ia);
}


/**
 * NOTE - this is only used in Elgg 1.8 as comments are annotations
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return null
 */
function elgg_solr_comment_search($hook, $type, $return, $params) {
	
	$entities = array();

    $select = array(
        'start'  => $params['offset'],
        'rows'   => $params['limit'] ? $params['limit'] : 10,
        'fields' => array('id', 'container_guid', 'description', 'owner_guid', 'date_created', 'score'),
    );
	
	if ($params['select'] && is_array($params['select'])) {
        $select = array_merge($select, $params['select']);
    }

    // create a client instance
    $client = elgg_solr_get_client();

    // get an update query instance
    $query = $client->createSelect($select);
	
	$default_sort = array(
		'score' => 'desc',
		'date_created' => 'desc'
	);
	$sorts = $params['sorts'] ? $params['sorts'] : $default_sort;
	
	$query->addSorts($sorts);
	
	$description_boost = elgg_solr_get_description_boost();
	
	// get the dismax component and set a boost query
	$dismax = $query->getEDisMax();
	$qf = "description^{$description_boost}";
	if ($params['qf']) {
		$qf = $params['qf'];
	}
	$dismax->setQueryFields($qf);
	
	$boostQuery = elgg_solr_get_boost_query();
	if ($boostQuery) {
		$dismax->setBoostQuery($boostQuery);
	}
	
	// this query is now a dismax query
	$query->setQuery($params['query']);
	
	
	// make sure we're only getting comments
	$params['fq']['type'] = 'type:annotation';
	$params['fq']['subtype'] = 'subtype:generic_comment';
	
	$default_fq = elgg_solr_get_default_fq($params);
	if ($params['fq']) {
		$filter_queries = array_merge($default_fq, $params['fq']);
	}
	else {
		$filter_queries = $default_fq;
	}

    if (!empty($filter_queries)) {
        foreach ($filter_queries as $key => $value) {
            $query->createFilterQuery($key)->setQuery($value);
        }
    }

    // get highlighting component and apply settings
    $hl = $query->getHighlighting();
    $hl->setFields(array('description'));
   	$hl->setSimplePrefix('<span data-hl="elgg-solr">');
	$hl->setSimplePostfix('</span>');
	
	$fragsize = elgg_solr_get_fragsize();
	if (isset($params['fragsize'])) {
		$fragsize = (int) $params['fragsize'];
	}
	$hl->setFragSize($fragsize);


    // this executes the query and returns the result
    try {
        $resultset = $client->select($query);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Get the highlighted snippet
    try {
        $highlighting = $resultset->getHighlighting();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }

    // Count the total number of documents found by solr
    $count = $resultset->getNumFound();
	$hl_prefix = elgg_solr_get_hl_prefix();
	$hl_suffix = elgg_solr_get_hl_suffix();
	
	$show_score = elgg_get_plugin_setting('show_score', 'elgg_solr');
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	
    foreach ($resultset as $document) {
		// comments entity_guid stored as container_guid in solr
        $entity = get_entity($document->container_guid);
		
		if (!$entity) {
			$entity = new ElggObject();
			$entity->setVolatileData('search_unavailable_entity', TRUE);
		}

        // highlighting results can be fetched by document id (the field defined as uniquekey in this schema)
        $highlightedDoc = $highlighting->getResult($document->id);

        if($highlightedDoc){
            foreach($highlightedDoc as $highlight) {
                $snippet = implode(' (...) ', $highlight);
				// get our highlight based on the wrapped tokens
				// note, this is to prevent partial html from breaking page layouts
				$match = array();
				preg_match('/<span data-hl="elgg-solr">(.*)<\/span>/', $snippet, $match);

				if ($match[1]) {
					$snippet = str_replace($match[1], $hl_prefix . $match[1] . $hl_suffix, $snippet);
					$snippet = $purifier->purify($snippet);
				}
            }
        }
		
		if (!$snippet) {
			$snippet = search_get_highlighted_relevant_substrings(elgg_get_excerpt($document->description), $params['query']);
		}
		
		if ($show_score == 'yes' && elgg_is_admin_logged_in()) {
			$snippet .= elgg_view('output/longtext', array(
				'value' => elgg_echo('elgg_solr:relevancy', array($document->score)),
				'class' => 'elgg-subtext'
			));
		}
		
		$comments_data = $entity->getVolatileData('search_comments_data');
		if (!$comments_data) {
			$comments_data = array();
		}
		$comments_data[] = array(
			'annotation_id' => substr(strstr(elgg_strip_tags($document->id), ':'), 1),
			'text' => $snippet,
			'owner_guid' => $document->owner_guid,
			'date_created' => $document->date_created,
		);
		$entity->setVolatileData('search_comments_data', $comments_data);

        $entities[] = $entity;
    }

    return array(
        'entities' => $entities,
        'count' => $count,
    );
}
