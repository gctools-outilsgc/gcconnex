<?php

$entity = $vars['entity'];

if (!$entity || !$entity->icontime) {
	return;
}

echo '<div class="hj-framework-cover-image" style="background-image:url(' . $entity->getIconURL('master') . ')"></div>';