<script type="text/javascript" >

$(function() {
	
	// Create dropdown
	$("<select />").appendTo("ul.elgg-menu-site");

	$("<option />", {
		 "selected": "selected",
		 "value"   : "",
		 "text"    : "<?php echo elgg_echo('mobilize:navigation'); ?>"
	}).appendTo("ul.elgg-menu-site select");
	
	$("ul.elgg-menu-site a").each(function() {
		var el = $(this);
		$("<option />", {
		   "value"   : el.attr("href"),
		   "text"    : el.text()
		}).appendTo("ul.elgg-menu-site select");
	});

	$("ul.elgg-menu-site select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	$(this).find("option:selected").text();
});

$(function() {

	$("<select />").appendTo("ul.elgg-menu-owner-block-default");

	$("<option />", {
		 "selected": "selected",
		 "value"   : "",
		 "text"    : "<?php echo elgg_echo('mobilize:menu'); ?>"
	}).appendTo("ul.elgg-menu-owner-block-default select");
	
	$("ul.elgg-menu-owner-block-default a").each(function() {
		var el = $(this);
		$("<option />", {
		   "value"   : el.attr("href"),
		   "text"    : el.text()
		}).appendTo("ul.elgg-menu-owner-block-default select");
	});	

	$("ul.elgg-menu-owner-block-default select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	$(this).find("option:selected").text();
});

$(function() {

	$("<select />").appendTo("ul.elgg-menu-page-default");

	$("<option />", {
		 "selected": "selected",
		 "value"   : "",
		 "text"    : "<?php echo elgg_echo('mobilize:menu'); ?>"
	}).appendTo("ul.elgg-menu-page-default select");

	$("ul.elgg-menu-page-default a").each(function() {
		var el = $(this);
		$("<option />", {
		   "value"   : el.attr("href"),
		   "text"    : el.text()
		}).appendTo("ul.elgg-menu-page-default select");
	});	

	$("ul.elgg-menu-page-default select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	$(this).find("option:selected").text();
});

</script>

<?php
/**
 * Elgg page header 
 * In the default theme, the header lives between the topbar and main content area.
 */

// link back to main site.
echo elgg_view('page/elements/header_logo', $vars);

// drop-down login
//echo elgg_view('core/account/login_dropdown');

// insert site-wide navigation
if (elgg_is_logged_in()) {
	echo elgg_view_menu('site');
}

