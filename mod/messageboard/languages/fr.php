<?php

$french = array(

	/**
	 * Menu items and titles
	 */

	'messageboard:board' => "Panneau de message",
	'messageboard:messageboard' => "panneau de message",
	'messageboard:viewall' => "voir tous",
	'messageboard:postit' => "poster",
	'messageboard:history:title' => "Histoire",
	'messageboard:none' => "Il n'y a rien sur ce forum pour le momentt",
	'messageboard:num_display' => "Nombre de messages à afficher",
	'messageboard:desc' => "C'est un babillard que vous pouvez mettre sur votre profil lequel les autres utilisateurs peuvent faire des commentaires.",

	'messageboard:user' => "%s's panneau de message",

	'messageboard:replyon' => 'répondre sur',
	'messageboard:history' => "histoire",

	'messageboard:owner' => '%s\'s panneau de message',
	'messageboard:owner_history' => '%s\'s posts on %s\'s message board',

	/**
	 * Message board widget river
	 */
	'river:messageboard:user:default' => "%s posted on %s's message board",

	/**
	 * Status messages
	 */

	'messageboard:posted' => "You successfully posted on the message board.",
	'messageboard:deleted' => "You successfully deleted the message.",

	/**
	 * Email messages
	 */

	'messageboard:email:subject' => 'Vous avez un nouveau babillard commentaire!',
	'messageboard:email:body' => "Vous avez un nouveau commentairesur votre babillard! %s. Il lit:


%s


To view your message board comments, click here:

	%s

To view %s's profile, click here:

	%s

You cannot reply to this email.",

	/**
	 * Error messages
	 */

	'messageboard:blank' => "Sorry; you need to actually put something in the message area before we can save it.",
	'messageboard:notfound' => "Sorry; we could not find the specified item.",
	'messageboard:notdeleted' => "Sorry; we could not delete this message.",
	'messageboard:somethingwentwrong' => "Something went wrong when trying to save your message, make sure you actually wrote a message.",

	'messageboard:failure' => "An unexpected error occurred when adding your message. Please try again.",

);

add_translation("fr", $french);
