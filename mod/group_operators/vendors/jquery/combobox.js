elgg.provide('elgg.combobox');


(function($){
    $.widget( "ui.combobox", $.ui.autocomplete, 
    	{
    		options: { 
    			/* override default values here */
    			minLength: 2,
    			/* the argument to pass to ajax to get the complete list */
    			ajaxGetAll: {get: "all"},
    			/* you can specify the field to use as a label decorator, 
    			 * it's appended to the end of the label and is excluded 
    			 * from pattern matching.    
    			 */
    			decoratorField: null
    		},
    		
    		_create: function(){
    			if (this.element.is("SELECT")){
    				this._selectInit();
    				return;
    			}
    			
    			$.ui.autocomplete.prototype._create.call(this);
                var input = this.element;
    			input.addClass( "ui-widget ui-widget-content ui-corner-left" )
    			     .click(function(){ this.select(); });
    			
    			this.button = $( "<button type='button'>&nbsp;</button>" )
                .attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .insertAfter( input )
                .button({
                	disabled: true, // to be enabled when the menu is ready.
                    icons: { primary: "ui-icon-triangle-1-s" },
                    text: false
                })
                .removeClass( "ui-corner-all" )
                .addClass( "ui-corner-right ui-button-icon" )
                .click(function(event) {
                    // when user clicks the show all button, we display the cached full menu
                    var data = input.data("ui-combobox");
                    clearTimeout( data.closing );
                    if (!input.isFullMenu){
                    	data._swapMenu();
                    }
                    /* input/select that are initially hidden (display=none, i.e. second level menus), 
                       will not have position cordinates until they are visible. */
                    input.combobox( "widget" ).css( "display", "block" )
                    .position($.extend({ of: input },
                    	data.options.position
                    	));
                    input.focus();
                    data._trigger( "open" );
                    // containers such as jquery-ui dialog box will adjust it's zIndex to overlay above other elements.
                    // this becomes a problem if the combobox is inside of a dialog box, the full drop down will show
                    // under the dialog box.
                    if (input.combobox( "widget" ).zIndex() <= input.parent().zIndex()){
                    	input.combobox( "widget" ).zIndex(input.parent().zIndex()+1);	
                    }
                });
    			
    			/* to better handle large lists, put in a queue and process sequentially */
    			$(document).queue(function(){
    				var data = input.data("ui-combobox");
    				if ($.isArray(data.options.source)){ 
    				    $.ui.combobox.prototype._renderFullMenu.call(data, data.options.source);
    				}else if (typeof data.options.source === "string") {
                        $.getJSON(data.options.source, data.options.ajaxGetAll , function(source){
                        	$.ui.combobox.prototype._renderFullMenu.call(data, source);
                        });
                    }else {
                    	$.ui.combobox.prototype._renderFullMenu.call(data, data.source());
    				}
    			});
    		},
    		
    		/* initialize the full list of items, this menu will be reused whenever the user clicks the show all button */
    		_renderFullMenu: function(source){
    			var self = this,
    			    input = this.element,
                    ul = input.data( "ui-combobox" ).menu.element,
                    lis = [];
    			source = this._normalize(source); 
                input.data( "ui-combobox" ).menuAll = input.data( "ui-combobox" ).menu.element.clone(true).appendTo("body")[0];
                for(var i=0; i<source.length; i++){
                	var item = source[i],
                	    label = item.label;
                	if (this.options.decoratorField != null){
                        var d = item[this.options.decoratorField] || (item.option && $(item.option).attr(this.options.decoratorField));
                        if (d != undefined)
                            label = label + " " + d;
                    }
                    lis[i] = "<li class=\"ui-menu-item\" role=\"menuitem\"><a class=\"ui-corner-all\" tabindex=\"-1\">"+label+"</a></li>";
                }
                ul[0].innerHTML = lis.join("");
                this._resizeMenu();
                
                var items = $("li", ul).on("mouseover", "mouseout", function( event ) {
                	if (event.type == "mouseover"){
                		self.menu.focus( event, $(this));
                	} else {
                		self.menu.blur();
                	}
                });
                for(var i=0; i<items.length; i++){
                    $(items[i]).data( "ui-autocomplete-item", source[i]);
                }
                input.isFullMenu = true;
                this._swapMenu();
                // full menu has been rendered, now we can enable the show all button.
                self.button.button("enable");
                setTimeout(function(){
                	$(document).dequeue();
                }, 0);
    		},
    		
    		/* overwrite. make the matching string bold and added label decorator */
    		_renderItem: function( ul, item ) {
                var label = item.label.replace( new RegExp(
                	"(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + 
                    ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>" );
                if (this.options.decoratorField != null){
                	var d = item[this.options.decoratorField] || (item.option && $(item.option).attr(this.options.decoratorField));
                	if (d != undefined){
                		label = label + " " + d;
                	}
                }
                return $( "<li></li>" )
                    .data( "ui-autocomplete-item", item )
                    .append( "<a>" + label + "</a>" )
                    .appendTo( ul );
            },
            
            close: function() {
               if (this.element.isFullMenu) {
            	   this._swapMenu();
               }
               // super()
               $.ui.autocomplete.prototype.close.call(this);
            },
            
            /* overwrite. to cleanup additional stuff that was added */
            destroy: function() {
            	if (this.element.is("SELECT")){
            		this.input.removeData("ui-combobox", "menuAll");
            		this.input.remove();
            		this.element.removeData().show();
            		return;
            	}
            	// super()
                $.ui.autocomplete.prototype.destroy.call(this);
            	// clean up new stuff
                this.element.removeClass( "ui-widget ui-widget-content ui-corner-left" );
                this.button.remove();
            },
            
            /* overwrite. to swap out and preserve the full menu */ 
            search: function( value, event){
            	var input = this.element;
                if (input.isFullMenu){
                	this._swapMenu();
                }
                // super()
                $.ui.autocomplete.prototype.search.call(this, value, event);
            },
            
            _change: function( event ){
            	if ( !this.selectedItem ) {
                    var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( this.element.val() ) + "$", "i" ),
                        match = $.grep( this.options.source, function(value) {
                            return matcher.test( value.label );
                        });
                    if (match.length){
                    	if (match[0].option != undefined) match[0].option.selected = true;
                    }else {
                        // remove invalid value, as it didn't match anything
                        if (this.options.selectElement) {
                        	var firstItem = this.options.selectElement.children("option:first");
                            this.element.val(firstItem.text());
                        	firstItem.prop("selected", true);
                        }else {
                        	this.element.val( "" );
                        }
                        $(event.target).data("ui-combobox").previous = null;  // this will force a change event
                    }
                }                
            	// super()
            	$.ui.autocomplete.prototype._change.call(this, event);
            },
            
            _swapMenu: function(){
            	var input = this.element, 
            	    data = input.data("ui-combobox"),
            	    tmp = data.menuAll;
                data.menuAll = data.menu.element.hide()[0];
                data.menu.element[0] = tmp;
                input.isFullMenu = !input.isFullMenu;
            },
            
            /* build the source array from the options of the select element */
            _selectInit: function(){
                var select = this.element,
                    selectClass = select.attr("class"),
                    selectStyle = select.attr("style"),
                    selected = select.children( ":selected" ),
                    value = $.trim(selected.text());
                select.hide();
                this.options.source = select.children( "option" ).map(function() {
                    return { label: $.trim(this.text), option: this };
                }).toArray();
                var userSelectCallback = this.options.select;
                var userSelectedCallback = this.options.selected;
                this.options.select = function(event, ui){
                   	ui.item.option.selected = true;
                   	select.change();
                   	if (userSelectCallback) userSelectCallback(event, ui);
                   	// compatibility with jQuery UI's combobox.
                   	if (userSelectedCallback) userSelectedCallback(event, ui);
                };
                this.options.selectElement = select;
                this.input = $( "<input>" ).insertAfter( select ).val( value );
                if (selectStyle){
                	this.input.attr("style", selectStyle);
                }
                if (selectClass){
                	this.input.attr("class", selectClass);
                }
                this.input.combobox(this.options);
            },
            inputbox: function(){
            	if (this.element.is("SELECT")){
    				return this.input;
    			}else {
    				return this.element;
    			}
            }
    	}
    );
})(jQuery);

