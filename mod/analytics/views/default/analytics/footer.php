<?php 

?>
<script type="text/javascript" id="analytics_ajax_result">

	$('#analytics_ajax_result').ajaxSuccess(function(event, XMLHttpRequest, ajaxOptions){
		if(ajaxOptions.url != "<?php echo $vars["url"]; ?>analytics/ajax_success"){
			
			$.get("<?php echo $vars["url"]; ?>analytics/ajax_success", function(data){
				if(data){
					var temp = document.createElement("script");
					temp.setAttribute("type", "text/javascript");
					temp.innerHTML = data;
					
					$('#analytics_ajax_result').after(temp);
				}
			});
		}
	});

</script>