<?php
/**
 * Elgg API Admin
 * Implementation of a view for the "API Key" object type.
 * July 2012 : added javascript confirmation for revoke operation and added regeneration and rename operations
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd and Moodsdesign Ltd
 * @copyright Curverider Ltd 2011 and Moodsdesign Ltd 2012
 * @link http://www.elgg.org
*/

global $CONFIG;

$entity = $vars['entity'];
$ts = time();
$token = generate_action_token($ts);

?>
<script>
	elgg.apiadmin_revoke<?php echo $entity->guid; ?> = function() {
		if ( confirm(elgg.echo('apiadmin:revoke_prompt')) ) {
			document.location.href = '<?php echo "{$CONFIG->url}action/apiadmin/revokekey?keyid={$entity->guid}&__elgg_token=$token&__elgg_ts=$ts" ?>';
		}
	};
	elgg.apiadmin_rename<?php echo $entity->guid; ?> = function() {
		var newRef = prompt(elgg.echo('apiadmin:rename_prompt'), '<?php echo $entity->title; ?>');
		if ( newRef ) {
			var url = '<?php echo "{$CONFIG->url}action/apiadmin/renamekey?keyid={$entity->guid}&__elgg_token=$token&__elgg_ts=$ts" ?>';
			document.location.href = url + '&newref=' + encodeURIComponent(newRef);
		}
	};
	elgg.apiadmin_regen<?php echo $entity->guid; ?> = function() {
		if ( confirm(elgg.echo('apiadmin:regenerate_prompt')) ) {
			document.location.href = '<?php echo "{$CONFIG->url}action/apiadmin/regenerate?keyid={$entity->guid}&__elgg_token=$token&__elgg_ts=$ts" ?>';
		}
	};
</script>
<?php
$icon = elgg_view(
	'graphics/icon', array(
		'entity' => $entity,
		'size' => 'small',
	)
);

$public_label = elgg_echo('apiadmin:public');
$private_label = elgg_echo('apiadmin:private');
$revoke_label = elgg_echo('apiadmin:revoke');
$rename_label = elgg_echo('apiadmin:rename');
$regenerate_label = elgg_echo('apiadmin:regenerate');

$info  = "<div class=\"contentWrapper\">";
$info .= "<p><b>{$entity->title}</b>";
$info .= " &nbsp; [<a href=\"#\" onclick=\"elgg.apiadmin_revoke{$entity->guid}();\">$revoke_label</a>]";
$info .= " &nbsp; [<a href=\"#\" onclick=\"elgg.apiadmin_rename{$entity->guid}();\">$rename_label</a>]";
$info .= " &nbsp; [<a href=\"#\" onclick=\"elgg.apiadmin_regen{$entity->guid}();\">$regenerate_label</a>]";
$info .= "</p></div>";
$info .= "<div><p><b>$public_label:</b> {$entity->public}<br />";

// Only show secret portion to admins
if ( elgg_is_admin_logged_in() ) {
	// Fetch key
	$keypair = get_api_user($CONFIG->site_id, $entity->public);

	$info .= "<b>$private_label:</b> {$keypair->secret}"; 
}
$info .= "</p></div>";

echo elgg_view_image_block($icon, $info);
