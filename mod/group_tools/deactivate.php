<?php
/**
 * This script is run when the plugin gets deactivated
 */

// undo class handlers for subtype
update_subtype('object', GroupMail::SUBTYPE);
