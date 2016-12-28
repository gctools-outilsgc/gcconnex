<?php

elgg_register_event_handler('init', 'system', 'gc_fedsearch_gsa_init');

function gc_fedsearch_gsa_init() {
	// strip out all the (broken) hyperlink so that the GSA doesn't recursively create indices
	elgg_register_plugin_hook_handler('view', 'output/longtext', 'entity_url');
	elgg_register_plugin_hook_handler('view', 'groups/profile/fields', 'group_url');
	// css layout for pagination
	$gsa_pagination = elgg_get_plugin_setting('gsa_pagination','gc_fedsearch_gsa');
	if ($gsa_pagination) elgg_extend_view('css/elgg', 'css/intranet_results_pagination', 1);
	
	elgg_extend_view('page/elements/head', 'page/elements/head_gsa', 1);  
}

function group_url($hook, $type, $return, $params) {
	$gsa_agentstring = strtolower(elgg_get_plugin_setting('gsa_agentstring','gc_fedsearch_gsa'));
	if ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0)  {
		if (strcmp(get_context(), 'group_profile') == 0) {
			$params['vars']['entity']->description = "<p>{$params['vars']['entity']->description}</p> <p>{$params['vars']['entity']->description2}</p>";
			return $params['vars']['entity']->description;
		}
	}
}

function entity_url($hook, $type, $return, $params) {
	
	// pull the user agent string and/or user testing
	$gsa_agentstring = strtolower(elgg_get_plugin_setting('gsa_agentstring','gc_fedsearch_gsa'));
	$gsa_usertest = elgg_get_plugin_setting('gsa_test','gc_fedsearch_gsa');
	if ($gsa_usertest) $current_user = elgg_get_logged_in_user_entity();

	// do this only for the gsa-crawler (and usertest is empty)
	if ( ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false )  {

		/*blog pages bookmarks file discussion*/
		$filter_entity = array('blog', 'pages', 'discussion', 'file', 'bookmarks');
		$context = get_context();

		// check to see if the entity contains title and description, then it must be some kind of blog, files, etc..
		if ($context && in_array($context, $filter_entity)) {
			$url = explode('/',$_SERVER['REQUEST_URI']);
			$entity = get_entity($url[3]);
			
			// english body text
			$description = new DOMDocument();
			$description->loadHTML($entity->description);
			$links = $description->getElementsByTagName('a');
			for ($i = $links->length - 1; $i >= 0; $i--) {
				$linkNode = $links->item($i);
				$lnkText = $linkNode->textContent;
				$newTxtNode = $description->createTextNode($lnkText);
				$linkNode->parentNode->replaceChild($newTxtNode, $linkNode);
			}
			$return = $description->textContent."<br/><br/>";


			// french body text
			$description->loadHTML($entity->description2);
			$links = $description->getElementsByTagName('a');
			for ($i = $links->length - 1; $i >= 0; $i--) {
				$linkNode = $links->item($i);
				$lnkText = $linkNode->textContent;
				$newTxtNode = $description->createTextNode($lnkText);
				$linkNode->parentNode->replaceChild($newTxtNode, $linkNode);
			}
			$return .= $description->textContent;	
		}

	} else {
 
		// zube issue 533 (invalid url, appends to end of current URL)
		$url = explode('/',$_SERVER['REQUEST_URI']);
		$entity = get_entity($url[3]);

		// description is determined by the language that has been currently set
		$current_language = get_current_language();
		if(!$current_language) $current_language = 'en';

		$description = new DOMDocument();
		(strcmp($current_language,'en') == 0) ? $description->loadHTML($entity->description) : $description->loadHTML($entity->description2);

		// for all the links <a href= ... />
		$links = $description->getElementsByTagName('a');
		for ($i = $links->length - 1; $i >= 0; $i--) {
			$linkNode = $links->item($i);
			$lnkText = $linkNode->getAttribute('href');

			// if http(s):// is not present, append it
			$url = parse_url($lnkText);
			if (empty($url['scheme'])) {
				$lnkText = $linkNode->setAttribute('href', "http://{$lnkText}");
			}
			
			// remove and replace non-ascii characters
			$lnkText = preg_replace('/[^(\x20-\x7F)]*/','', $lnkText);
			$lnkText = $linkNode->setAttribute('href', $lnkText);

			// remove and replace blocked:: (for users who copy paste from Outlook)
			$lnkText = str_replace("blocked::", "", $lnkText);
		}


		// for all the links <em title= ... />
		$links = $description->getElementsByTagName('em');
		for ($i = $links->length - 1; $i >= 0; $i--) {
			$linkNode = $links->item($i);
			$lnkText = $linkNode->getAttribute('title');

			// remove and replace blocked:: (for users who copy paste from Outlook)
			$lnkText = preg_replace('/^blocked::/','', $lnkText);
			$lnkText = $linkNode->setAttribute('title', $lnkText);
		}

		$return = $description->saveHTML();
	}
   
	return $return;
}

