<?php
$diagnostics = elgg_extract('diagnostics', $vars, array());
?>

<table class="elgg-table-alt">
	<thead>
		<tr>
			<th><?php echo elgg_echo('hybridauth:admin:diagnostics:requirement') ?></th>
			<th><?php echo elgg_echo('hybridauth:admin:diagnostics:status') ?></th>
			<th><?php echo elgg_echo('hybridauth:admin:diagnostics:message') ?></th>
		</tr>
	</thead>
	<?php
	foreach ($diagnostics as $requirement => $status) {
		$class = ($status) ? 'hybridauth-diagnostics-pass' : 'hybridauth-diagnostics-fail';
		$icon = ($status) ? 'PASS' : 'FAIL';
		$msg = ($status) ? elgg_echo("hybridauth:admin:diagnostics:$requirement:pass") : elgg_echo("hybridauth:admin:diagnostics:$requirement:fail");
		echo '<tr>';
		echo '<td>' . elgg_echo("hybridauth:admin:diagnostics:$requirement") . '</td>';
		echo "<td class=\"$class\">$icon</td>";
		echo "<td class=\"$class\">$msg</td>";
		echo '</tr>';
	}
	?>
	<tbody>

	</tbody>
</table>