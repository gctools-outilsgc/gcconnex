<?php

?>
//<script>
elgg.provide("elgg.blog_tools");

elgg.blog_tools.init = function() {
	elgg.ui.registerTogglableMenuItems("blog-feature", "blog-unfeature");
}

elgg.register_hook_handler("init", "system", elgg.blog_tools.init);