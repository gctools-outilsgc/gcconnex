<?php
/*
 * pass.php
 *
 * Grabbing owner entity for Metadata
 *
 * @package wet4
 * @author
 */
    //for extending and grabbing user entity from profile
$user = elgg_get_page_owner_entity();

echo elgg_view('wet4_theme/track_page_entity', array('entity' => $user));
    ?>
