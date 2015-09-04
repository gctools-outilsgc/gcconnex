<?php
/**
 * prefix to make the group edit tabbed
 */
?>
<script type="text/javascript">
	
	$("#group-tools-group-edit-tabbed li").click(function() {
		// remove selected class
		$(this).siblings().removeClass("elgg-state-selected");
		$(this).addClass("elgg-state-selected");
		
		// hide everything
		$("#group-tools-group-edit-tabbed").nextAll("form").hide();
		$("#group-tools-group-edit-profile").hide();
		$("#group-tools-group-edit-access").hide();
		$("#group-tools-group-edit-tools").hide();
		$("#group-tools-group-edit-tabbed").nextAll("div").hide();
		
		var link = $(this).children("a").attr("href");
		switch (link) {
			case "#group-tools-group-edit-profile":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-profile").show();
				
				break;
			case "#group-tools-group-edit-access":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-access").show();
				
				break;
			case "#group-tools-group-edit-tools":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-tools").show();
				
				break;
			default:
				$("#group-tools-group-edit-tabbed").nextAll("div").show();
				break;
		}

		return false;
	});

	$("#group-tools-group-edit-tabbed li:first").click();

</script>
