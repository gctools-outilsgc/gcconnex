<?php
/**
 * Elgg title element
 *
 * @uses $vars['title'] The page title
 * @uses $vars['class'] Optional class for heading
 */

$class= '';
if (isset($vars['class'])) {
	$class = " class=\"{$vars['class']}\"";
}

echo "<h1{$class}>{$vars['title']}</h1></br>";

if (strpos($vars['title'], "events")!==false||strpos($vars['title'], "Tous les événement")!==false||strpos($vars['title'], "Calendriers ")!==false||
strpos($vars['title'], "calendrier")!==false||
strpos($vars['title'], "Group calendar")!==false||
strpos($vars['title'], "My calendar")!==false||
strpos($vars['title'], "Friends' calendar")!==false||
strpos($vars['title'], "Agenda de groupe")!==false)
	echo "</br></br></br></br></br></br></br></br></br></br></br></br></br>";
else{
for ($i=0;$i<strlen($vars['title']);$i+=50){
	echo "</br>";
}
}
