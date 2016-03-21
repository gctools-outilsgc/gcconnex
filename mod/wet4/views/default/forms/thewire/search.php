<?php

echo '<label for="q">' . elgg_echo('search') . ':</label>';
echo '<ul class="list-inline">';
echo '<li>' . elgg_view("input/text", array("name" => "q", "id" => "q", "value" => $vars["query"])) . '</li>';
echo '<li>' . elgg_view("input/submit", array("value" => elgg_echo("search"), 'class' => 'btn btn-primary' )) . '</li>';
echo '</ul>';