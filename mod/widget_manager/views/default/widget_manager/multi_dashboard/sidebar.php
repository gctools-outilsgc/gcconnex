<?php

elgg_load_js("lightbox");
elgg_load_css("lightbox");
	
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#widget-manager-multi_dashboard-extras').colorbox({
			"innerWidth": 400,
			"href": $('#widget-manager-multi_dashboard-extras').attr("href") + "&title=" + escape(document.title)
		});
	});
</script>