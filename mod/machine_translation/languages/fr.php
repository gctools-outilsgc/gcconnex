<?php
/**
 * GEDS english language file.
 *
 */

$french = array(
	'machine:linktext' => 'traduire',
	'mc:LCtool:title' => 'Language Comprehension Tool',	//Modal(popup window) title field
	//following is the disclaimer text on modal window. Taken from LC tool terms of use
	'mc:LCtool:disclaimerTitle' => "<h3>Important:</h3>",
	'mc:LCtool:disclaimer1' => "<p>L’<a href='https://outilcl-lctool.spac-pspc.gc.ca/index-fra.php'>Outil de compréhension linguistique</a> permet d'avoir une idée générale de textes à contenu gouvernemental et ne remplace pas les services de langagiers professionnels. Le Bureau de la traduction recommande d'utiliser cet outil à des fins d'amélioration de la compréhension de courtes communications simples et non officielles dans votre langue seconde.</p>",
	'mc:LCtool:disclaimer2' => "<p>Pour obtenir des services professionnels de traduction et de révision, envoyez une <a href='https://commande.bureaudelatraduction.gc.ca/gctraduction/app/pages/session/login?lang=fr'>demande à cet effet</a>.</p>",
	'mc:LCtool:disclaimer3' => "<p>N’hésitez pas à nous faire parvenir vos <a href='https://outilcl-lctool.spac-pspc.gc.ca/suggestions-fra.php'>commentaires</a> sur l’Outil de compréhension linguistique.</p>",
	'mc:LCtool:button' => 'Process', //replaces "translate" button text. Function: sends text to LC tool service from translation
	'mc:button:cancel' => 'Cancel', //closes window
	'mc:button:ok' => 'Replace', // button places translated text into dom. Replaces original text for the viewer
	'mc:LCtool:originalText' => 'Original Text:', //header above text box comtaining original text
	'mc:LCtool:wait' => 'Please wait...', //replaces 'mc:LCtool:originalText' while loading spinner is active
	'mc:LCtool:translated' => 'Translated Text:', // replaces 'mc:LCtool:wait' once translation has been recived from service and displayed for user.
);

add_translation('fr', $french);
