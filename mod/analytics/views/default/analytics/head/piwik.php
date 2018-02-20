<?php

// Piwik tracking
$piwik_url = elgg_get_plugin_setting('piwik_url', 'analytics');
$piwik_site_id = (int) elgg_get_plugin_setting('piwik_site_id', 'analytics');
$piwik_guid = elgg_get_plugin_setting('piwik_guid', 'analytics');
if (empty($piwik_url) || empty($piwik_site_id)) {
	return;
}

// validate piwik url
if (((stripos($piwik_url, 'https://') !== 0) && (stripos($piwik_url, 'http://') !== 0)) || (substr($piwik_url, -1, 1) !== '/')) {
	return;
}

?>
<!-- Piwik -->
<script type='text/javascript'>
	var _paq = _paq || [];

	(function() {
		var u = '<?php echo $piwik_url; ?>';
		_paq.push(['setSiteId', <?php echo $piwik_site_id; ?>]);
		_paq.push(['setTrackerUrl', u + 'piwik.php']);
<?php if ($piwik_guid): ?>
		_paq.push(['setCustomVariable', 1, 'guid', elgg.get_logged_in_user_guid(), 'visit']);
<?php endif; ?>
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);

		var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
		g.type = 'text/javascript';
		g.defer = true;
		g.async = true;
		g.src = u + 'piwik.js';
		s.parentNode.insertBefore(g,s);
	})();
</script>
<!-- End Piwik Code -->
