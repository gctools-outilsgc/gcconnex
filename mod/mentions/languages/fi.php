<?php
/**
 * Finnish translations
 */

$finnish = array(
	'mentions:notification:subject' => '%s mainitsi sinut kohteessa %s!',
	'mentions:notification:body' => '%s mainitsi sinut kohteessa %s.

Voit lukea viestin tästä linkistä:
%s
',
	'mentions:notification_types:object:blog' => 'blogi',
	'mentions:notification_types:object:bookmarks' => 'kirjanmerkki',
	'mentions:notification_types:object:groupforumtopic' => 'ryhmän keskustelufoorumi,',
	'mentions:notification_types:annotation:group_topic_post' => 'vastaus ryhmän keskustelussa',
	'mentions:notification_types:object:thewire' => 'tilapäivitys',
	'mentions:notification_types:annotation:generic_comment' => 'kommentti',
	'mentions:settings:send_notification' => 'Ilmoita, kun joku mainitsee sinut nimeltä (@tunnus)?',

	// admin
	'mentions:fancy_links' => 'Korvaa @tunnus-maininnat käyttäjän kuvalla ja nimellä',

	'mentions:settings:failed' => 'Asetusten tallentaminen epäonnistui.'
);

add_translation("fi", $finnish);