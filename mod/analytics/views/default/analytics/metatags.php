<?php 

	$trackID = elgg_get_plugin_setting('analyticsSiteID', 'analytics');
	$domain = elgg_get_plugin_setting('analyticsDomain', 'analytics');
	$trackActions = elgg_get_plugin_setting("trackActions", "analytics");
	$trackEvents = elgg_get_plugin_setting("trackEvents", "analytics");
	$flagAdmins = elgg_get_plugin_setting("flagAdmins", "analytics");
	
	if(!empty($trackID)){
?>
<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $trackID; ?>']);
	<?php if(!empty($domain)) { ?>
	_gaq.push(['_setDomainName', '<?php echo $domain; ?>']);
	<?php } ?>
	<?php if(elgg_is_admin_logged_in() && $flagAdmins == "yes"){ ?>
	_gaq.push(['_setCustomVar', 1, 'role', 'admin', 1]);
	<?php } ?>
	_gaq.push(['_trackPageview']);

	<?php 
	if($trackActions == "yes") { 
		if(!empty($_SESSION["analytics"]["actions"])){
			foreach($_SESSION["analytics"]["actions"] as $action => $result){
				if($result){
					echo "_gaq.push(['_trackPageview', '/action/" . $action . "/succes']);\n";
				} else {
					echo "_gaq.push(['_trackPageview', '/action/" . $action . "/error']);\n";
				}
			}
			
			$_SESSION["analytics"]["actions"] = array();
		}
	}
	
	if($trackEvents == "yes"){
		if(!empty($_SESSION["analytics"]["events"])){
			
			foreach($_SESSION["analytics"]["events"] as $event){
				$output = "_gaq.push(['_trackEvent', '" . $event["category"] . "', '" . $event["action"] . "'";
				
				if(array_key_exists("label", $event) && !empty($event["label"])){
					$output .= ", '" . str_replace("'", "", $event["label"]) . "'";
				}
				
				$output .= "]);\n";
				echo $output;
			}
			
			$_SESSION["analytics"]["events"] = array();
		}
	}
	?>
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
<?php } ?>