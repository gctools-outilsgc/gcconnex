<?php
$name = elgg_extract("name", $vars);
$id = elgg_extract("id", $vars);

echo elgg_view('input/text', array(
  'name' => $name,
  'id' => $id,
  'required' => 'required'
));

echo '<div id="searchResults-'.$id.'" aria-live="polite" style="display:none;" class="question-auto"><p>'.elgg_echo('question:suggestion').'</p></div>'
?>

<script>

$(document).ready(function() {
    $('#<?php echo $id; ?>').on('keyup', function(){
      var id = "<?php echo $id; ?>";
      var input = $(this).val();
      if(input.length > 3){
        elgg.action("question/autocomplete", {
          data: {
              name: input,
          },
          success: function (wrapper) {
            $('#searchResults-'+id+' .suggestion-list').remove();
            $('#searchResults-'+id).append(wrapper.output.question);
            if($('#searchResults-'+id+' ul').length){
              $('#searchResults-'+id).css('display', 'block');
            } else {
              $('#searchResults-'+id).css('display', 'none');
            }
          }
        });
      } else if(input.length <= 3){
        $('#searchResults-'+id).css('display', 'none');
        $('#searchResults-'+id+' .suggestion-list').remove();
      }
    });
});

</script>
