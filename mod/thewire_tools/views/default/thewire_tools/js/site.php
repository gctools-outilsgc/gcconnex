<?php ?>
//<script>
elgg.provide('elgg.thewire_tools');

elgg.thewire_tools.init = function() {
	function split( val ) {
		return val.split( / \s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}

	$('.elgg-form-thewire-add textarea[name="body"]').each(function(i){
		$(this)
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				source: function( request, response ) {
					$.getJSON( elgg.get_site_url() + "thewire/autocomplete", {
						q: extractLast( request.term ),
						page_owner_guid: elgg.get_page_owner_guid()
					}, response );
				},
				search: function() {
					// custom minLength
					var term = extractLast( this.value );
					var firstChar = term.substring(0,1);

					if (( term.length > 1) && (firstChar == "@" || firstChar == "#")) {
						return true;
					}
					return false;
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split(this.value);
					// remove the current input
					terms.pop();
					// add the selected item
					if(ui.item.type == "user"){
						terms.push("@" + ui.item.username );
					} else {
						terms.push("#" + ui.item.value );
					}

					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( " " );
					return false;
				},
				autoFocus: true
			}).data( "autocomplete" )._renderItem = function( ul, item ) {
				var list_body = "";
				if(item.type == "user"){
					list_body = "<img src='" + item.icon + "' /> " + item.name;
				} else {
					list_body = item.value;
				}

				return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + list_body + "</a>" )
				.appendTo( ul );
			};
	});
};


elgg.register_hook_handler('init', 'system', elgg.thewire_tools.init);