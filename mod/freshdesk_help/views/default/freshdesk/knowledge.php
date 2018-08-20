<?php ?>

<ul class="nav nav-tabs nav-tabs-language">
  <li class="active"><a data-toggle="tab" href="#article-search-tab"><?php echo elgg_echo('freshdesk:knowledge:title');?></a></li>
  <li><a data-toggle="tab" href="#ticket"><?php echo elgg_echo('freshdesk:ticket:title'); ?></a></li>
</ul>

 <div class="tab-content tab-content-border">
 <?php
 echo '<div id="article-search-tab" class="tab-pane active">';
 //retrieve articles
  $str = file_get_contents(elgg_get_config("dataroot").'freshdesk_help/articles.json');
  if($str){
    $articles = json_decode($str, true);

    echo '<h2 class="mrgn-tp-sm h3"><label class="mrgn-tp-sm" for="article-search">'.elgg_echo('freshdesk:knowledge:search:title').'</label></h2>';

    //create search panel
    echo elgg_view('input/text', array(
      'id' => 'article-search',
      'name' => elgg_echo('freshdesk:knowledge:search:title'),
      'onkeyup'  => 'searchArticles(this, "'.get_current_language().'")',
    ));

    echo '<span class="search-info">'.elgg_echo('freshdesk:knowledge:search:info').'</span>';

    echo '<div aria-live="polite" id="filter-count"></div>';

    echo '<div id="searchResults"><div class="article-panel"><ul id="results-listing"></ul></div></div>';


    echo '<h2 id="explore-header" class="h3">'.elgg_echo('freshdesk:knowledge:explore:title').'</h2>';
    echo '<div id="results-en">'.$articles[get_current_language()].'</div>';
  } else {
    echo '<div id="results"><section class="alert alert-info"><h2>'.elgg_echo('freshdesk:warning:header').'</h2><p>'.elgg_echo('freshdesk:warning:body').'</p></section></div>';
  }

  echo '</div>';

//submit ticket panel
 echo '<div id="ticket" class="tab-pane">';
 echo elgg_view_form('ticket', array('class' => 'form-ticket-panel', 'enctype' => 'multipart/form-data'));
 echo '</div>';

  ?>
 </div>

<?php echo elgg_view('contactform/contactform'); ?>
