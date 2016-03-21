define(['jquery', 'elgg'], function ($, elgg) {
	
	return function(selector, feed_url) {
		var $wrapper = $(selector);
		var wrapper_id = $wrapper.attr("id");
		$wrapper.empty();
		
		var config = $wrapper.data();
		
		var feed_url = config.feedUrl;
		var limit = config.limit;

		$.getJSON(
			"//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=" + limit + "&output=json_xml&q=" + encodeURIComponent(feed_url) + "&hl=en&callback=?",
			function (data) {
				if (data.responseData) {
					var xmlDoc = $.parseXML(data.responseData.xmlString);
					var feed = data.responseData.feed;
					
					var $items = $(xmlDoc).find("item");
					
					var s = "";
					
					if (config.showFeedTitle) {
						s += "<h3><a href='" + feed.link + "' target='_blank'>" + feed.title + "</a></h3>";
					}
					
					s += "<ul class='widget-manager-rss-result elgg-list'>";
					$.each(feed.entries, function (index, item) {
						s += "<li class='clearfix elgg-item'>";
						var description = item.content.replace(/(<([^>]+)>)/ig,"");
						if (config.showExcerpt) {
							s += "<div class='pbm'>";
							s += "<div><a href='" + item.link + "' target='_blank'";
							if (config.showInLightbox) {
								var popup_id = wrapper_id + "-" + index;
								
								var popup_content = "<div class='hidden'><div id='" + popup_id + "' class='elgg-module elgg-module-info elgg-module-rss-popup'>";
								popup_content += "<div class='elgg-head'><h3>" + item.title + "</h3></div>";
								popup_content += "<div class='elgg-body'>" + description + "</div>";
								popup_content += "</div></div>";
								
								popup_content = popup_content.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2');
								$("body").append(popup_content);

								s += " class='elgg-lightbox' data-colorbox-opts='{ \"inline\": true, \"href\": \"#" + popup_id + "\", \"innerWidth\": 600 }'";
							}
							
							s += ">" + item.title + "</a></div>";
							s += "<div class='elgg-content'>";
							if (config.showItemIcon) {
								var xml_item = $items[index];
								
								var enclosure = $(xml_item).find("enclosure");
								var enclosure_url = enclosure.attr("url");
								var enclosure_type = enclosure.attr("type");
							
								s += "<a href='" + item.link + "' target='_blank'><img class='widgets_rss_feed_item_image' src='" + enclosure_url + "' /></a>";
							}
							
							s += description;
							s += "</div>";
							
							if (config.postDate) {
								var i = new Date(item.publishedDate);
								s += "<div class='elgg-subtext'>" + i.toLocaleDateString() + "</div>";
							}
							
							s += "</div>";
						} else {
							s += "<div class='elgg-image-block'>";

							s += "<a href='" + item.link + "' target='_blank'";
							if (config.showInLightbox) {
								var popup_id = wrapper_id + "-" + index;
								
								var popup_content = "<div class='hidden'><div id='" + popup_id + "' class='elgg-module elgg-module-info elgg-module-rss-popup'>";
								popup_content += "<div class='elgg-head'><h3>" + item.title + "</h3></div>";
								popup_content += "<div class='elgg-body'>" + description + "</div>";
								popup_content += "</div></div>";
								
								popup_content = popup_content.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2');
								$("body").append(popup_content);

								s += " class='elgg-lightbox' data-colorbox-opts='{ \"inline\": true, \"href\": \"#" + popup_id + "\", \"innerWidth\": 600 }'";
							
							}
							
							s += ">" + item.title + "</a>";
							if (config.postDate) {
								var i = new Date(item.publishedDate);
								s += "<div class='elgg-subtext'>" + i.toLocaleDateString() + "</div>";
							}
							s += "</div>";
						}
						
						s += "</li>";
					});
					s += "</ul>";
					
					$wrapper.replaceWith(s);
				} else {
					$wrapper.append(data.responseDetails);
				}
			}
		);
	};
});
