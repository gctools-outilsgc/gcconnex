elgg.provide('elgg.ui.widgets');

/**
 * Widgets initialization
 *
 * @return void
 */
elgg.ui.widgets.init = function() {

	// widget layout?
	if ($(".elgg-widgets").length === 0) {
		return;
	}

	$(".elgg-widgets").sortable({//Here is the jquery ui function that lets you drag and drop to sort widgets
		items:                'div.elgg-module-widget.elgg-state-draggable',
		connectWith:          '.elgg-widgets',
		handle:               '.elgg-widget-handle',
		forcePlaceholderSize: true,
		placeholder:          'elgg-widget-placeholder',
		opacity:              0.8,
		revert:               500,
		stop:                 elgg.ui.widgets.move
	});
    // making widgets move with the keyboard maybe? :3
    //All widgets you can edit now have aria attributes to know if they can be draggable. They also have a tabindex so they can be tabbed to.
	$('.elgg-state-draggable').focus(function () { //focus pokus ;3
	    //add selecting class
        
	    $(this).addClass("ui-selecting", function () { 
	        $('.ui-selecting').bind('keydown', function (event) {
	            if (event.which == 13) { //Enter to move it
	                //alert('Enter');
	                $(this).addClass('widget-enter-selected');
	                $(this).attr('aria-grabbed', 'true'); //it's selected to be moved
	                $(this).on('keydown', function (event) {

	                    //add keybinding to object :3
	                    var pcurrent = $(this).position(); //get position of current widget
	                    var widgetParent = $(this).parent().attr('id'); //The column it's in
	                    var widgetindex = $('#' + widgetParent + ' .elgg-state-draggable').index(this); // get it's index ( I don't think this will help)
	                    var nextwidget;  // get the index of the next widget (this i think would go in the down arrow)
	                    var pnext = $('.elgg-state-draggable').eq(nextwidget).position(); //try to get the position of the next widget (kind of works :3)
	                    var nextWidgetIndex;
	                    if (event.which == 38) {//up arrow
	                        var nextwidget = widgetindex - 1; //get the index of widget before it
	                        var nextWidgetIndex = $('#' + widgetParent + ' .elgg-state-draggable').eq(nextwidget);
	                        $(this).after($(nextWidgetIndex)); //move the widget
	                        var thisWidget = $(this);

	                        //call the move function here when it's done!
	                        keyboardUpdatePosition(thisWidget); //Save the location of the widget
	                    }

	                    if (event.which == 40) { //down arrow
	                        var nextwidget = widgetindex + 1;
	                        //alert($(this).attr('id'));
	                        var nextWidgetIndex = $('#' + widgetParent + ' .elgg-state-draggable').eq(nextwidget);
	                        $(this).before($(nextWidgetIndex));
	                        var thisWidget = $(this);

	                        //YOLO code! You only YOLO once :3
	                        // This saves the location of the widget
	                    
	                        keyboardUpdatePosition(thisWidget);
	                    }

	                    if (event.which == 39) { //right arrow
	                        var thisWidget = $(this);
	                        //alert('Trying to move right eh?');
	                        if (widgetParent == 'elgg-widget-col-1') {
	                            //alert('im in the col 1');
	                            //$(this).clone($('#elgg-widget-col-2'));
	                            $('#elgg-widget-col-2').prepend(this);
	                            keyboardUpdatePosition(thisWidget);
	                            $(this).focus();
	                        }
	                    }

	                    if (event.which == 37) { //left arrow
	                        var thisWidget = $(this);
	                        //alert('Trying to move right eh?');
	                        if (widgetParent == 'elgg-widget-col-2') {
	                            //alert('im in the col 1');
	                            //$(this).clone($('#elgg-widget-col-2'));
	                            $('#elgg-widget-col-1').prepend(this);
	                            keyboardUpdatePosition(thisWidget);
	                            $(this).focus();
	                        }
	                    }

	                    if (event.which == 13) {
	                        $(this).removeClass('widget-enter-selected');
	                        var thisWidget = $(this);
	                        //keyboardUpdatePosition(thisWidget);
	                        $(this).attr('aria-grabbed', 'false');//change the aria attribute for screen readers to know it is picked up
	                    }
	                });
	                //keyboardMove();
	            };
	            })
	                

	    $('.elgg-state-draggable').focusout(function () {
	        $(this).removeClass("ui-selecting"); // when you stop focusing remove the class from DOM
	       // $(this).focusout();
	    });
	    });
	});
	keyboardMove = function (y) {
	    //this doesn't do nothing :3
	}
	keyboardUpdatePosition = function (x) {
        //function to save the widget location in the database
	    var guidString = $(x).attr('id');
	    guidString = guidString.substr(guidString.indexOf('elgg-widget-') + "elgg-widget-".length);

	    // elgg-widget-col-<column>
	    var col = $(x).parent().attr('id');
	    col = col.substr(col.indexOf('elgg-widget-col-') + "elgg-widget-col-".length);

	    elgg.action('widgets/move', {
	        data: {
	            widget_guid: guidString,
	            column: col,
	            position: $(x).index()
	        }
	    });
	}

	// the widgets available to be added
	// don't need to change       $('.elgg-widgets-add-panel li.elgg-state-available').click(elgg.ui.widgets.add);
	$('.elgg-widgets-add-panel li.elgg-state-available').children('input.widget-added').attr('disabled', "disabled");		// disable remove widget button

	// the present widgets with remove widget buttons active
    $('.elgg-widgets-add-panel li.elgg-state-unavailable').click(elgg.ui.widgets.removebtn);
    $('.elgg-widgets-add-panel li.elgg-state-unavailable').children('input.widget-to-add').attr('disabled', "disabled");		// disable add widget button

	$('a.elgg-widget-delete-button').live('click', elgg.ui.widgets.toggleremove);
	// don't need to change        $('.elgg-widget-edit > form ').live('submit', elgg.ui.widgets.saveSettings);
	$('a .elgg-widget-collapse-button').live('click', elgg.ui.widgets.collapseToggle);


    $('.elgg-widget-multiple').each(function() {
        var name = $(this).attr('data-elgg-widget-type');

        var counter = $(this).closest('.widget_manager_widgets_lightbox_wrapper').find('.multi-widget-count');
        counter.text($('.elgg-widget-instance-' + name).length);
        counter.addClass('multi-widget-count-activated');

    });

   
    $('.wet-collapsed').find('.elgg-menu-item-collapse').find('i').addClass('fa-expand');
    $('.wet-open').find('.elgg-menu-item-collapse').find('i').addClass('fa-compress');

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
elgg.ui.widgets.collapseToggle = function(event) {
    $(this).toggleClass('elgg-widget-collapsed');
    $(this).parent().parent().find('.elgg-body').slideToggle('medium');
    //toggle the collapse and expand icon
    var expandClass = $(this).children('i').attr('class');
    //alert(expandClass);
    if (expandClass == 'fa fa-lg icon-unsel fa-expand') {
        $(this).find('i').removeClass('fa-expand');
        $(this).find('i').addClass('fa-compress');
 
    }else{
        $(this).find('i').addClass('fa-expand');
        $(this).find('i').removeClass('fa-compress');
        
        
    }
    //alert('im collapsing!');
    //$(this).children('i').addClass('fa-expand');
    event.preventDefault();
    /*
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
        }*/
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
	var type = $(this).data('elgg-widget-type');

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
			page_owner_guid: elgg.get_page_owner_guid(),
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
        var name = $(this).data('elgg-widget-type');

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
        var name = $(this).data('elgg-widget-type');
        
        $button = $(this);
        $button.addClass('elgg-state-available');
        $button.removeClass('elgg-state-unavailable');
        $button.unbind('click', elgg.ui.widgets.removebtn); // make sure we don't bind twice
        $button.click(elgg.ui.widgets.add);
		$(this).children('input.widget-added').attr('disabled', "true");		// disable remove widget button
		$(this).children('input.widget-to-add').removeAttr('disabled');			// enable add widget button

        var $widget_dashboard = $('.elgg-widget-instance-' + name);
        $widget_dashboard = $widget_dashboard.closest('.elgg-module-widget');

        to_delete = $widget_dashboard.find('.elgg-widget-delete-button');
        $widget_dashboard.remove();

        elgg.action((to_delete).attr('href'));

    }
    else {
        $widget = $(this).closest('.elgg-module-widget');

        // if widget type is single instance type, enable the add button
        var type = $(this).data('elgg-widget-type');
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

	event.preventDefault();
};



elgg.register_hook_handler('init', 'system', elgg.ui.widgets.init);
