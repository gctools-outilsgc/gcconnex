<?php

echo '<label class="h3 mrgn-tp-sm" for="article-search">Search all the articles</label>';

echo elgg_view('input/text', array(
  'id' => 'article-search',
  'name' => 'Search Articles',
));

?>
