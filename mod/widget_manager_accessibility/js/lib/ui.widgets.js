elgg.provide('elgg.ui.widgets');

/**
 * Widgets initialization
 *
 * @return void
 */
elgg.ui.widgets.init = function() {

	// widget layout?
	if ($(".elgg-widgets").length == 0) {
		return;
	}

	$(".elgg-widgets").sortable({
		items:                'div.elgg-module-widget.elgg-state-draggable',
		connectWith:          '.elgg-widgets',
		handle:               '.elgg-widget-handle',
		forcePlaceholderSize: true,
		placeholder:          'elgg-widget-placeholder',
		opacity:              0.8,
		revert:               500,
		stop:                 elgg.ui.widgets.move
	});

	// the widgets available to be added
	// don't need to change       $('.elgg-widgets-add-panel li.elgg-state-available').click(elgg.ui.widgets.add);
	$('.elgg-widgets-add-panel li.elgg-state-available').children('input.widget-added').attr('disabled', "disabled");		// disable remove widget button

	// the present widgets with remove widget buttons active
    $('.elgg-widgets-add-panel li.elgg-state-unavailable').click(elgg.ui.widgets.removebtn);
    $('.elgg-widgets-add-panel li.elgg-state-unavailable').children('input.widget-to-add').attr('disabled', "disabled");		// disable add widget button

	$('a.elgg-widget-delete-button').live('click', elgg.ui.widgets.toggleremove);
	// don't need to change        $('.elgg-widget-edit > form ').live('submit', elgg.ui.widgets.saveSettings);
	$('a.elgg-widget-collapse-button').live('click', elgg.ui.widgets.collapseToggleA);


    $('.elgg-widget-multiple').each(function() {
        var name = $(this).attr('id');
        name = name.substr(name.indexOf('elgg-widget-type-') + "elgg-widget-type-".length);

        var counter = $(this).closest('.widget_manager_widgets_lightbox_wrapper').find('.multi-widget-count');
        counter.text($('.elgg-widget-instance-' + name).length);
        counter.addClass('multi-widget-count-activated');

    });


    //var name = $('.elgg-widget-multiple').attr('id');

   // name = name.substr(name.indexOf('elgg-widget-type-') + "elgg-widget-type-".length);
    //$('.elgg-widget-multiple').closest('.widget_manager_widgets_lightbox_wrapper').find('.multi-widget-count').text($('.elgg-widget-instance-' + name).length)

	elgg.ui.widgets.setMinHeight(".elgg-widgets");
};

/**
 * Toggle the collapse state of the widget
 *
 * @param {Object} event
 * @return void
 */
elgg.ui.widgets.collapseToggleA = function(event) {
    $(this).toggleClass('elgg-widget-collapsed');
    $(this).parent().parent().find('.elgg-body').slideToggle('medium');
    event.preventDefault();

    if (elgg.is_logged_in()) {
            var collapsed = 0;
            if ($(this).hasClass("elgg-widget-collapsed")) {
                collapsed = 1;
            }

            var guid = $(this).attr("href").replace("#elgg-widget-content-", "");
    
            elgg.action('widget_manager/widgets/toggle_collapse', {
                data:{
                    collapsed: collapsed,
                    guid: guid
                }
            });
        }
};

/**
 * Adds a new widget
 *
 * Makes Ajax call to persist new widget and inserts the widget html
 *
 * @param {Object} event
 * @return void
 */
elgg.ui.widgets.add = function(event) {
	// elgg-widget-type-<type>
	var type = $(this).attr('id');
	type = type.substr(type.indexOf('elgg-widget-type-') + "elgg-widget-type-".length);

	// if multiple instances not allow, disable this widget type add button
	var multiple = $(this).attr('class').indexOf('elgg-widget-multiple') != -1;
	if (multiple == true) {

        //count how many of this type of widget already exist
        var widget_tally = $('.elgg-widget-instance-' + type).length;
        widget_tally++;

        //update the counter
        var $counter = $(this).closest('.widget_manager_widgets_lightbox_actions').siblings('.multi-widget-count');
        $counter.addClass('multi-widget-count-activated');
        $counter.text(widget_tally);


	}
    else {
        $(this).addClass('elgg-state-unavailable');
        $(this).removeClass('elgg-state-available');
        $(this).unbind('click', elgg.ui.widgets.add);
        // bind the widge to the remove function instead
        $(this).bind('click', elgg.ui.widgets.removebtn);
		$(this).children('input.widget-to-add').attr('disabled', "disabled");		// disable add widget button
		$(this).children('input.widget-added').removeAttr('disabled');				// enable remove widget button
    }

	elgg.action('widgets/add', {
		data: {
			handler: type,
			owner_guid: elgg.get_page_owner_guid(),
			context: $("input[name='widget_context']").val(),
			show_access: $("input[name='show_access']").val(),
			default_widgets: $("input[name='default_widgets']").val() || 0
		},
		success: function(json) {
			$('#elgg-widget-col-1').prepend(json.output);
		}
	});
	event.preventDefault();
};



