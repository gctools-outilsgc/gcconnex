<?php

if (plugin_loader_export_config() !== false) {
  system_message(elgg_echo('plugin_loader:exported_success'));
} else {
  system_message(elgg_echo('plugin_loader:exported_failed'));
}