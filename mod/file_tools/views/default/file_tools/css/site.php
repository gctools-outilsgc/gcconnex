<?php

?>
.file-tools-icon-tiny {
	width: 20px;
	height: 20px;
}

.elgg-menu-file-tools-folder-breadcrumb > li:after {
	padding: 0 4px;
	content: ">";
}

#file_tools_list_files_container {
	position: relative;
}

#file_tools_list_files_container .elgg-ajax-loader {
	background-color: white;
	opacity: 0.85;
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
}

#file_tools_list_files .ui-draggable,
.file-tools-file.ui-draggable {
	cursor: move;
	background: white;
}

#file-tools-folder-tree .file-tools-tree-droppable-hover {
	border: 1px solid red;
}

#file-tools-multi-form .uploadify-queue-item {
	max-width: 100%;
}