<?php

if (!HYPEFRAMEWORK_INTERFACE_AJAX) {
	return true;
}

elgg_register_viewtype_fallback('xhr');
