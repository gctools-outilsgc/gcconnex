<?php
/**
 * Elgg 1.12.9 upgrade 2017022000
 * title_fulltext_index
 *
 * Create a single column fulltext index on the objects_entity table to support
 * text based search queries.
 */

$prefix = elgg_get_config('dbprefix');
$q = "alter table elggobjects_entity add fulltext fulltext_title(title);";
$r = mysql_query($q);
