<?php
  $group = $vars['entity'];
  $parent = au_subgroups_get_parent_group($group);
  
  if ($parent) {
?>

<div class="elgg-subtext au_subgroups_subtext">
  <?php
  $link = elgg_view('output/url', array(
      'href' => $parent->getURL(),
      'text' => $parent->name,
      'is_trusted' => true
   ));
  
  echo elgg_echo('au_subgroups:subgroup:of', array($link));
  ?>
  <br><br>
</div>
<?php
  }