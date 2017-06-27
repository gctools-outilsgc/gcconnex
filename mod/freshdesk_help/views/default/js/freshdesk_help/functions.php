<?php

?>
//<script>

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

function provide_feedback(){

}

function get_details(){
  var details = [];

  details['domain'] =  <?php echo (string) elgg_get_plugin_setting("domain", "freshdesk_help"); ?>;
  details['api_key'] =  <?php echo (string) elgg_get_plugin_setting("apikey", "freshdesk_help"); ?>;
  details['product_id'] = <?php echo (int) elgg_get_plugin_setting("product_id", "freshdesk_help"); ?>;

  return details;
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
