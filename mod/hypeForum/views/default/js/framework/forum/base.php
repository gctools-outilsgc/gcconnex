<?php if (FALSE) : ?>
	<script type="text/javascript">
<?php endif; ?>

elgg.provide('framework');
elgg.provide('framework.forum');

framework.forum.init = function() {

	$(".forum-category-list").sortable({
		items:                'li.elgg-item:has(div.hj-draggable-element)',
		connectWith:          '.forum-category-list',
		handle:               '.hj-draggable-element-handle',
		forcePlaceholderSize: true,
		placeholder:          'hj-draggable-element-placeholder',
		opacity:              0.8,
		revert:               500,
		stop:                 framework.forum.orderCategories
	});

	$('.elgg-button-forum-subscription')
	.live('click', function(e) {
		e.preventDefault();
		$element = $(this);
		elgg.action($(this).attr('href'), {
			success : function(response) {
				if (response.status >= 0) {
					if ($element.text() == elgg.echo('hj:forum:subscription:remove')) {
						$element.text(elgg.echo('hj:forum:subscription:create'));
						$element.removeClass('elgg-state-active');
					} else {
						$element.text(elgg.echo('hj:forum:subscription:remove'));
						$element.addClass('elgg-state-active');
					}
				}
			}
		})
	})

	$('.elgg-button-forum-bookmark')
	.live('click', function(e) {
		e.preventDefault();
		$element = $(this);
		elgg.action($(this).attr('href'), {
			success : function(response) {
				if (response.status >= 0) {
					if ($element.text() == elgg.echo('hj:forum:bookmark:remove')) {
						$element.text(elgg.echo('hj:forum:bookmark:create'));
						$element.removeClass('elgg-state-active');
					} else {
						$element.text(elgg.echo('hj:forum:bookmark:remove'));
						$element.addClass('elgg-state-active');
					}
				}
			}
		})
	})
		
}

framework.forum.orderCategories = function(event, ui) {

	var data = ui.item
	.closest('.forum-category-list')
	.sortable('serialize');

	elgg.action('action/forum/order/categories?' + data);

	// @hack fixes jquery-ui/opera bug where draggable elements jump
	ui.item.css('top', 0);
	ui.item.css('left', 0);
};

framework.forum.appendNewCategory = function(name, type, params, value) {

	$('.forum-category-list')
	.append($(params.response.output.view));

	window.location.hash = 'elgg-object-' + params.response.output.guid;
	return value;
		
}

framework.forum.replaceCategory = function(name, type, params, value) {

	$('.forum-category-list')
	.find('#elgg-object-' + params.response.output.guid)
	.each(function() {
		$(this).replaceWith($(params.response.output.view));
	})
	window.location.hash = 'elgg-object-' + params.response.output.guid;
	return value;

}

elgg.register_hook_handler('init', 'system', framework.forum.init);

elgg.register_hook_handler('newcategory', 'framework:forum', framework.forum.appendNewCategory);
elgg.register_hook_handler('editedcategory', 'framework:forum', framework.forum.replaceCategory);

<?php if (FALSE) : ?></script><?php
endif;
?>
