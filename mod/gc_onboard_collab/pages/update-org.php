<?php
/**
 * Page for displaying organisational form
 * 
 * Nick - piet0024
 */

gatekeeper();
// TODO: MAKE A NEW FORM THAT RUNS THE EDIT ACTION
$org_form = elgg_view('update-org/update_form');

echo elgg_view_page(elgg_echo('updateorg:title'), $org_form);