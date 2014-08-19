<?php

?>
<script type="text/javascript">
$(document).ready(function() {
	elgg.require('phloor');

	var loadcss = phloor.load_css_file(elgg.get_site_url() + "mod/phloor/vendors/prettycheckboxes/prettycheckboxes.css");
	//var loadcss = phloor.load_css_file(elgg.get_site_url() + "mod/phloor/vendors/prettycheckboxes/prettycheckboxes.noimg.css");

	/* see if anything is previously checked and reflect that in the view*/
	$(".checklist input.elgg-input-checkbox:checked").parent().addClass("selected");

	/* handle the user selections */
	$(".checklist a.checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected");
			$(this).parent().find(":checkbox").attr("checked","checked");
		}
	);

	$(".checklist a.checkbox-deselect").click(
		function(event) {
			event.preventDefault();
			$(this).parent().removeClass("selected");
			$(this).parent().find(":checkbox").removeAttr("checked");
		}
	);

});
</script>