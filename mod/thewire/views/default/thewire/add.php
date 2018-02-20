<?php
/**
 * Ajax wrapper view to show a wire add form
 */

elgg_push_context("thewire");

echo elgg_view_form("thewire/add");

elgg_pop_context();