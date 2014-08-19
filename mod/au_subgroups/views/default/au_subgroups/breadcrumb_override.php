<?php

$breadcrumb = get_input('au_subgroups_breadcrumbs', array());

if (count($breadcrumb)) {
  // replace breadcrumbs
  elgg_set_config('breadcrumbs', $breadcrumb);
}
