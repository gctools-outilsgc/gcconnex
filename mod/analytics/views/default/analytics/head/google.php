<?php

// Google Analytics tracking
$trackID = elgg_get_plugin_setting('analyticsSiteID', 'analytics');
if (empty($trackID)) {
	return;
}

$domain = elgg_get_plugin_setting('analyticsDomain', 'analytics');
$flagAdmins = elgg_get_plugin_setting('flagAdmins', 'analytics');
$anonymizelp = elgg_get_plugin_setting('anonymizeIp', 'analytics');

if (empty($domain)) {
	$domain = 'auto';
}

?>
<!-- Google Analytics -->
<script type='text/javascript'>

	(function(i,s,o,g,r,a,m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function() {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
		m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a,m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
	
	ga('create', '<?php echo $trackID; ?>', {
		cookieDomain: '<?php echo $domain; ?>'
	});
	<?php if (elgg_is_admin_logged_in() && $flagAdmins === 'yes') { ?>
	ga('set', 'dimension1', 'admin');
	<?php } ?>
	<?php if ($anonymizelp === 'yes') { ?>
	ga('set', 'anonymizeIp', true);
	<?php } ?>
	ga('send', 'pageview');

	<?php
	echo analytics_google_get_tracked_actions();
	echo analytics_google_get_tracked_events();
	?>
</script>
<!-- End Google Analytics -->
