<?php

if (elgg_in_context('activity') || elgg_in_context('widgets') || elgg_in_context('main')) {
	return true;
}
$entity = elgg_extract('entity', $vars);
echo elgg_view_comments($entity);

