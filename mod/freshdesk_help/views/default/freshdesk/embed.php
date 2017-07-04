<?php ?>

<ul class="nav nav-tabs nav-tabs-language">
  <li class="active"><a data-toggle="tab" href="#article-search-tab"><?php echo elgg_echo('freshdesk:knowledge:title');?></a></li>
  <li><a data-toggle="tab" href="#ticket"><?php echo elgg_echo('freshdesk:ticket:title'); ?></a></li>
</ul>

 <div class="tab-content tab-content-border">
 <?php
 echo '<div id="article-search-tab" class="tab-pane active">';
 echo '<label class="h3 mrgn-tp-sm" for="article-search">'.elgg_echo('freshdesk:knowledge:search:title').'</label>';

//create search panel
 echo elgg_view('input/text', array(
   'id' => 'article-search',
   'name' => elgg_echo('freshdesk:knowledge:search:title'),
 ));

 echo '<span class="search-info">'.elgg_echo('freshdesk:knowledge:search:info').'</span>';
 echo '<div aria-live="polite" id="filter-count"></div>';

 echo '<div id="searchResults"><div class="article-panel"><ul id="results-listing"></ul></div></div>';

//retrieve articles
  $str = file_get_contents(get_site_by_url().'mod/freshdesk_help/actions/articles/articles.json');
  if($str){
    $articles = json_decode($str, true);
    echo '<h2 class="h3">'.elgg_echo('freshdesk:knowledge:explore:title').'</h2>';
    echo '<div id="results-en">'.$articles[get_current_language()].'</div>';
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
        $('#searchResults .article-listing').remove();

        //only go if three characters are entered
        if($(this).val().length >= 3){
            // Loop through the comment list
            $("#results-en .article-listing").each(function(){
     
                // If the list item does not contain the text
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
     
                // Show the list item if the phrase matches and increase the count by 1
                } else {

                    //clone item
                    var result = $(this).clone();
                    //retrieve attributes
                    var href = $(result).find('.head-toggle').attr('href');
                    var id = $(result).find('.article-content').attr('id');
                    //change clone to not mess with original
                    $(result).find('.head-toggle').attr('href', href+'-search');
                    $(result).find('.head-toggle').attr('aria-controls', id+'-search')
                    $(result).find('.article-content').attr('id', id+'-search')

                    //add clone and occurrence count to array for sorting
                    var item = [occurrences($(result).text().toLowerCase(), filter), $(result)];

                    gatheredResults.push(item);

                }
            });
     
            //sort results from most occurrences of query to least amount
            gatheredResults.sort(function(a, b){ return b[0] - a[0]; });

            //add results
            $.each(gatheredResults, function (key,value) {
              $(value[1]).appendTo('#results-listing');
              //increase count
              count++;
            });

            $('#searchResults .article-panel').show();
            $('.search-info').hide()
            $("#filter-count").text(elgg.echo('freshdesk:knowledge:search:results', [count]));
          } else {
            $('#searchResults .article-panel').hide();
            $('.search-info').show()
            $("#filter-count").text("");
          }
    });




  $("#subject").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        var gatheredResults = [];
        //remove previous query
        $('#searchResults .article-listing').remove();

        //only go if three characters are entered
        if($(this).val().length >= 3){
            // Loop through the comment list
            $("#results-en .article-listing").each(function(){
     
                // If the list item does not contain the text
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
     
                // Show the list item if the phrase matches and increase the count by 1
                } else {

                    //clone item
                    var result = $(this).clone();
                    //retrieve attributes
                    var href = $(result).find('.head-toggle').attr('href');
                    var id = $(result).find('.article-content').attr('id');
                    //change clone to not mess with original
                    $(result).find('.head-toggle').attr('href', href+'-search');
                    $(result).find('.head-toggle').attr('aria-controls', id+'-search')
                    $(result).find('.article-content').attr('id', id+'-search')

                    //add clone and occurrence count to array for sorting
                    var item = [occurrences($(result).text().toLowerCase(), filter), $(result)];

                    gatheredResults.push(item);

                }
            });
     
            //sort results from most occurrences of query to least amount
            gatheredResults.sort(function(a, b){ return b[0] - a[0]; });

            //add results
            $.each(gatheredResults, function (key,value) {
              $(value[1]).appendTo('#results-listing');
              //increase count
              count++;
            });

            $('#searchResults .article-panel').show();
            $('.search-info').hide()
            $("#filter-count").text(elgg.echo('freshdesk:knowledge:search:results', [count]));
            if(count > 0){
              $('.relatedArticles a').text(elgg.echo('freshdesk:ticket:matching', [count])).parent().show();
            } else {
              $('.relatedArticles').hide();
            }
          } else {
            $('#searchResults .article-panel').hide();
            $('.search-info').show()
            $('.relatedArticles').hide();
            $("#filter-count").text("");
          }
    });



