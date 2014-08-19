<?php

echo elgg_view_form('sphinx/configure');

echo "<pre>" . file_get_contents(elgg_get_data_path() . 'sphinx/sphinx.conf') . "</pre>";