elgg.ui.widgets.toggleremove = function(event) {
    $('.elgg-widgets-add-panel li.elgg-widget-single.elgg-state-available').children('input.widget-added').attr('disabled', "disabled");       // disable remove widget button
    $('.elgg-widgets-add-panel li.elgg-widget-single.elgg-state-available').children('input.widget-to-add').removeAttr('disabled');         // enable add widget button

    // bind the button to the remove function instead
    $('.elgg-widgets-add-panel li.elgg-widget-single.elgg-state-available').unbind('click', elgg.ui.widgets.removebtn);
    $('.elgg-widgets-add-panel li.elgg-widget-single.elgg-state-available').unbind('click', elgg.ui.widgets.add);      // make sure we're not binding the same function multiple times
    $('.elgg-widgets-add-panel li.elgg-widget-single.elgg-state-available').bind('click', elgg.ui.widgets.add);

    // for widgets that allow multiple instances
    $('.elgg-widget-multiple').each(function() {
        var name = $(this).attr('id');
        name = name.substr(name.indexOf('elgg-widget-type-') + "elgg-widget-type-".length);

        var counter = $(this).closest('.widget_manager_widgets_lightbox_wrapper').find('.multi-widget-count');
        counter.text($('.elgg-widget-instance-' + name).length);
        counter.addClass('multi-widget-count-activated');

    });
}
/**
 * Removes a widget from the layout
 *
 * Event callback the uses Ajax to delete the widget and removes its HTML
 *
 * @param {Object} event
 * @return void
 */
elgg.ui.widgets.removebtn = function(event) {
	if (confirm(elgg.echo('deleteconfirm')) == false) {
		event.preventDefault();
		return;
	}
    var $widget;
	if ($(this).hasClass('elgg-widget-single')) {
        $widget = $(this).closest('.widget_manager_widgets_lightbox_wrapper');
        // find the name of the widget
        var name = $widget.attr('class');
        $name = name.substr(name.indexOf('widget_manager_widgets_lightbox_wrapper_') + "widget_manager_widgets_lightbox_wrapper_".length);

        $button = $('#elgg-widget-type-' + $name);

        $button.addClass('elgg-state-available');
        $button.removeClass('elgg-state-unavailable');
        $button.unbind('click', elgg.ui.widgets.removebtn); // make sure we don't bind twice
        $button.click(elgg.ui.widgets.add);
		$(this).children('input.widget-added').attr('disabled', "true");		// disable remove widget button
		$(this).children('input.widget-to-add').removeAttr('disabled');			// enable add widget button

        var $widget_dashboard = $('.elgg-widget-instance-' + $name);
        $widget_dashboard = $widget_dashboard.closest('.elgg-module-widget');

        to_delete = $widget_dashboard.find('.elgg-widget-delete-button');
        $widget_dashboard.remove();

        elgg.action((to_delete).attr('href'));

    }
    else {
        $widget = $(this).closest('.elgg-module-widget');

        // if widget type is single instance type, enable the add button
        var type = $widget.attr('class');
        // elgg-widget-instance-<type>
        type = type.substr(type.indexOf('elgg-widget-instance-') + "elgg-widget-instance-".length);
        $button = $('#elgg-widget-type-' + type);
        var multiple = $button.attr('class').indexOf('elgg-widget-multiple') != -1;

        if (multiple == false) {
            $button.addClass('elgg-state-available');
            $button.removeClass('elgg-state-unavailable');
            $button.unbind('click', elgg.ui.widgets.removebtn); // make sure we don't bind twice
            $button.click(elgg.ui.widgets.add);
        }

        $widget.remove();

        elgg.action($(this).attr('href'));
    }

	// delete the widget through ajax

	event.preventDefault();
};



elgg.register_hook_handler('init', 'system', elgg.ui.widgets.init);
