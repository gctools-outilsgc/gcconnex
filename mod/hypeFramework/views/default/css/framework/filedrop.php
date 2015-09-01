<?php
$graphics_url = elgg_get_site_url() . 'mod/hypeFramework/graphics/filedrop/';
?>
<?php if (FALSE) : ?>
	<style type="text/css">
	<?php endif; ?>
	
.filedrop {
	position: relative;
	margin:20px 0;
	min-height: 100px;
	overflow: hidden;
	border:2px dashed #e8e8e8;
	vertical-align: middle;
}

.filedrop-message{
	font-size: 12px;
    padding:40px;
	display: block;
}

.filedrop-preview {
	width:120px;
	height: 120px;
	display:inline-block;
	margin: 20px;
	position: relative;
	text-align: center;
	vertical-align:top;
}

.filedrop-preview img {
	max-width: 100px;
	max-height:100px;
	border:3px solid #fff;
	display: block;

	box-shadow:0 0 2px #000;
}

.filedrop-imageholder {
	display: inline-block;
	position:relative;
}

.filedrop .elgg-state-uploaded {
	position: absolute;
	top:0;
	left:0;
	height:100%;
	width:100%;
	background: url('<?php echo $graphics_url ?>done.png') no-repeat bottom right rgba(255,255,255,0.2);
	display: none;
}

.filedrop-preview.elgg-state-complete .elgg-state-uploaded{
	display: block;
}

/*-------------------------
	Progress Bars
--------------------------*/

.filedrop-progressholder{
	position: absolute;
	background-color:#e8e8e8;
	height:10px;
	width:100%;
	left:0;
	bottom: 0;
	margin-top:10px;

}

.filedrop-progress {
	background-color:#32cd32;
	position: absolute;
	height:100%;
	left:0;
	width:0;

	-moz-transition:0.25s;
	-webkit-transition:0.25s;
	-o-transition:0.25s;
	transition:0.25s;
}

.filedrop-preview.elgg-state-complete .filedrop-progress{
	width:100% !important;
}