//delete me later - code for easy and quick changes to UI
/*
var yourdomain = <?php echo '"'.elgg_get_plugin_setting("domain", "freshdesk_help").'"'; ?>;
var api_key = <?php echo  '"'.elgg_get_plugin_setting("apikey", "freshdesk_help").'"'; ?>;
var portal_id = <?php echo  (int) elgg_get_plugin_setting("portal_id", "freshdesk_help"); ?>;
var acceptedCategoriesEN = [];
var acceptedCategoriesFR = [];

$.ajax(
  {
    url: "https://"+yourdomain+".freshdesk.com/api/v2/solutions/categories/en",
    type: 'GET',
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    headers: {
      "Authorization": "Basic " + btoa(api_key + ":x")
    },
    success: function(data, textStatus, jqXHR) {
      var category = JSON.parse(JSON.stringify(data));
      for (var c = 0; c < category.length; c++){
        if($.inArray(portal_id, category[c].visible_in_portals) > -1){ //categories that appear on GCconnex
          acceptedCategoriesEN.push(category[c]);
        }
      }

      acceptedCategoriesEN = uniqueObjects(acceptedCategoriesEN); //removed duplicate categories

      $.each(acceptedCategoriesEN, function (key,value) {

           $('#categories').append("<div class='category-card'><div class='article-cat'><div class='heading'><h3 >"  +value.name + "</h3></div><div><ul class='folders' id='" + value.id + "-en'></ul> </div></div></div></div>");

           $.ajax(
             {
               url: "https://"+yourdomain+".freshdesk.com/api/v2/solutions/categories/"+value.id+"/folders/en",
               type: 'GET',
               contentType: "application/json; charset=utf-8",
               dataType: "json",
               headers: {
                 "Authorization": "Basic " + btoa(api_key + ":x")
               },
               success: function(data, textStatus, jqXHR) {
                 var folder = JSON.parse(JSON.stringify(data));

                  $.each(folder, function (key2,value2) {

                    //if(value2.visibility == 1){
                      $('#'+value.id+'-en').append("<li class='folder'><a onclick='displayFolder(this)' href='#"+ value2.id + "-en'><div>"  +value2.name + "</div></a></li>");
                      $('#results-en').append("<div class='folder-display' id='" + value2.id + "-en'><div class='heading-panel'><a class='icon-unsel' onclick='displayCategories(this)' href='#categories'><i class='fa fa-arrow-left fa-lg' aria-hidden='true'></i></a> <div><h3>"+value2.name+"</h3></div></div></div>");
                    //}

                    $.ajax({

                        url: "https://"+yourdomain+".freshdesk.com/api/v2/solutions/folders/"+value2.id+"/articles/en",
                        type: 'GET',
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        headers: {
                          "Authorization": "Basic " + btoa(api_key + ":x")
                        },
                        success: function(data, textStatus, jqXHR) {
                          var article = JSON.parse(JSON.stringify(data));

                            $('#'+value2.id+'-en').append("<div class='article-panel'></div>");
                            var list = "<ul>";
                            $.each(article, function (key3,value3) {//<span class='collapse-plus fa fa-plus-square-o fa-lg' aria-hidden='true'></span>
                              //if(value3.status == 2){
                                list += "<li class='article-listing'><a class='head-toggle collapsed' href='#"+ value3.id + "-en' data-toggle='collapse' aria-expanded='false' aria-controls='"+ value3.id +"-en'><div><h5><span class='collapse-plus fa fa-minus-square-o fa-lg' aria-hidden='true'></span>" + value3.title + "</h5></div></a><div id='" + value3.id +
                                "-en' class='collapse article-content'><span>"+ value.name+" > " + value2.name +"</span>" + value3.description + " </div> </div></li>";
                              //}
                            });
                            list += '</ul><a onclick="displayCategories(this)" href="#categories" class="wb-inv">Back</a>';
                            $('#'+value2.id+"-en .article-panel").append(list);
                        }
                      });

                  });

               }
             }

           );

       });
    }
  });*/


   });

   </script>
