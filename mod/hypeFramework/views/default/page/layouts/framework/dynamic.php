<?php

$content = elgg_extract('content', $vars, false);
$grid = elgg_extract('grid', $vars, array());

if (!$content) {
    return true;
}

$num_columns = sizeof($content);

if (!$grid) {
    $equal = 12 / $num_columns;
    foreach ($content as $column_content) {
        $page .= "<div class=\"span$equal clearfix\">$column_content</div>";
    }
} else {
    foreach ($content as $column => $column_content) {
        $page .= "<div class=\"span$grid[$column] clearfix\">$column_content</div>";
    }
}
    
$page = <<<HTML
    <div class="row-fluid">
        $page
    </div>
HTML;

echo $page;
