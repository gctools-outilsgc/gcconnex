<?php
	$widget = $vars["entity"];
	
	$blog_tags = '<a><p><br><b><i><em><del><pre><strong><ul><ol><li>';
	$feed_url = $widget->rssfeed;
	
	if(!empty($feed_url)){
		if($widget->excerpt == "yes"){
			$excerpt = true;
		} else {
			$exerpt = false;
		}
		
		if($widget->show_item_icon == "yes"){
			$show_item_icon = true;
		} else {
			$show_item_icon = false;
		}
		
		$rss_count = sanitise_int($widget->rss_count, false);
		if(empty($rss_count)){
			$rss_count = 4;
		}
		
		if($widget->post_date == "yes" || $widget->post_date == "friendly"){
			$post_date = "friendly";
		} elseif($widget->post_date == "date") {
			$post_date = "date";
		} else {
			$post_date = false;
		}
		
		elgg_load_library("simplepie");
		
		$feed = new SimplePie($feed_url, WIDGETS_RSS_CACHE_LOCATION, WIDGETS_RSS_CACHE_DURATION);
		
		$num_posts_in_feed = $feed->get_item_quantity($rss_count);
		
		if(($feed_title = $feed->get_title()) && ($widget->show_feed_title == "yes")){
			echo "<h3><a href='" . $feed->get_permalink() . "' target='_blank'>" .$feed_title . "</a></h3>";
		}
		
		$body = "";
		
		if (empty($num_posts_in_feed)){
			$body = elgg_echo('notfound');
		} else {
			foreach ($feed->get_items(0, $num_posts_in_feed) as $item){
				if ($excerpt){
					$body .= "<div class='widgets_rss_feed_item'>";
					$body .= "<div><a href='" . $item->get_permalink() . "' target='_blank'>" . $item->get_title() . "</a></div>";
					
					if($show_item_icon){
						if($enclosures = $item->get_enclosures()){
							foreach($enclosures as $enclosure){
								if(substr($enclosure->type,0,6) == "image/"){
									$body .= "<a href='" . $item->get_permalink() . "' target='_blank'><img class='widgets_rss_feed_item_image' src='" . $enclosure->link . "' /></a>";
									break;			
								}
							}
						}
					}
					
					$body .= strip_tags($item->get_description(true), $blog_tags);
					if ($post_date == "friendly"){
						$body .= "<div class='widgets_rss_feed_timestamp'>" . elgg_view_friendly_time($item->get_date('U')) . "</div>";
					} elseif ($post_date == "date"){
						$body .= "<div class='widgets_rss_feed_timestamp' title='" . $item->get_date('r') . "'>" . substr($item->get_date('r'),0,16) . "</div>";
					}
					
					$body .= "</div>";	
				} else {
					$body .= "<div>";
					if ($post_date == "friendly"){
						$body .= "<span>" . elgg_view_friendly_time($item->get_date('U')) . "</span> - ";
					} elseif ($post_date == "date"){
						$body .= "<span title='" . $item->get_date('r') . "'>" . substr($item->get_date('r'),0,16) . "</span> - ";
						
					}
					$body .= "<a href='" . $item->get_permalink() . "' target='_blank'>" . $item->get_title() . "</a>";
					$body .= "</div>";
				}
				$body .= "<div class='clearfix'></div>";
			}
		}
		
		echo $body;      
	} else {
		echo elgg_echo('widgets:rss:error:notset');      
	}
