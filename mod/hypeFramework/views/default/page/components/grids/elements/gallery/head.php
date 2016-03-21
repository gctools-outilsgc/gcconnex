<?php

if (isset($vars['list_options']['filter'])) {
	echo '<div class="hj-framework-list-filter">';
	echo $vars['list_options']['filter'];
	echo '</div>';
}