<?php
$base_url = elgg_get_site_url();
$graphics_url = $base_url . 'mod/hypeFramework/graphics/';
?>
<?php if (FALSE) : ?>
	<style>
	<?php endif; ?>

	.hj-ajax-loader {
		margin:0 auto;
	}
	.hj-loader-circle {
		background:transparent url(<?php echo $graphics_url ?>loader/circle.gif) no-repeat center center;
		width:75px;
		height:75px;
	}

	.hj-loader-overlay {
		background:#fff url(<?php echo $graphics_url ?>loader/circle.gif) no-repeat center center;
		position: absolute;
		width: 100%;
		height: 100%;
		min-width:75px;
		min-height:75px;
		top: 0;
		bottom:0;
		left: 0;
		right:0;
		z-index: 3000;
		opacity: 0.8;
	}

	.hj-loader-bar {
		background:transparent url(<?php echo $graphics_url ?>loader/bar.gif) no-repeat center center;
		width:16px;
		height:11px;
		display: inline-block;
		vertical-align: middle;
		margin-right: 10px;
	}
	.hj-loader-arrows {
		background:transparent url(<?php echo $graphics_url ?>loader/arrows.gif) no-repeat center center;
		width:16px;
		height:16px;
	}
	.hj-loader-indicator {
		background:transparent url(<?php echo $graphics_url ?>loader/indicator.gif) no-repeat center center;
		width:16px;
		height:16px;
		margin:8px auto;
	}

	form.elgg-state-loading:before {
		display: inline-block;
		content:"";
		width: 100%;
		height: 11px;
		background: transparent url(<?php echo $graphics_url ?>loader/bar.gif) no-repeat 50% 50%;
	}

	.elgg-pagination li a.elgg-state-loading {
		color:transparent;
		background: transparent url(<?php echo $graphics_url ?>loader/bar.gif) no-repeat 50% 50%;
	}

	table.elgg-state-loading .table-headers {
		color:transparent;
		background-image: url(<?php echo $graphics_url ?>loader/bar.gif);
		background-repeat: no-repeat;
		background-position: 50% 50%;
	}

	/** jQuery UI Dialog */
	.hj-framework-dialog {
		border: 1px solid #e8e8e8;
		border-radius: 0;
		padding: 0;
	}
	.hj-framework-dialog .ui-dialog-titlebar {
		border-radius: 0;
		border: 0;
		border-bottom: 1px solid #e8e8e8;
		background: #f4f4f4;
		line-height: 30px;
		margin:2px;
		box-sizing:border-box;
	}
	.hj-framework-dialog .ui-dialog-titlebar-close {
		margin: -10px 7px 0 0;
	}
	.hj-framework-dialog .ui-dialog-buttonpane {
		border: 0;
		border-top: 1px solid #e8e8e8;
	}
	.hj-framework-dialog .elgg-module-form > .elgg-body {
		border: 0;
		padding: 5px;
		margin: 0;
		font-size: 0.9em;
	}

	.hj-draggable-element-handle {
		cursor:move;
	}

	.hj-draggable-element-placeholder {
		border:2px dashed #e8e8e8;
	}
	tr.hj-draggable-element-placeholder {
		background:#f4f4f4;
	}

	.hj-framework-cover-image {
		background-image: url(http://localhost/hypetest186/framework/icon/546932/master/1360297391.jpg);
		width: 100%;
		height: 200px;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: 100%;
	}

	.elgg-menu-entity > li.hidden,
	.elgg-menu-title > li.hidden {
		display:none;
	}