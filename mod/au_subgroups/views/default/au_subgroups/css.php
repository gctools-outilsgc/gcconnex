<?php
  $icon_sizes = elgg_get_config('icon_sizes');
  $default_bg_image = elgg_get_site_url() . 'mod/au_subgroups/graphics/iconbg.png';
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
