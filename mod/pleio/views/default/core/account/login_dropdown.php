<?php
/**
 * Elgg drop-down login form
 */

if (elgg_is_logged_in()) {
    return true;
}
?>

<div id="login-dropdown">
    <?php echo elgg_view_form("login"); ?>
</div>