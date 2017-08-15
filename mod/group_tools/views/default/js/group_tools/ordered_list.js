define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');
	require('jquery-ui');
	
	$('.group-tools-list-ordered').sortable({
		update: function () {
			var ordered_ids = [];
			$('.group-tools-list-ordered > li').each(function () {
				var group_id = $(this).attr("id").replace("elgg-group-", "");
				ordered_ids.push(group_id);
			});
			elgg.action("group_tools/order_groups", {
				data: {
					guids: ordered_ids
				}
			});
		}
	});

});