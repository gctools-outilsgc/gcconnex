<?php

if (elgg_is_logged_in()) {
	echo elgg_view_form("thewire/add");
} else {
	echo elgg_echo("thewire_tools:login_required");
}
