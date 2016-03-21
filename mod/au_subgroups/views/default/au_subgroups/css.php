<?php

namespace AU\SubGroups;

$icon_sizes = elgg_get_config('icon_sizes');
$default_bg_image = elgg_get_site_url() . 'mod/' . PLUGIN_ID . '/graphics/iconbg.png';
$background_image = elgg_trigger_plugin_hook('au_subgroups', 'bg_image', null, $default_bg_image);
$font_size = array(
	'tiny' => 2,
	'small' => 5,
	'medium' => 10,
	'large' => 12,
	'master' => 12
);
?>
ul.elgg-menu-owner-block-z-au_subgroups {
margin-top: 20px;
margin-bottom: 20px;
}

.au_subgroups_group_icon {
display: inline-block;
position: relative;
}

.au_subgroups_group_icon span.au_subgroup {
display: block;
position: absolute;
right: 0;
}


.au_subgroups_subtext {
padding-top: 5px;
}


/** move to subgroup of another **/
.au-subgroups-throbber {
background-image: url('<?php echo elgg_get_site_url(); ?>/_graphics/ajax_loader_bw.gif');
background-position: center center;
background-repeat: no-repeat;
min-height: 35px;
}

.au-subgroups-search {
width: 150px;
}

.au-subgroups-search-results {
width: 500px;
border: 2px solid #E4E4E4;
float: right;
}

.au-subgroups-result-col {
width: 250px;
float: left;
}

.au-subgroups-parentable {
background-color: white;
cursor: pointer;
border-top: 1px solid black;
}

.au-subgroups-parentable:hover {
background-color: #FAFFA8;
}

.au-subgroups-non-parentable {
cursor: not-allowed;
background-color: #cccccc;
border-top: 1px solid black;
}

.au-subgroups-non-parentable a,
.au-subgroups-non-parentable a:hover {
color: #454545;
text-decoration: none;
cursor: not-allowed;
}

<?php
foreach ($icon_sizes as $size => $value) {
	?>

	.au_subgroups_group_icon-<?php echo $size; ?> {
	width: <?php echo $value['w']; ?>px;
	height: <?php echo $value['h']; ?>px;
	overflow: hidden;
	}

	.au_subgroup_icon-<?php echo $size; ?> {
	color: white;
	bottom: 0px;
	background: url(<?php echo $background_image ?>);
	width: 100%;
	border-left: 0;
	border-right: 0;
	padding: 3px;
	text-align: center;
	font-size: <?php echo $font_size[$size]; ?>px;
	}
	<?php
}
