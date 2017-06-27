<?php ?>

<ul class="nav nav-tabs nav-tabs-language">
  <li class="active"><a data-toggle="tab" href="#article-search-tab"><?php echo elgg_echo('Search Helpdesk');?></a></li>
  <li><a data-toggle="tab" href="#ticket"><?php echo elgg_echo('freshdesk:ticket:title'); ?></a></li>
</ul>

 <div class="tab-content tab-content-border">
 <?php
 echo '<div id="article-search-tab" class="tab-pane active">';
 echo '<label class="h3 mrgn-tp-sm" for="article-search">Search all the articles</label>';

//create search panel
 echo elgg_view('input/text', array(
   'id' => 'article-search',
   'name' => 'Search Articles',
 ));

 echo '<span class="search-info">Search helpdesk articles to find the information you are looking for. For more information vist our <a href="https://gcconnex.gctools-outilsgc.ca/en/support/home">Support Home</a>.</span>';
 echo '<div aria-live="polite" id="filter-count"></div>';

 echo '<div id="searchResults"></div>';

//retrieve articles
  $str = file_get_contents(get_site_by_url().'mod/freshdesk_help/actions/articles/articles.json');
  if($str){
    $articles = json_decode($str, true);
    echo '<div id="results"><h3>Explore Articles</h3>'.$articles[get_current_language()].'</div>';
  } else {
    echo '<div id="results"><div class="alert alert-info">Add articles by fetching them in the admin settings.</div></div>';
  }

  echo '</div>';

//submit ticket panel
 echo '<div id="ticket" class="tab-pane">';
 echo elgg_view_form('ticket', array('action' => 'action/submit-ticket', 'class' => 'panel', 'enctype' => 'multipart/form-data'));
 echo '</div>';

  ?>

 </div>

  <script>
   $(document).ready(function(){

    $("#article-search").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        var gatheredResults = [];
        //remove previous query
        $('#searchResults .help-article').remove();

        //only go if three characters are entered
        if($(this).val().length >= 3){
            // Loop through the comment list
            $("#results .help-article").each(function(){
     
                // If the list item does not contain the text
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
     
                // Show the list item if the phrase matches and increase the count by 1
                } else {

                    //clone item
                    var result = $(this).clone();
                    //retrieve attributes
                    var href = $(result).find('.head-toggle').attr('href');
                    var id = $(result).find('.panel-body').attr('id');
                    //change clone to not mess with original
                    $(result).find('.head-toggle').attr('href', href+'-search');
                    $(result).find('.head-toggle').attr('aria-controls', id+'-search')
                    $(result).find('.panel-body').attr('id', id+'-search')

                    //add clone and occurrence count to array for sorting
                    var item = [occurrences($(result).text().toLowerCase(), filter), $(result)];

                    gatheredResults.push(item);

                }
            });
     
            //sort results from most occurrences of query to least amount
            gatheredResults.sort(function(a, b){ return b[0] - a[0]; });

            //add results
            $.each(gatheredResults, function (key,value) {
              $(value[1]).appendTo('#searchResults');
              //increase count
              count++;
            });

            $('.search-info').hide()
            $("#filter-count").text("Showing "+count+" results.");
          } else {
            $('.search-info').show()
            $("#filter-count").text("");
          }
    });




  $("#subject").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        var gatheredResults = [];
        //remove previous query
        $('#searchResults .help-article').remove();

        //only go if three characters are entered
        if($(this).val().length >= 3){
            // Loop through the comment list
            $("#results .help-article").each(function(){
     
                // If the list item does not contain the text
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
     
                // Show the list item if the phrase matches and increase the count by 1
                } else {

                    //clone item
                    var result = $(this).clone();
                    //retrieve attributes
                    var href = $(result).find('.head-toggle').attr('href');
                    var id = $(result).find('.panel-body').attr('id');
                    //change clone to not mess with original
                    $(result).find('.head-toggle').attr('href', href+'-search');
                    $(result).find('.head-toggle').attr('aria-controls', id+'-search')
                    $(result).find('.panel-body').attr('id', id+'-search')

                    //add clone and occurrence count to array for sorting
                    var item = [occurrences($(result).text().toLowerCase(), filter), $(result)];

                    gatheredResults.push(item);

                }
            });
     
            //sort results from most occurrences of query to least amount
            gatheredResults.sort(function(a, b){ return b[0] - a[0]; });

            //add results
            $.each(gatheredResults, function (key,value) {
              $(value[1]).appendTo('#searchResults');
              //increase count
              count++;
            });

            $('.search-info').hide()
            $("#filter-count").text("Showing "+count+" results.");
            if(count > 0){
              $('.relatedArticles a').text(count+' matching articles').parent().show();
            } else {
              $('.relatedArticles').hide();
            }
          } else {
            $('.search-info').show()
            $('.relatedArticles').hide();
            $("#filter-count").text("");
          }
    });


   });

   </script>
