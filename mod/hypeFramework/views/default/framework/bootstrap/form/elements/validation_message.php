<?php

$msg = elgg_extract('msg', $vars, '');

if (!empty($msg)) {
	echo '<span class="elgg-input-validation-message">' . $msg . '</span>';
}