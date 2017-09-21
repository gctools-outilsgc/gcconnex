<?php
/**
 * Log browser table
 *
 * @package ElggLogBrowser
 */

require_once elgg_get_root_path() . 'mod/apiadmin/lib/phpbrowscap/BrowsCap.php';

// The Browscap class is in the phpbrowscap namespace, so import it
use phpbrowscap\Browscap;

// Create a new Browscap object (loads or creates the cache)
try {
    $bc = new Browscap(elgg_get_data_path() . 'phpbrowscap');
} catch (\phpbrowscap\Exception $e) {
    $bc = null;
}

$log_entries = $vars['log_entries'];
?>

<table class="elgg-table">
	<tr>
		<th width="25%"><?php echo elgg_echo('apiadmin:record:date'); ?></th>
		<th width="13%"><?php echo elgg_echo('apiadmin:record:ip_address'); ?></th>
		<th width="8%"><?php echo elgg_echo('apiadmin:record:request'); ?></th>
		<th width="15%"><?php echo elgg_echo('apiadmin:record:method'); ?></th>
		<th width="19%"><?php echo elgg_echo('apiadmin:record:key'); ?></th>
		<th width="20%"><?php echo elgg_echo('apiadmin:record:user_agent'); ?></th>
	</tr>
<?php
	$alt = '';
	foreach ($log_entries as $entry) {
		if ($entry->remote_address) {
			$ip_address = $entry->remote_address;
		} else {
			$ip_address = '&nbsp;';
		}

		$user = get_entity($entry->performed_by_guid);
		if ($user) {
			$user_link = elgg_view('output/url', array(
				'href' => $user->getURL(),
				'text' => $user->name,
				'is_trusted' => true,
			));
			$user_guid_link = elgg_view('output/url', array(
				'href' => "admin/overview/logbrowser?user_guid=$user->guid",
				'text' => $user->getGUID(),
				'is_trusted' => true,
			));
		} else {
			$user_guid_link = $user_link = '&nbsp;';
		}

		$object = get_object_from_log_entry($entry->id);
		if (is_callable(array($object, 'getURL'))) {
			$object_link = elgg_view('output/url', array(
				'href' => $object->getURL(),
				'text' => $entry->object_class,
				'is_trusted' => true,
			));
		} else {
			$object_link = $entry->object_class;
		}
?>
	<tr <?php echo $alt; ?>>
		<td class="apiadmin-log-entry-time">
			<?php echo date('r', $entry->time_created); ?>
		</td>
		<td class="apiadmin-log-entry-ip-address">
			<?php echo $ip_address; ?>
		</td>
		<td class="apiadmin-log-entry-request">
			<?php echo $entry->request; ?>
		</td>
		<td class="apiadmin-entry-method">
			<?php echo $entry->method; ?>
		</td>
		<td class="apiadmin-entry-api-key">
			<?php echo $entry->api_key; ?>
		</td>
		<td class="apiadmin-entry-user-agent">
            <?php
            if ( $bc ) {
                $browser = $bc->getBrowser($entry->user_agent, true);
                echo "$browser[Parent] ($browser[Platform])";
            } else {
                echo substr($entry->user_agent, 0, 32);
            }
            ?>
		</td>
	</tr>
<?php

		$alt = $alt ? '' : 'class="alt"';
	}
?>
</table>
<?php
if (!$log_entries) {
	echo elgg_echo('apiadmin:no_result');
	return true;
}
