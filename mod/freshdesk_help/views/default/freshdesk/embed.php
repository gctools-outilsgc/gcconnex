<?php
$lang = (string) get_input('lang');

if(!$lang){
  $lang = "en";
}

?>

<ul class="nav nav-tabs nav-tabs-language">
  <li class="active"><a data-toggle="tab" href="#article-search-tab"><?php echo elgg_echo('freshdesk:knowledge:title', array(), $lang);?></a></li>
  <li><a data-toggle="tab" href="#ticket"><?php echo elgg_echo('freshdesk:ticket:title', array(), $lang); ?></a></li>
</ul>

 <div class="tab-content tab-content-border">
 <?php
 echo '<div id="article-search-tab" class="tab-pane active">';
 //retrieve articles
  $str = file_get_contents(get_site_by_url().'mod/freshdesk_help/actions/articles/pedia-articles.json');
  if($str){
    $articles = json_decode($str, true);

    echo '<h2 class="mrgn-tp-sm h3"><label class="h3 mrgn-tp-sm" for="article-search">'.elgg_echo('freshdesk:knowledge:search:title', array(), $lang).'</label></h2>';

    //create search panel
    echo elgg_view('input/text', array(
      'id' => 'article-search',
      'name' => elgg_echo('freshdesk:knowledge:search:title', array(), $lang),
      'onkeyup'  => 'searchArticles(this, "'.$lang.'")'
    ));

    echo '<span class="search-info">'.elgg_echo('freshdesk:knowledge:search:info', array(), $lang).'</span>';
    echo '<div aria-live="polite" id="filter-count"></div>';

    echo '<div id="searchResults"><div class="article-panel"><ul id="results-listing"></ul></div></div>';


    echo '<h2 id="explore-header" class="h3">'.elgg_echo('freshdesk:knowledge:explore:title', array(), $lang).'</h2>';
    echo '<div id="results-en">'.$articles[$lang].'</div>';
  } else {
    echo '<div id="results"><section class="alert alert-info"><h2>'.elgg_echo('freshdesk:warning:header').'</h2><p>'.elgg_echo('freshdesk:warning:body').'</p></section></div>';
  }

  echo '</div>';

//submit ticket panel
 echo '<div id="ticket" class="tab-pane">';
 echo elgg_view_form('ticket', array('action' => 'action/submit-ticket-pedia', 'class' => 'form-ticket-panel', 'enctype' => 'multipart/form-data'));
 echo '</div>';

  ?>
  <script>

    // Fix heights on page load
    equalizeHeights(".article-cat:visible");

    // Fix heights on window resize
    var iv = null;
    $(window).resize(function() {

      if(iv !== null) {
        window.clearTimeout(iv);
      }

      // Needs to be a timeout function so it doesn't fire every ms of resize
      iv = setTimeout(function() {
              equalizeHeights(".article-cat:visible");
      }, 120);
    });

  </script>

 </div>

 <style>
 .tab-content {
   background-color: #f9f9f9;
 }
 body {
   background: none !important;
 }
 main {
   margin:10px;
   max-width:1120px;
 }
  main .btn-primary {
    background-color: #1f1f72;
    border-color: #1f1f72;
  }

  .btn-primary:hover {
    background-color: #1C507F;
    border-color: #1C507F;
  }

  .btn-primary:active {
    background-color: #1C507F;
  }

  a {
    color: #284162;
  }
  a:hover, a:focus {
    color: #41689c;
  }

  .btn-primary[disabled] {
    background-color: #1f1f72;
    border-color: #1f1f72;
  }
 </style>
