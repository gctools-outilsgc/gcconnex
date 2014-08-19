<?php

	if(!empty($vars["entity"])){
?>
<script type="text/javascript">
	
	$("#group_tools_group_edit_tabbed li").click(function(){
		// remove selected class
		$(this).siblings().removeClass("elgg-state-selected");
		$(this).addClass("elgg-state-selected");
		
		var link = $(this).children("a").attr("href");

		if(link == "#other"){
			$("#group_tools_group_edit_tabbed").nextAll("form").hide();
			$("#group_tools_group_edit_tabbed").nextAll("div").show();
		} else {
			$("#group_tools_group_edit_tabbed").nextAll("div").hide();
			$("#group_tools_group_edit_tabbed").nextAll("form").show();
		}
		
	});

	$("#group_tools_group_edit_tabbed li:first").click();

</script>
<?php } 