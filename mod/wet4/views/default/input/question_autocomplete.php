<?php
$name = elgg_extract("name", $vars); // input name of the selected group
$id = elgg_extract("id", $vars);

echo '<div id="suggestedText"></div>';

echo elgg_view('input/text', array(
  'name' => $name,
  'id' => $id,
  'class' => ''
));

echo '<div id="searchResults" aria-live="passive" style="display:none;" class="question-auto"><p><b>Based on your question, we have found similar questions already asked.</b></p></div>'
?>

<script>

$(document).ready(function() {
    $('#<?php echo $id; ?>').on('keyup', function(){
      var input = $(this).val();
      if(input.length > 3){
        elgg.action("question/autocomplete", {
          data: {
              name: input,
              owner: <?php echo elgg_get_page_owner_guid(); ?>
          },
          success: function (wrapper) {
            $('#searchResults .suggestion-list').remove();
            $('#searchResults').append(wrapper.output.question);
            if($('#searchResults ul').length){
              $('#searchResults').css('display', 'block');
            } else {
              $('#searchResults').css('display', 'none');
            }
          }
        });
      } else if(input.length <= 3){
        $('#searchResults').css('display', 'none');
        $('#searchResults .suggestion-list').remove();
      }
    });
});

</script>
