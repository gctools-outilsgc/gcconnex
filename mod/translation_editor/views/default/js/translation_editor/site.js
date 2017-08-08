
elgg.provide('elgg.translation_editor');

elgg.translation_editor.init = function() {
	// translation editor user hover meu items
	elgg.ui.registerTogglableMenuItems("translation-editor-make-editor", "translation-editor-unmake-editor");
}

elgg.register_hook_handler('init', 'system', elgg.translation_editor.init);
