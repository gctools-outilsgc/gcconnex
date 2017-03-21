<?php

elgg_register_event_handler('init', 'system', 'gc_fedsearch_gsa_init');

function gc_fedsearch_gsa_init() {

	// css layout for pagination
	$gsa_pagination = elgg_get_plugin_setting('gsa_pagination','gc_fedsearch_gsa');
	if ($gsa_pagination) elgg_extend_view('css/elgg', 'css/intranet_results_pagination', 1);
	

	if (((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {
		// strip out all the (broken) hyperlink so that the GSA doesn't recursively create indices
		elgg_extend_view('page/elements/head', 'page/elements/head_gsa', 1);
		elgg_register_plugin_hook_handler('view', 'output/longtext', 'entity_url');
		elgg_register_plugin_hook_handler('view', 'groups/profile/fields', 'group_url');

		// these two hook handlers will change and remove the trailing URL (does not include the titles)
		elgg_register_plugin_hook_handler('entity:url', 'object', 'modify_content_url',1);
		elgg_register_plugin_hook_handler('entity:url', 'group', 'modify_group_url');
	}


}

function modify_group_url($hook, $type, $url, $params) {
	$url = explode('/', $_SERVER['REQUEST_URI']);
	if (strpos($_SERVER['REQUEST_URI'],"/groups/profile/") !== false)
	{
		if (sizeof($url) > 4)
			forward("groups/profile/{$params['entity']->guid}");
		//return "groups/profile/{$params['entity']->guid}";
	}
}

/**
 * covers: blogs, files, pages
 * does not cover: bookmarks, missions, images, polls, wire, event
 */
function modify_content_url($hook, $type, $url, $params) {
	$url = explode('/', $_SERVER['REQUEST_URI']);
	if (strpos($_SERVER['REQUEST_URI'],"/view/") !== false)
	{
		$subtype = $params['entity']->getSubtype();
		if ($subtype === 'groupforumtopic') $subtype = 'discussion';
		if ($subtype === 'page_top') $subtype = 'pages';
		if ($subtype === 'idea') $subtype = 'ideas';

		if (sizeof($url) > 4)
			forward("{$subtype}/view/{$params['entity']->guid}");
		//return "{$subtype}/view/{$params['entity']->guid}";
	}
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


	/*blog pages bookmarks file discussion*/
	$filter_entity = array('blog', 'pages', 'discussion', 'file', 'bookmarks');
	$context = get_context();

	// only do it for the main content, comments will be left the way it is
	$comment = new DOMDocument();
	$comment->loadHTML($return);
	$comment_block = $comment->getElementsByTagName('div');
	$comment_text = $comment_block->item(0)->getAttribute('data-role');


	if (( strcmp($comment_text,'comment-text') == 0 || strcmp($comment_text, 'discussion-reply-text') == 0 ))
		return;

	if (!in_array($context, $filter_entity))
		return;

	$url = explode('/',$_SERVER['REQUEST_URI']);
	$entity = get_entity($url[3]);

	// do this only for the gsa-crawler (and usertest is empty)
	if ( ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false )  {
		
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

	return $return;
}

function clean_up_content($content) {

	$description = new DOMDocument();
	$description->loadHTML($content);

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
		$lnkText = str_replace('¨', '', $lnkText);
		$linkNode->setAttribute('href', $lnkText);

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

	return $description->saveHTML();	
	
}

