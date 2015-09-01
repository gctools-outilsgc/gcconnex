<?php if (FALSE) : ?>
	<script type="text/javascript">
<?php endif; ?>

	elgg.provide('framework');
	elgg.provide('framework.data');
	elgg.provide('framework.data.lists');
	elgg.provide('framework.resources');
	elgg.provide('framework.ajax');
	elgg.provide('framework.ajax.scenarios');
	elgg.provide('framework.loaders');

	framework.loaders.overlay = $('<div>').addClass('hj-ajax-loader').addClass('hj-loader-overlay');
	framework.loaders.circle = $('<div>').addClass('hj-ajax-loader').addClass('hj-loader-circle');
	framework.loaders.indicator = $('<div>').addClass('hj-ajax-loader').addClass('hj-loader-indicator');
	framework.loaders.bar = $('<div>').addClass('hj-ajax-loader').addClass('hj-loader-bar');

	/**
	 * Create a record of loaded scripts and stylesheets
	 */
	framework.ajax.fetchOnSystemInit = function() {
		if (!framework.resources.length) {
			framework.resources = new Array();
		} else {
			return;
		}

		// get loaded scripts
		$('script')
		.each(function() {
			framework.resources.push($(this).attr('src'));
		})

		$('link')
		.each(function() {
			framework.resources.push($(this).attr('href'));
		})
	}

	/**
	 *	Load missing scripts
	 */
	framework.ajax.getScript = function(url, callback) {
		var head = document.getElementsByTagName("head")[0];
		var script = document.createElement("script");
		script.src = url;

		// Handle Script loading
		{
			var done = false;

			// Attach handlers for all browsers
			script.onload = script.onreadystatechange = function(){
				if ( !done && (!this.readyState ||
					this.readyState == "loaded" || this.readyState == "complete") ) {
					done = true;
					if (callback)
						callback();

					// Handle memory leak in IE
					script.onload = script.onreadystatechange = null;
				}
			};
		}

		head.appendChild(script);

	}

	/**
	* Load missing stylesheets
	*/
	framework.ajax.getStylesheet = function(url, callback) {
		var head = document.getElementsByTagName("head")[0];
		var link = document.createElement("link");
		link.rel = 'stylesheet';
		link.type = 'text/css';
		link.href = url;

		// Handle Script loading
		{
			var done = false;

			// Attach handlers for all browsers
			link.onload = link.onreadystatechange = function(){
				if ( !done && (!this.readyState ||
					this.readyState == "loaded" || this.readyState == "complete") ) {
					done = true;
					if (callback)
						callback();

					// Handle memory leak in IE
					link.onload = link.onreadystatechange = null;
				}
			};
		}

		head.appendChild(link);

	}

	/**
	 * Check if any new scripts and stylesheets need to be loaded
	 * This function is automatically triggered by 'ajax:success','framework' hook
	 */
	framework.ajax.fetchOnAjaxSuccess = function(name, type, params, value) {

		if (!params) return;
		var resources = params.response.resources;

		if (!resources) return;

		for (var i=0;i < resources.js.length;i++) {
			if ($.inArray(resources.js[i], framework.resources) == -1) {
				framework.ajax.getScript(resources.js[i]);
				framework.resources.push(resources.js[i]);
			}
		}

		for (var i=0;i < resources.css.length;i++) {
			if ($.inArray(resources.css[i], framework.resources) == -1) {
				framework.ajax.getStylesheet(resources.css[i]);
				framework.resources.push(resources.css[i]);
			}
		}
	}

	framework.ajax.init = function() {

		$('form .elgg-button-cancel-trigger')
		.live('click', function(event) {
			if ($(this).closest('#fancybox-content').length > 0) {
				$.fancybox.close();
				return false;
			} else if ($(this).closest('#dialog').length > 0) {
				$(this).closest('#dialog').dialog('destroy').remove();
				return false;
			} else {
				window.history.back();
			}
		})

		$('form .elgg-button-reset')
		.live('click', function(event) {
			event.preventDefault();
			$(this).closest('form').resetForm().trigger('submit');
		})

		$('a.list-filter-control, a.sort-control, a.sort-title, .hj-framework-list-pagination > li > a')
		.live('click', framework.ajax.getUpdatedList);

		$('.hj-framework-list-filter form')
		.live('submit', framework.ajax.filterList);

		$('.hj-framework-list-filter form select')
		.live('change', function() {
			$(this).closest('form').trigger('submit');
		});
		
		$('.elgg-button-create-entity')
		.live('click', framework.ajax.scenarios.createEntity);

		$('.elgg-button-edit-entity')
		.live('click', framework.ajax.scenarios.editEntity);

		$('.elgg-button-delete-entity')
		.live('click', framework.ajax.scenarios.deleteEntity);

	}

	framework.ajax.scenarios.createEntity = function(event) {

		$element = $(this);

		if ($element.data('toggle') !== 'dialog') { // Make sure element's data-toggle attribute is set to dialog
			return true;
		}

		var params = {
			element : $element,
			event : event
		}

		return elgg.trigger_hook('form:dialog', 'framework', params, false);

	}

	framework.ajax.scenarios.editEntity = function(event) {

		$element = $(this);

		if ($element.data('toggle') !== 'dialog') { // Make sure element's data-toggle attribute is set to dialog
			return true;
		}

		var params = {
			element : $element,
			event : event
		}

		return elgg.trigger_hook('form:dialog', 'framework', params, false);

	}

	framework.ajax.scenarios.deleteEntity = function(event) {

		$element = $(this);

		var uid = $element.data('uid');
		var action = $element.attr('href');

		var params = {
			element : $element,
			action : action,
			uid : uid
		}

		return elgg.trigger_hook('delete:entity', 'framework', params, false);

	}

	framework.ajax.formDialog = function(name, type, params, value) {

		var data = $(this).data();
		data['X-Requested-With'] = 'XMLHttpRequest';
		data.view = 'xhr'; // set viewtype
		data.endpoint = 'content';

		elgg.post($element.attr('href'), {
			data : data,
			dataType: 'json',
			beforeSend : function() {
				$dialog = $('<div id="dialog">')
				.appendTo('body')
				.html(framework.loaders.circle)
				.appendTo('body')
				.dialog({
					dialogClass: 'hj-framework-dialog',
					title : elgg.echo('hj:framework:ajax:loading'),
					buttons : false,
					//modal : true,
					//autoResize : true,
					width : 650,
					height : 500,
					close: function(event, ui)
					{
						$(this).dialog('destroy').remove();
					}
				});
			},
			complete : function() {

			},
			success : function(response) {

				$content = $(response.output.body.content);

				$title = $content.find('.elgg-head');
				var title = $title.text();
				if (!title.length) {
					title = response.output.body.title;
				}

				var buttons = new Array();

				$($title, $content).remove();

				$dialog
				.html($content)
				.dialog({
					title: title
				});

				$footer = $dialog.find('.elgg-foot');

				$dialog.find('input[type="submit"], input[type="button"], .elgg-button', '.elgg-foot').each(function() {
					var $button = $(this).hide();
					if ($button.hasClass('elgg-button-cancel-trigger')) {
						buttons.push({
							text : ($button.attr('value')) ? $button.attr('value') : elgg.echo('cancel'),
							click : function() {
								$dialog.dialog('close');
							}
						})
					} else {
						buttons.push({
							text : ($button.attr('value')) ? $button.attr('value') : $button.text(),
							click : function(e) {
								$button.trigger('click');
								e.preventDefault();
							}
						})
					}
				})

				$dialog
				.dialog({
					buttons : buttons
				})

				var params = new Object();
				params.event = 'getForm';
				params.response = response;
				params.data = data;

				elgg.trigger_hook('ajax:success', 'framework', params, true);


				if (!$element.data('callback')) {
					return true;
				}

				// atttaching the triggering element to form so that we can use it's parameters
				$('form', $dialog).data('trigger', $element).submit(framework.ajax.submit);

			}
		})

		return false;

	}

	framework.ajax.deleteEntity = function(name, type, params, value) {

		//		var uid = params.uid;
		var action = params.action;
		var $element = params.element;

		var confirmText = elgg.echo('question:areyousure');
		if (!confirm(confirmText)) {
			return false;
		}
		
		elgg.action(action, {
			dataType : 'json',
			beforeSend : function() {
				elgg.system_message(elgg.echo('hj:framework:ajax:deleting'));
				$element.addClass('elgg-state-loading')
			},
			complete : function() {
				$element.removeClass('elgg-state-loading')
			},
			success : function(response) {
				
				if (response.status >= 0) {
					var uid = response.output.guid;
					$('[data-uid="' + uid + '"], [id="elgg-object-' + uid + '"]')
					.remove()
				}
			}

		})

		return false;
	}

	framework.ajax.submit = function(event) {

		var $form = $(this);
		var $dialog = $form.closest('#dialog');
		var $element = $form.data('trigger');

		var data = $element.data();
		data['X-Requested-With'] = 'XMLHttpRequest';
		data['X-PlainText-Response'] = true;
		data.view = 'xhr'; // set viewtype
		data.endpoint = 'content';

		var params = ({
			dataType : 'json',
			data : data,
			beforeSend : function() {
				$form.hide();
				$dialog
				.append(framework.loaders.circle);
				$dialog.focus();
				$dialog.dialog({
					title : elgg.echo('hj:framework:ajax:saving'),
					buttons:null
				});
				return true;
			},
			complete : function() {
				$dialog.dialog('destroy').remove();
			},
			success : function(response, status, xhr) {

				var hookParams = new Object();
				hookParams.event = 'submitForm';
				hookParams.response = response;
				hookParams.element = $element;
				hookParams.data = $form.serialize();

				if (response.output.guid) {
					hookParams.href = framework.ajax.updateUrlQuery(window.location.href, { '__goto' : response.output.guid });
				}

				// an error occurred, reload the form
				if (response.status < 0) {
					$dialog.dialog('destroy').remove();
					$element.trigger('click');
					return false;
				}

				if ($element.data('callback')) {
					var hook = $element.data('callback').split('::');
					elgg.trigger_hook(hook[0], hook[1], hookParams);
				}

				elgg.trigger_hook('ajax:success', 'framework', hookParams, true);

				$form.resetForm();
			}

		});

		if ($form.find('input[type=file]')) {
			params.iframe = true;
		} else {
			params.iframe = false;
		}

		$form.ajaxSubmit(params);

		return false;

	}

	framework.ajax.success = function(hook, type, params) {
		if (params && params.response && params.response.system_messages) {
			elgg.register_error(params.response.system_messages.error);
			elgg.system_message(params.response.system_messages.success);
		}
		if (elgg.tinymce) {
			elgg.tinymce.init();
		}
	}

	framework.ajax.getUpdatedList = function(e) {
		elgg.trigger_hook('refresh:lists', 'framework', { element : $(this), href : $(this).attr('href')});
		return false;
	}

	framework.ajax.filterList = function(e) {
		var params = $(this).serialize();
		if ($(this).attr('action') == '') {
			var href = window.location.href;
		} else {
			var href = $(this).attr('action');
		}
		var href = framework.ajax.updateUrlQuery(href, params);
		elgg.trigger_hook('refresh:lists', 'framework', { element : $(this), href : href });
		return false;
	}

	framework.ajax.getUpdatedLists = function(hook, type, params) {

		var $element = params.element;

		if ($element.closest('table').length) {
			$element = $element.closest('table');
		}
		if (params.href) {
			var href = params.href;
		} else {
			var href = window.location.href;
		}
		
		elgg.post(href, {
			beforeSend : function() {
				$element.addClass('elgg-state-loading');
			},

			complete : function() {
				$element.removeClass('elgg-state-loading');
			},

			data : {
				'X-Requested-With' : 'XMLHttpRequest',
				'view' : 'xhr',
				'endpoint' : 'xhr_global'
			},
			dataType : 'json',

			success : function(response) {

				var updatedLists = response.output.body.lists;

				$.each(updatedLists, function(key, listParams) {

					var		updatedList = listParams,
					listType = updatedList.list_type;

					if (!listType) {
						listType = 'list';
					}

					elgg.trigger_hook('refresh:lists:' + listType, 'framework', listParams);
									
				})

//				if (params.pushState !== false && !$element.closest('#dialog').length) {
//					// do not update href if we are in a dialog window
//					window.history.replaceState(null, response.output.title, response.href);
//				}

				elgg.trigger_hook('ajax:success', 'framework', { response : response, element : $element});
			}
		})
	}

	framework.ajax.processUpdatedList = function(hook, type, updatedList) {

		var	listType = updatedList.list_type;

		if (!listType) {
			listType = 'list';
		}

		var $currentList = $('#' + updatedList.list_id),
		$currentListItems = $('.elgg-item', $currentList);

		switch (listType) {

			case 'list' :
				var $listBody = $currentList;
				break;

			case 'gallery' :
				var $listBody = $currentList;
				break;

			case 'table' :
				$currentList.children('thead').replaceWith(updatedList.head);
				var $listBody = $currentList.children('tbody');
				break;

			default :
				return false;
				break;
		}

		var updatedListItemUids = new Array(), currentListItemUids = new Array(), updatedListItemViews = new Array();

		$currentListItems.each(function() {
			currentListItemUids.push($(this).data('uid'));
		});

		if (!updatedList.items) {
			updatedList.items = new Array();
		}

		var $newList = $listBody.clone(true).html('');
		$.each(updatedList.items, function(pos, itemView) {
			var itemUid = $(itemView).data('uid');
			updatedListItemUids.push(itemUid);
			updatedListItemViews[itemUid] = itemView;
			var $new = $(itemView).addClass('hj-framework-list-item-new');
			var $existing = $currentList.find('.elgg-item[data-uid=' + itemUid + ']:first');
			if (($existing.length == 0) || ($existing.length && $new.data('ts') > $existing.data('ts'))) {
				var $append = $new;
			} else if ($existing.length && $new.data('ts') <= $existing.data('ts')) {
				var $append = $existing;
			}
			$newList.append($append);
		})
		$listBody.replaceWith($newList);

		$('.hj-framework-list-pagination-wrapper[for=' + updatedList.list_id + ']').replaceWith(updatedList.pagination);

	}

	framework.ajax.getUpdatedPage = function(hook, type, params) {

		window.location.reload();

	}

	framework.ajax.updateUrlQuery = function(url, params) {
		if (elgg.isString(url)) {
			var parts = elgg.parse_url(url),
			args = {},
			base = '';

			if (parts['host'] == undefined) {
				if (url.indexOf('?') === 0) {
					base = '?';
					args = framework.parse_str(parts['query']);
				}
			} else {
				if (parts['query'] != undefined) {
					// with query string
					args = framework.parse_str(parts['query']);
				}
				var split = url.split('?');
				base = split[0] + '?';
			}

			if (elgg.isString(params)) {
				params = framework.parse_str(params);
			}

			$.each(params, function(key, value) {
				args[key] = value;
			})

			return base + $.param(args);
		}
	}

	framework.parse_str = function(string) {
		var params = {};
		var result,
		key,
		keys = new Array(),
		value,
		re = /([^&=]+)=?([^&]*)/g;

		while (result = re.exec(string)) {
			key = decodeURIComponent(result[1])
			value = decodeURIComponent(result[2])
			if ($.inArray(key, keys) < 0) {
				keys.push(key);
				params[key] = value;
			} else {
				if (typeof params[key] == 'string') {
					var temp = params[key];
					params[key] = new Array();
					params[key].push(temp);
				}
				params[key].push(value);
			}
		}
		return params;
	}
	// JS and CSS fetching
	elgg.register_hook_handler('init', 'system', framework.ajax.fetchOnSystemInit, 999);
	elgg.register_hook_handler('ajax:success', 'framework', framework.ajax.fetchOnAjaxSuccess, 999);
	
	elgg.register_hook_handler('init', 'system', framework.ajax.init);

	elgg.register_hook_handler('ajax:success', 'framework', framework.ajax.success);

	elgg.register_hook_handler('form:dialog', 'framework', framework.ajax.formDialog);

	elgg.register_hook_handler('refresh:lists', 'framework', framework.ajax.getUpdatedLists);
	elgg.register_hook_handler('refresh:lists:list', 'framework', framework.ajax.processUpdatedList);
	elgg.register_hook_handler('refresh:lists:table', 'framework', framework.ajax.processUpdatedList);
	elgg.register_hook_handler('refresh:lists:gallery', 'framework', framework.ajax.processUpdatedList);

	elgg.register_hook_handler('reload:page', 'framework', framework.ajax.getUpdatedPage);

	elgg.register_hook_handler('delete:entity', 'framework', framework.ajax.deleteEntity);

<?php if (FALSE) : ?></script><?php
endif;
?>
