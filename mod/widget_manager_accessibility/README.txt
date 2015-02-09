Overrides:
 functions from file js/lib/ui.widgets.js:
	elgg.ui.widgets.init
	elgg.ui.widgets.add
	elgg.ui.widgets.remove

 View:
 	page/layouts/widgets/add_button.php


#34:
Requires removal of line 31 in js/lib/ui.widget.js core:
$('a.elgg-widget-collapse-button').live('click', elgg.ui.widgets.collapseToggle);


Accessibility / Usability issues addressed:
		(Github #22, #23, #68, #34)
		 #71 fixed separately in widget manager mod.