elgg.provide('elgg.group_tools');

elgg.group_tools.init_members_search = function() {
	require(['elgg/spinner']);
	
	$('.elgg-form-group-tools-members-search').submit(function(event) {
		var $form = $(this);
		
		require(['elgg/spinner'], function(spinner) {
			spinner.start();
			
			elgg.get($form.attr('action'), {
				data: $form.serialize(),
				complete: spinner.stop,
				success: function(html) {
					$form.parent().find('> .elgg-list, > .elgg-pagination').remove();
					$form.parent().append(html);
				}
			});
			
		});
		
		event.preventDefault();
	});
	
	$('.elgg-form-group-tools-members-search').parent().on('click', '.elgg-pagination a', function(event) {
		var $elem = $(this);
		
		require(['elgg/spinner'], function(spinner) {
			spinner.start();
			elgg.get($elem.attr('href'), {
				complete: spinner.stop,
				success: function(html) {
					var $parents = $elem.parents('.elgg-main');
					$parents.find('> .elgg-list, > .elgg-pagination').remove();
					$parents.append(html);
					$('html, body').animate({
						scrollTop: $parents.find('> .elgg-head').offset().top
					}, 500);
				}
			});
			
		});
		
		event.preventDefault();
	});
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.group_tools.init_members_search);
