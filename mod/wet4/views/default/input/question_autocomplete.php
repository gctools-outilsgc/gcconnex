<?php
$name = elgg_extract("name", $vars); // input name of the selected group
$id = elgg_extract("id", $vars);

echo '<div id="suggestedText"></div>';

echo elgg_view('input/text', array(
  'name' => $name,
  'id' => $id,
  'class' => ''
));

echo '<div id="searchResults"></div>'
?>

<script>

$(document).ready(function() {
    $('<?php echo $id; ?>').on('keyup', function(){
      var input = $(this).val();
      if(input.length > 3){
      elgg.action("question/autocomplete", {
      data: {
          name: $(this).val(),
          owner: <?php echo elgg_get_page_owner_guid(); ?>
      },
      success: function (wrapper) {

      }
      });
    }
    });
});

</script>
