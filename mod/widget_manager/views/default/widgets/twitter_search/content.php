<?php 

	$widget = $vars["entity"];
	
	$query = $widget->query;
	$title = addslashes($widget->tw_title);
	$sub = addslashes($widget->tw_subtitle);
	
	$height = sanitise_int($widget->height, false);
	if(empty($height)){
		$height = 300;
	}
	
	$background = $widget->background;
	if(empty($background)){
		$background = "4690d6";
	}
	
	if(!empty($query)){

		// Load Twitter JS
		if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on"){
			// load normal js
			$twitter_script_src = "http://widgets.twimg.com/j/2/widget.js";
		} else {
			// load secure js
			$twitter_script_src = "https://twitter-widgets.s3.amazonaws.com/j/2/widget.js";
		}
		
		?>
		<div id="twittersearch_<?php echo $widget->getGUID(); ?>"></div>
		
		<script type="text/javascript">
			$.getScript("<?php echo $twitter_script_src; ?>", function(){
				new TWTR.Widget({
					  version: 2,
					  id: "twittersearch_<?php echo $widget->getGUID(); ?>",
					  type: "search",
					  search: "<?php echo $query; ?>",
					  interval: 10000,
					  title: "<?php echo $title; ?>",
					  subject: "<?php echo $sub; ?>",
					  width: "auto",
					  height: <?php echo $height; ?>,
					  theme: {
					    shell: {
					      background: '#<?php echo $background; ?>',
					      color: '#ffffff'
					    },
					    tweets: {
					      background: '#ffffff',
					      color: '#333333',
					      links: '#4690d6'
					    }
					  },
					  features: {
					    scrollbar: true,
					    loop: false,
					    live: true,
					    hashtags: true,
					    timestamp: true,
					    avatars: true,
					    toptweets: true,
					    behavior: "all"
					  }
					}).render().start();
			});
		</script>
<?php 
	} else { 
		echo elgg_echo("widgets:twitter_search:not_configured");
	} 
