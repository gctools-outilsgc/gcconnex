<?php
/**
 * ideas English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */

	'ideas:filter:top' => "Top",
	'ideas:filter:hot' => "Hot",
	'ideas:filter:new' => "New",
	'ideas:filter:accepted' => "Accepted",
	'ideas:filter:completed' => "Completed",
	'ideas:filter:all' => "All",

	'item:object:idea' => 'Idea',
	'river:create:object:idea' => '%s submited idea %s',
	'river:comment:object:idea' => '%s commented on a idea %s',
	'river:update:object:idea' => '%s modified idea %s',

	'ideas' => "Ideas",
	'ideas:add' => "Add idea",
	'ideas:edit' => "Edit idea",
	'ideas:new' => "A new idea",
	'ideas:settings' => "Settings",

	'ideas:all' => "All ideas",
	'ideas:owner' => "%s's ideas",
	'ideas:friends' => "Friends ideas",
	'ideas:idea:edit' => "Edit this idea",
	'ideas:idea:add' => "Add an idea",

	'ideas:group:settings:title' => "Settings of %s's ideas",
	'ideas:group_settings' => "Settings",
	'ideas:enableideas' => "Enable ideas",
	'ideas:group' => 'Group ideas',
	'ideas:group:idea' => 'Group ideas',
	'ideas:same_group' => "In the same group:",
	'ideas:view:all' => "See all",
    
    'ideas:group:image' => '<span class="bpideas">Group ideas</span><img src="/mod/ideas/graphics/BP.gif" alt="Blueprint 2020 ideas" />',
	/**
	 * Content
	 */
	'ideas:yourvotes' => "Your votes:",
	'ideas:vote' => "Vote:",

	'ideas:status' => "Satus:",
	'ideas:state' => "State:",
	'ideas:status_info' => "Information about status:",
	'ideas:open' => 'open',
	'ideas:under_review' => 'under review',
	'ideas:planned' => 'planned',
	'ideas:started' => 'started',
	'ideas:completed' => 'completed',
	'ideas:declined' => 'declined',
	'ideas:minorchange' => "Minor change. Notification will be not notified, instead of you change status.",


	'ideas:none' => "No ideas yet.",
	'ideas:novoteleft' => "vote left.",
	'ideas:onevoteleft' => "vote left.",
	'ideas:votesleft' => "votes left.",

	'ideas:search' => "Search or submit an idea:",
	'ideas:charleft' => "char left.",

	'ideas:search:noresult_nogroupmember' => "No idea found, search again.",
	'ideas:search:result_vote_submit' => "Ideas found. Vote or ",
	'ideas:search:result_novote_submit' => "Idea found. Change your votes or ",
	'ideas:search:result_novote_nosubmit' => "Ideas found. No point left, change your votes if you want to submit a new idea.",
	'ideas:search:noresult_nosubmit' => "No idea found, search again. You should change your votes if you want to submit a new idea.",
	'ideas:search:noresult_submit' => "No idea found. Search again or ",
	'ideas:search:skip_words' => "the,and,for,are,but,not,you,all,any,can,her,was,one,our,out,day,get,has,him,his,how,man,new,now,old,see,two,way,who,boy,did,its,let,put,say,she,too,use,dad,mom", // write words you want to skip separate by coma. Automaticaly skip word less than 3 chars, don't write them.

	'ideas:add' => "submit a new idea",

	'ideas:settings:points' => "Number of points",
	'ideas:settings:question' => "Question",
	'ideas:settings:ideas_submit_idea_without_point' => "Submit idea without point",
	'ideas:settings:ideas_submit_idea_without_point_string' => "Check if you want to offer possibility to group members to submit idea without point. Be carefull of flooding.",

	/**
	 * Widget and bookmarklet
	 */
	'ideas:widget:title' => "Ideas",
	'ideas:widget:description' => "Display ratest ideas.",
	'ideas:more' => "More ideas",
	'ideas:numbertodisplay' => "Number of ideas to display",
	'ideas:typetodisplay' => "Display by",
	'ideas:widget:points_left:title' => "Votes left",
	'ideas:widget:points_left:description' => "Display votes left in each ideas of yours groups.",

	/**
	 * Status messages
	 */
	'ideas:idea:rate:submitted' => "Idea successfully rated.",
	'ideas:idea:save:success' => "Your idea was successfully saved.",
	'ideas:idea:delete:success' => "Your idea was successfully deleted.",
	'ideas:idea:delete:failed' => "An error occurred while deleting idea.",

	'ideas:idea:save:empty' => "You need to set a title and description of the idea.",
	'ideas:idea:save:failed' => "An error occurred while saving idea.",

	'ideas:group:settings:failed' => "There is no group or you don't have acces to edit this group.",
	'ideas:group:settings:save:success' => "Settings of ideas's group succesfully saved.",

	/**
	 * Error messages
	 */
	'ideas:idea:rate:error:ajax' => "Connexion error with server.",
	'ideas:unknown_idea' => "Unknown idea.",
	'ideas:idea:rate:error' => "This idea could not be rated cause internal server problem.",
	'ideas:idea:rate:error:underzero' => "Your votes left cannot permit to rate an idea.",
    
    /* NEW MESSAGING TO BE TRANSLATED */
    'ideas:idea:rate:error:updateerror' => "There has been an error changing your vote.  Please try again later.",
    'ideas:idea:rate:error:voteagain' => "You cannot vote more than once on an idea.  Did you mean to change your vote?",
    'ideas:idea:rate:changevote' => "Your vote has been changed.",
    'ideas:group:newideas' => "Latest Group Ideas",
    'ideas:filter:tagcloud' => "Tag Cloud",
    'ideas:group:nonmember' => "<div class='alert'>You must be a member of this group to vote or submit an idea</div>",
    
    /* CHANGED MESSAGING TO BE TRANSLATED */
    'ideas:idea:rate:error:value' => "An error occurred registering your vote.  Please try again later.",
    
	/*
	 * Notify messages
	 */
	'ideas:notify:subject' => "An idea in which you bet points has been %s.",
	'ideas:notify:body' => "The idea <a href=\"%s\">%s</a> is %s.<br><br>You take back your point which you bet in this idea.<br><br><a href=\"%s\">Go to the ideas of the group %s</a>",
);

add_translation('en', $english);
