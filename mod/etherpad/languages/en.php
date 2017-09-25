<?php
/**
 * Etherpads English language file
 * 
 * package ElggPad
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	 
	'etherpad' => "Docs (Beta)",
	'etherpad:single' => "Doc",
	'etherpad:docs' => "Docs (Beta)",
	'etherpad:owner' => "%s's Docs",
	'etherpad:friends' => "Colleagues' Docs",
	'etherpad:all' => "All site Docs",
	'docs:add' => "Create a new Doc",
	'etherpad:add' => "Create a new Doc",
	'etherpad:timeslider' => 'History',
	'etherpad:fullscreen' => 'Fullscreen',
	'etherpad:none' => 'No Docs created yet',
	'docs:none' => 'No Docs created yet',
	'docs:more' => 'All Docs',
	
	'etherpad:group' => 'Group Docs',
	'groups:enablepads' => 'Enable group Docs',
	
	/**
	 * River
	 */
	'river:create:object:etherpad' => '%s created a new Doc %s',
	'river:create:object:subpad' => '%s created a new Doc %s',
	'river:update:object:etherpad' => '%s updated the Doc %s',
	'river:update:object:subpad' => '%s updated the Doc %s',
	'river:comment:object:etherpad' => '%s commented on the Doc %s',
	'river:comment:object:subpad' => '%s commented on the Doc %s',
	
	'item:object:etherpad' => 'Docs',
	'item:object:subpad' => 'Subdocs',

	/**
	 * Status messages
	 */

	'etherpad:saved' => "Your Doc was successfully saved.",
	'etherpad:delete:success' => "Your Doc was successfully deleted.",
	'etherpad:delete:failure' => "Your Doc could not be deleted. Please try again.",
	
	/**
	 * Edit page
	 */
	 
	 'etherpad:title' => "Title",
	 'etherpad:tags' => "Tags",
	 'etherpad:access_id' => "Read access",
	 'etherpad:write_access_id' => "Write access",

	/**
	 * Admin settings
	 */

	'etherpad:etherpadhost' => "Etherpad lite host address:",
	'etherpad:etherpadkey' => "Etherpad lite api key:",
	'etherpad:showfullscreen' => "Show full screen button?",
	'etherpad:showchat' => "Show chat?",
	'etherpad:linenumbers' => "Show line numbers?",
	'etherpad:showcontrols' => "Show controls?",
	'etherpad:monospace' => "Use monospace font?",
	'etherpad:showcomments' => "Show comments?",
	'etherpad:newdoctext' => "New Doc text:",
	'etherpad:doc:message' => 'New Doc created successfully.',
	'etherpad:integrateinpages' => "Integrate Docs and pages? (Requires Pages plugin to be enabled)",
	
	/**
	 * Widget
	 */
	'etherpad:profile:numbertodisplay' => "Number of Docs to display",
    'etherpad:profile:widgetdesc' => "Display your latest Docs",
    
    /**
	 * Sidebar items
	 */
	'etherpad:newchild' => "Create a Subdoc",
);

add_translation('en', $english);
