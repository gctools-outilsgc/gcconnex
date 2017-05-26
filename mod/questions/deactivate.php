<?php
/**
 * This file is executed when the plugin is enabled
 */

// restore class handlers to default
update_subtype('object', 'question');
update_subtype('object', 'answer');
