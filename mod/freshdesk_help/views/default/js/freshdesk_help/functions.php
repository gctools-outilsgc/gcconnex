<?php

?>
//<script>

/** Function that takes array of categories and removes duplicates
 *
 * @param {array} array               Knowledge base categories
 */
function uniqueObjects(array){
  for(var a = 0; a < array.length; a++){
    array[a] = JSON.stringify(array[a]);
  }

  var result = unique(array);

  for(var a = 0; a < result.length; a++){
    result[a] = JSON.parse(result[a]);
  }
  return result;
}

function unique(list) {
 var result = [];
 $.each(list, function(i, e) {
   if ($.inArray(e, result) == -1) result.push(e);
 });
 return result;
}

/** Function that gets plugin settings */

function get_details(){
  var details = [];

  details['domain'] =  <?php echo '"'. elgg_get_plugin_setting("domain", "freshdesk_help").'"'; ?>;
  details['api_key'] =  <?php echo '"'. elgg_get_plugin_setting("apikey", "freshdesk_help").'"'; ?>;
  details['product_id'] = <?php echo (int) elgg_get_plugin_setting("product_id", "freshdesk_help"); ?>;
  details['embed_product_id'] = <?php echo (int) elgg_get_plugin_setting("embed_product_id", "freshdesk_help"); ?>;

  return details;
}

/** Handle switching to folder */

function displayFolder(link){
  var target = $(link).attr('href');
  $('.categories').fadeOut().parent().find(target).delay(500).fadeIn();
  $('#explore-header').fadeOut();
}

/** Handle switching back to categories */

function displayCategories(link){
  $('.folder-display:not(:hidden)').fadeOut().parent().find('.categories').delay(500).fadeIn();
  $('#results-en').focus();
  $('#explore-header').delay(500).fadeIn();
}


/** Function that count occurrences of a substring in a string;
 * @param {String} string               The string
 * @param {String} subString            The sub string to search for
 * @param {Boolean} [allowOverlapping]  Optional. (Default:false)
 *
 * @author Vitim.us https://gist.github.com/victornpb/7736865
 * @see Unit Test https://jsfiddle.net/Victornpb/5axuh96u/
 * @see http://stackoverflow.com/questions/4009756/how-to-count-string-occurrence-in-string/7924240#7924240
 */
function occurrences(string, subString, allowOverlapping) {

    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}

/** Search function on search box
 * @param {string} search query      Knowledge base article query
*/

function searchArticles(search, lang){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(search).val(), count = 0;

        var gatheredResults = [];
        //remove previous query
        $('#searchResults .article-listing').remove();

        //only go if three characters are entered
        if($(search).val().length >= 3){
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
                    $(result).find('.head-toggle').attr('aria-controls', id+'-search');
                    $(result).find('.article-content').attr('id', id+'-search');
                    $(result).find('.article-hi').css('display', 'inherit');

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
            if($('#results-listing li').length > 0){
              $('#searchResults .article-panel').show();
            } else {
              $('#searchResults .article-panel').hide();
            }
            $('.search-info').hide()
            $("#filter-count").text(elgg.echo('freshdesk:knowledge:search:results:'+lang, [count]));
          } else {
            $('#searchResults .article-panel').hide();
            $('.search-info').show()
            $("#filter-count").text("");
          }
    }

/** Search function to match articles in ticket subject
 * @param {string} search query      Knowledge base article query
*/

function matchArticles(search, lang){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(search).val(), count = 0;

      var gatheredResults = [];
      //remove previous query
        $('#searchResults .article-listing').remove();

      //only go if three characters are entered
      if($(search).val().length >= 3){
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
                  $(result).find('.head-toggle').attr('aria-controls', id+'-search');
                  $(result).find('.article-content').attr('id', id+'-search');
                  $(result).find('.article-hi').css('display', 'inherit');

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
          $("#filter-count").text(elgg.echo('freshdesk:knowledge:search:results:'+lang, [count]));
          if(count > 0){
            $('.relatedArticles a').text(elgg.echo('freshdesk:ticket:matching:'+lang, [count])).parent().show();
          } else {
            $('.relatedArticles').hide();
          }
        } else {
          $('#searchResults .article-panel').hide();
          $('.search-info').show()
          $('.relatedArticles').hide();
          $("#filter-count").text("");
        }
    }

/** Search function to match articles in ticket subject
 * @param {HTML} form      Submit form
 * @param {string} lang    current langauge
 * @param {string} source  Which form this is coming from
*/

function submitTicket(form, lang, source){
  //load api details
  var details = get_details();
  var yourdomain = details['domain'];
  var api_key = details['api_key'];
  var formdata = new FormData();

  if(source == 'embed'){
    var product = details['embed_product_id'];
  } else {
    var product = details['product_id'];
  }

  //gather inputs
  formdata.append('product_id', product);
  formdata.append('description', $(form).find('#description').val());
  formdata.append('email', $(form).find('#email').val());
  formdata.append('subject', $(form).find('#subject').val());
  formdata.append('priority', '1');
  formdata.append('status', '2');
  formdata.append('source', '9');

  //check if file is attached
  if($('#attachment')[0].files[0]){
    formdata.append('attachments[]', $(form).find('#attachment')[0].files[0]);
  }
  
  //send api call
  $.ajax(
    {
      url: "https://"+yourdomain+".freshdesk.com/api/v2/tickets",
      type: 'POST',
      contentType: false,
      processData: false,
      headers: {
        "Authorization": "Basic " + btoa(api_key + ":x")
      },
      data: formdata,
      success: function(data, textStatus, jqXHR) {
        elgg.action('ticket/feedback', { data: { language: lang, type: 'success', direct: source }, success: function (wrapper) { location.reload(); } });
      },
      error: function(jqXHR, tranStatus) {
        elgg.action('ticket/feedback', { data: { language: lang, type: 'fail', direct: source, code: jqXHR.status }, success: function (wrapper) { location.reload(); } });
      }
    }
  );


}
