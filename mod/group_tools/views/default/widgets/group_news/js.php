<?php ?>
//<script>

elgg.provide("elgg.widgets.group_news");

elgg.widgets.group_news.init = function(){
	$(".widget_group_news_navigator > span:first").each(function(index, elem){
		elgg.widgets.group_news.rotate_content(elem);
	});
	
	$(".widget_group_news_navigator > span").live("click", function(){
		elgg.widgets.group_news.rotate_content(this);
	});

	// rotate every 10 seconds
	setInterval (elgg.widgets.group_news.rotate, 10 * 1000);
};

elgg.widgets.group_news.rotate = function(){
	$(".widget_group_news_navigator").each(function(index, elem){
		
		if($(this).find(".active").next().length === 0){
			elgg.widgets.group_news.rotate_content($(this).find("> span:first"));
		} else {
			elgg.widgets.group_news.rotate_content($(this).find(".active").next());
		}
	});
}

elgg.widgets.group_news.rotate_content = function(elem){
	$(elem).parent().find("span.active").removeClass("active");
	$(elem).addClass("active");

	$(elem).parent().prev().find("> div").hide();
	var active = $(elem).attr("rel");
	$(elem).parent().parent().find("." + active).show();
}

elgg.register_hook_handler('init', 'system', elgg.widgets.group_news.init);