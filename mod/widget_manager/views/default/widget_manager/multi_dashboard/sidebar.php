<?php

	elgg_load_js("lightbox");
	elgg_load_css("lightbox");
	
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#widget-manager-multi_dashboard-extras').fancybox({
			"autoDimensions" : false,
			"width": 400,
			"height": 200,
			"titleShow" : false,
			"href": $('#widget-manager-multi_dashboard-extras').attr("href") + "&title=" + escape(document.title)
		});
	});
</script>