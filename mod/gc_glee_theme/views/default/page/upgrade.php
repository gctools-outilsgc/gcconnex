<?php
/**
 * Page shell for upgrade script
 *
 * Displays an ajax loader until upgrade is complete
 */
?>
<html>
	<head>
		<?php echo elgg_view('page/elements/head', $vars); ?>
		<meta http-equiv="refresh" content="1;url=<?php echo elgg_get_site_url(); ?>upgrade.php?upgrade=upgrade"/>
	</head>
	<body>
		<div style="width:400px; margin: 200px auto;">
			<div class="progress progress-info progress-striped active">
				<div class="bar" style="width: 100%;" />
			</div>
		</div>
	</body>
</html>